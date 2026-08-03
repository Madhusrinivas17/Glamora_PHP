<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ServicesController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'live']);
    }

    public function index()
    {
        $servicesTable = $this->fetchTable('Services');
        $categoriesTable = $this->fetchTable('ServiceCategories');
        $beauticiansTable = $this->fetchTable('Beauticians');
        $offersTable = $this->fetchTable('Offers');
        $reviewsTable = $this->fetchTable('Reviews');
        $parloursTable = $this->fetchTable('Parlours');
        $favoritesTable = $this->fetchTable('Favorites');

        $query = $servicesTable->find()
            ->contain(['ServiceCategories'])
            ->where(['Services.is_active' => 1]);

        $categorySlug = $this->request->getQuery('category');
        $search = $this->request->getQuery('q');

        if (!empty($categorySlug)) {
            $category = $categoriesTable->find()->where(['slug' => $categorySlug])->first();
            if ($category) {
                $query->where(['Services.category_id' => $category->id]);
            }
        }

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Services.name LIKE' => '%' . $search . '%',
                    'Services.description LIKE' => '%' . $search . '%',
                ]
            ]);
        }

        $services = $query->all();
        $categories = $categoriesTable->find()->all();
        $beauticians = $beauticiansTable->find()->where(['availability_status' => 'available'])->all();
        $offers = $offersTable->find()->where(['is_active' => 1])->all();
        $reviews = $reviewsTable->find()->contain(['Users', 'Services'])->order(['Reviews.created' => 'DESC'])->limit(6)->all();
        $parlour = $parloursTable->find()->first();

        // User Favorites IDs array
        $userFavoriteIds = [];
        $identity = $this->Authentication->getIdentity();
        if ($identity) {
            $userFavoriteIds = $favoritesTable->find()
                ->where(['user_id' => $identity->id])
                ->all()
                ->extract('service_id')
                ->toArray();
        }

        $avgRating = $reviewsTable->find()->select(['avg' => $reviewsTable->query()->func()->avg('rating')])->first()['avg'] ?? 4.9;

        $this->set(compact('services', 'categories', 'beauticians', 'offers', 'reviews', 'categorySlug', 'search', 'avgRating', 'userFavoriteIds', 'parlour'));
    }

    public function view($id = null)
    {
        $servicesTable = $this->fetchTable('Services');
        $reviewsTable = $this->fetchTable('Reviews');
        $favoritesTable = $this->fetchTable('Favorites');
        $appointmentsTable = $this->fetchTable('Appointments');
        $parloursTable = $this->fetchTable('Parlours');

        $service = $servicesTable->find()
            ->contain(['ServiceCategories'])
            ->where(['Services.id' => $id])
            ->firstOrFail();

        // Sort reviews filter
        $sort = $this->request->getQuery('sort', 'newest');
        $reviewsQuery = $reviewsTable->find()
            ->contain(['Users'])
            ->where(['Reviews.service_id' => $id]);

        if ($sort === 'highest') {
            $reviewsQuery->order(['Reviews.rating' => 'DESC', 'Reviews.created' => 'DESC']);
        } elseif ($sort === 'lowest') {
            $reviewsQuery->order(['Reviews.rating' => 'ASC', 'Reviews.created' => 'DESC']);
        } else {
            $reviewsQuery->order(['Reviews.created' => 'DESC']);
        }
        $reviews = $reviewsQuery->all();

        // Rating Stats & Star Breakdown
        $totalReviews = count($reviews);
        $avgRating = $totalReviews > 0 ? (float)array_sum(array_column($reviews->toArray(), 'rating')) / $totalReviews : 5.0;

        $starCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($reviews as $rev) {
            $r = (int)$rev->rating;
            if (isset($starCounts[$r])) {
                $starCounts[$r]++;
            }
        }

        // Likes Count
        $totalLikes = $favoritesTable->find()->where(['service_id' => $id])->count();

        // Check if user is logged in & has completed an appointment for this service
        $identity = $this->Authentication->getIdentity();
        $isLiked = false;
        $completedAppointment = null;
        $canReview = false;

        if ($identity) {
            $isLiked = $favoritesTable->exists(['user_id' => $identity->id, 'service_id' => $id]);

            // Find completed appointment not yet reviewed
            $completedAppointment = $appointmentsTable->find()
                ->where([
                    'user_id' => $identity->id,
                    'service_id' => $id,
                    'status' => 'Completed'
                ])
                ->first();

            if ($completedAppointment) {
                $alreadyReviewed = $reviewsTable->exists([
                    'user_id' => $identity->id,
                    'appointment_id' => $completedAppointment->id
                ]);
                $canReview = !$alreadyReviewed;
            }
        }

        $relatedServices = $servicesTable->find()
            ->where(['category_id' => $service->category_id, 'id !=' => $service->id])
            ->limit(3)
            ->all();

        $parlour = $parloursTable->find()->first();

        $this->set(compact(
            'service',
            'reviews',
            'totalReviews',
            'avgRating',
            'starCounts',
            'totalLikes',
            'isLiked',
            'canReview',
            'completedAppointment',
            'relatedServices',
            'sort',
            'parlour'
        ));
    }

    public function toggleFavorite()
    {
        $this->request->allowMethod(['post']);
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'message' => 'Please login to favorite services.'
            ]));
        }

        $serviceId = (int)$this->request->getData('service_id');
        $favoritesTable = $this->fetchTable('Favorites');

        $existing = $favoritesTable->find()
            ->where(['user_id' => $identity->id, 'service_id' => $serviceId])
            ->first();

        if ($existing) {
            $favoritesTable->delete($existing);
            $status = 'unliked';
        } else {
            $fav = $favoritesTable->newEntity([
                'user_id' => $identity->id,
                'service_id' => $serviceId
            ]);
            $favoritesTable->save($fav);
            $status = 'liked';
        }

        $totalLikes = $favoritesTable->find()->where(['service_id' => $serviceId])->count();

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => true,
            'status' => $status,
            'total_likes' => $totalLikes
        ]));
    }

    public function favourites()
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            $this->Flash->info(__('Please log in to view your favorite services.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $favoritesTable = $this->fetchTable('Favorites');
        $favs = $favoritesTable->find()
            ->contain(['Services' => ['ServiceCategories']])
            ->where(['user_id' => $identity->id])
            ->all();

        $userFavoriteIds = array_column($favs->toArray(), 'service_id');

        $this->set(compact('favs', 'userFavoriteIds'));
    }

    public function live()
    {
        $parloursTable = $this->fetchTable('Parlours');
        $servicesTable = $this->fetchTable('Services');
        $categoriesTable = $this->fetchTable('ServiceCategories');
        $reviewsTable = $this->fetchTable('Reviews');

        // Query ONLY Open Parlours
        $openParlours = $parloursTable->find()->where(['is_open' => 1])->all();
        $categories = $categoriesTable->find()->all();

        $sort = $this->request->getQuery('sort', 'popular');
        $categoryFilter = $this->request->getQuery('category');

        // Query ONLY Active Services for Open Parlours
        $servicesQuery = $servicesTable->find()
            ->contain(['ServiceCategories', 'Reviews'])
            ->where(['Services.is_active' => 1]);

        if (!empty($categoryFilter)) {
            $cat = $categoriesTable->find()->where(['slug' => $categoryFilter])->first();
            if ($cat) {
                $servicesQuery->where(['category_id' => $cat->id]);
            }
        }

        if ($sort === 'price_low') {
            $servicesQuery->order(['Services.price' => 'ASC']);
        } else {
            $servicesQuery->order(['Services.id' => 'ASC']);
        }

        $services = $servicesQuery->all();
        $startingPrice = $servicesTable->find()->select(['min_price' => $servicesTable->query()->func()->min('price')])->first()['min_price'] ?? 15.00;
        $totalReviews = $reviewsTable->find()->count();
        $avgRating = $reviewsTable->find()->select(['avg' => $reviewsTable->query()->func()->avg('rating')])->first()['avg'] ?? 4.9;

        // User Favorites IDs array
        $userFavoriteIds = [];
        $identity = $this->Authentication->getIdentity();
        if ($identity) {
            $favoritesTable = $this->fetchTable('Favorites');
            $userFavoriteIds = $favoritesTable->find()
                ->where(['user_id' => $identity->id])
                ->all()
                ->extract('service_id')
                ->toArray();
        }

        $this->set(compact('openParlours', 'services', 'categories', 'startingPrice', 'totalReviews', 'avgRating', 'sort', 'categoryFilter', 'userFavoriteIds'));
    }
}
