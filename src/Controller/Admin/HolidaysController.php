<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class HolidaysController extends AdminAppController
{
    public function index()
    {
        $holidaysTable = $this->fetchTable('Holidays');
        $holidays = $holidaysTable->find()->order(['holiday_date' => 'ASC'])->all();

        $this->set(compact('holidays'));
    }

    public function add()
    {
        $holidaysTable = $this->fetchTable('Holidays');
        $holiday = $holidaysTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $holiday = $holidaysTable->patchEntity($holiday, $this->request->getData());
            if ($holidaysTable->save($holiday)) {
                $this->Flash->success(__('Holiday added! Bookings will be blocked on this date.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Failed to add holiday.'));
            }
        }

        $this->set(compact('holiday'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $holidaysTable = $this->fetchTable('Holidays');
        $holiday = $holidaysTable->get($id);

        if ($holidaysTable->delete($holiday)) {
            $this->Flash->success(__('Holiday removed. Date is now open for bookings.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
