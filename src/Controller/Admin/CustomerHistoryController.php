<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class CustomerHistoryController extends AdminAppController
{
    public function index()
    {
        $usersTable = $this->fetchTable('Users');
        $customerHistoriesTable = $this->fetchTable('CustomerHistories');

        $customers = $usersTable->find()
            ->where(['role' => 'user'])
            ->contain(['Appointments' => ['Services'], 'CustomerHistories'])
            ->order(['full_name' => 'ASC'])
            ->all();

        $userId = $this->request->getQuery('user_id');
        $selectedCustomer = null;
        $customerVisits = [];

        if ($userId) {
            $selectedCustomer = $usersTable->find()
                ->where(['id' => $userId])
                ->contain(['Appointments' => ['Services', 'Beauticians', 'Payments'], 'CustomerHistories'])
                ->first();

            if ($selectedCustomer) {
                $customerVisits = $customerHistoriesTable->find()
                    ->where(['user_id' => $selectedCustomer->id])
                    ->order(['visit_date' => 'DESC'])
                    ->all();
            }
        }

        $this->set(compact('customers', 'selectedCustomer', 'customerVisits', 'userId'));
    }
}
