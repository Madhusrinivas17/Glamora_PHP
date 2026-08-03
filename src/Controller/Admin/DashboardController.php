<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class DashboardController extends AdminAppController
{
    public function index()
    {
        $appointmentsTable = $this->fetchTable('Appointments');
        $usersTable = $this->fetchTable('Users');
        $parloursTable = $this->fetchTable('Parlours');
        $reviewsTable = $this->fetchTable('Reviews');
        $favoritesTable = $this->fetchTable('Favorites');

        $today = date('Y-m-d');
        $parlour = $parloursTable->find()->first();

        // Status Counts for Admin Metrics Cards
        $pendingCount = $appointmentsTable->find()->where(['status' => 'Pending'])->count();
        $confirmedCount = $appointmentsTable->find()->where(['status' => 'Confirmed'])->count();
        $completedCount = $appointmentsTable->find()->where(['status' => 'Completed'])->count();
        $cancelledCount = $appointmentsTable->find()->where(['status' => 'Cancelled'])->count();
        $totalAppointmentsCount = $appointmentsTable->find()->count();

        // Revenue calculation
        $totalRevenueQuery = $appointmentsTable->find()
            ->select(['total' => $appointmentsTable->query()->func()->sum('total_price')])
            ->where(['status IN' => ['Confirmed', 'Completed']])
            ->first();
        $totalRevenue = (float)($totalRevenueQuery['total'] ?? 0.00);

        // Customers, Reviews, Likes stats
        $totalCustomers = $usersTable->find()->where(['role' => 'user'])->count();
        $totalReviews = $reviewsTable->find()->count();
        $avgRating = $reviewsTable->find()->select(['avg' => $reviewsTable->query()->func()->avg('rating')])->first()['avg'] ?? 4.9;
        $totalLikes = $favoritesTable->find()->count();

        // Today's Bookings
        $todaysBookings = $appointmentsTable->find()
            ->contain(['Users', 'Services', 'Beauticians'])
            ->where(['appointment_date' => $today])
            ->order(['appointment_time' => 'ASC'])
            ->all();
        $todaysBookingsCount = count($todaysBookings);

        // Recent Bookings Stream
        $recentBookings = $appointmentsTable->find()
            ->contain(['Users', 'Services', 'Beauticians'])
            ->order(['Appointments.created' => 'DESC'])
            ->limit(8)
            ->all();

        // Recent Reviews Stream
        $recentReviews = $reviewsTable->find()
            ->contain(['Users', 'Services'])
            ->order(['Reviews.created' => 'DESC'])
            ->limit(5)
            ->all();

        // Analytics: Most Booked Service
        $mostBookedService = $appointmentsTable->find()
            ->select([
                'service_id',
                'name' => 'Services.name',
                'booking_count' => $appointmentsTable->query()->func()->count('Appointments.id')
            ])
            ->contain(['Services'])
            ->group(['service_id', 'Services.name'])
            ->order(['booking_count' => 'DESC'])
            ->first();

        $this->set(compact(
            'parlour',
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount',
            'totalAppointmentsCount',
            'totalRevenue',
            'totalCustomers',
            'totalReviews',
            'avgRating',
            'totalLikes',
            'todaysBookings',
            'todaysBookingsCount',
            'recentBookings',
            'recentReviews',
            'mostBookedService'
        ));
    }

    public function toggleStatus()
    {
        $this->request->allowMethod(['post']);
        $parloursTable = $this->fetchTable('Parlours');
        $parlour = $parloursTable->find()->first();

        if ($parlour) {
            $parlour->is_open = ($parlour->is_open == 1) ? 0 : 1;
            $parloursTable->save($parlour);

            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => true,
                'is_open' => (int)$parlour->is_open,
                'status_text' => $parlour->is_open ? 'OPEN NOW' : 'CLOSED',
                'badge_class' => $parlour->is_open ? 'bg-success' : 'bg-danger'
            ]));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Parlour record not found.'
        ]));
    }
}
