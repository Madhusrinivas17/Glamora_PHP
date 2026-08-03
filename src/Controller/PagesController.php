<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class PagesController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['home', 'display']);
    }

    public function home()
    {
        $this->viewBuilder()->disableAutoLayout();

        $servicesTable = $this->fetchTable('Services');
        $reviewsTable = $this->fetchTable('Reviews');
        $parloursTable = $this->fetchTable('Parlours');

        $services = $servicesTable->find()->contain(['ServiceCategories'])->where(['Services.is_active' => 1])->limit(6)->all();
        $avgRating = $reviewsTable->find()->select(['avg' => $reviewsTable->query()->func()->avg('rating')])->first()['avg'] ?? 4.9;
        $totalReviews = $reviewsTable->find()->count();
        $parlour = $parloursTable->find()->first();

        $this->set(compact('services', 'avgRating', 'totalReviews', 'parlour'));
    }
}
