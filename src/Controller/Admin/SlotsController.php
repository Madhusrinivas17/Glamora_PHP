<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class SlotsController extends AdminAppController
{
    public function index()
    {
        $slotsTable = $this->fetchTable('Slots');
        $beauticiansTable = $this->fetchTable('Beauticians');

        $selectedBeautician = $this->request->getQuery('beautician_id');

        $query = $slotsTable->find()
            ->contain(['Beauticians'])
            ->order(['Slots.start_time' => 'ASC']);

        if ($selectedBeautician === 'unassigned') {
            $query->where(['Slots.beautician_id IS' => null]);
        } elseif (!empty($selectedBeautician)) {
            $query->where(['Slots.beautician_id' => (int)$selectedBeautician]);
        }

        $slots = $query->all();

        $allBeauticians = $beauticiansTable->find()->all();
        $beauticians = $beauticiansTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        // Collapse 30 duplicate dates into clean unique Everyday Time Slots per Beautician!
        $uniqueSlotsByBeautician = [];
        foreach ($slots as $slot) {
            $bName = $slot->beautician ? $slot->beautician->name : 'Unassigned / Any Beautician';
            $timeKey = is_object($slot->start_time) ? $slot->start_time->format('H:i:s') : (string)$slot->start_time;

            if (!isset($uniqueSlotsByBeautician[$bName][$timeKey])) {
                $uniqueSlotsByBeautician[$bName][$timeKey] = [
                    'sample_slot' => $slot,
                    'beautician_id' => $slot->beautician_id,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                    'is_blocked' => $slot->is_blocked,
                    'max_capacity' => $slot->max_capacity,
                    'ids' => [$slot->id],
                    'total_days' => 1
                ];
            } else {
                $uniqueSlotsByBeautician[$bName][$timeKey]['ids'][] = $slot->id;
                $uniqueSlotsByBeautician[$bName][$timeKey]['total_days']++;
            }
        }

        $this->set(compact('slots', 'uniqueSlotsByBeautician', 'beauticians', 'allBeauticians', 'selectedBeautician'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $slotsTable = $this->fetchTable('Slots');

            $beauticianId = !empty($data['beautician_id']) ? (int)$data['beautician_id'] : null;
            $startTime = $data['start_time'];
            $endTime = $data['end_time'];
            $maxCapacity = !empty($data['max_capacity']) ? (int)$data['max_capacity'] : 1;

            // Auto-generate Everyday time slot for upcoming 30 days
            $count = 0;
            $today = strtotime('today');
            $end = strtotime('+30 days');

            while ($today <= $end) {
                $dateStr = date('Y-m-d', $today);

                $existing = $slotsTable->find()->where([
                    'beautician_id IS' => $beauticianId,
                    'date' => $dateStr,
                    'start_time' => $startTime
                ])->first();

                if (!$existing) {
                    $slot = $slotsTable->newEntity([
                        'beautician_id' => $beauticianId,
                        'date' => $dateStr,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'max_capacity' => $maxCapacity,
                        'is_blocked' => 0,
                        'booked_count' => 0,
                    ]);
                    $slotsTable->save($slot);
                    $count++;
                }
                $today = strtotime('+1 day', $today);
            }

            $this->Flash->success(__('Everyday time slot ({0} - {1}) added successfully!', $startTime, $endTime));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function generate()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $slotsTable = $this->fetchTable('Slots');

            $startDate = $data['start_date'];
            $endDate = $data['end_date'];
            $beauticianId = !empty($data['beautician_id']) ? (int)$data['beautician_id'] : null;

            $times = [
                ['09:00:00', '10:15:00'],
                ['10:30:00', '11:45:00'],
                ['12:00:00', '13:15:00'],
                ['14:00:00', '15:15:00'],
                ['15:30:00', '16:45:00'],
                ['17:00:00', '18:15:00'],
            ];

            $current = strtotime($startDate);
            $end = strtotime($endDate);
            $count = 0;

            while ($current <= $end) {
                $dateStr = date('Y-m-d', $current);
                foreach ($times as $t) {
                    $existing = $slotsTable->find()->where([
                        'beautician_id IS' => $beauticianId,
                        'date' => $dateStr,
                        'start_time' => $t[0]
                    ])->first();

                    if (!$existing) {
                        $slot = $slotsTable->newEntity([
                            'beautician_id' => $beauticianId,
                            'date' => $dateStr,
                            'start_time' => $t[0],
                            'end_time' => $t[1],
                            'is_blocked' => 0,
                            'max_capacity' => 1,
                            'booked_count' => 0,
                        ]);
                        $slotsTable->save($slot);
                        $count++;
                    }
                }
                $current = strtotime('+1 day', $current);
            }

            $this->Flash->success(__('{0} new time slots generated successfully!', $count));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function deleteTiming()
    {
        $this->request->allowMethod(['post', 'delete']);
        $slotsTable = $this->fetchTable('Slots');
        
        $beauticianId = $this->request->getData('beautician_id');
        $startTime = $this->request->getData('start_time');

        $where = [];
        if (!empty($startTime)) {
            $where['start_time'] = $startTime;
        }

        if (empty($beauticianId) || $beauticianId === 'null') {
            $where['beautician_id IS'] = null;
        } else {
            $where['beautician_id'] = (int)$beauticianId;
        }

        $slotsTable->deleteAll($where);
        $this->Flash->success(__('Everyday time slot deleted successfully.'));

        return $this->redirect(['action' => 'index']);
    }

    public function toggleBlock($id = null)
    {
        $this->request->allowMethod(['post']);
        $slotsTable = $this->fetchTable('Slots');
        $slot = $slotsTable->get($id);

        $slot->is_blocked = $slot->is_blocked ? 0 : 1;
        if ($slotsTable->save($slot)) {
            $statusStr = $slot->is_blocked ? 'BLOCKED' : 'UNBLOCKED';
            $this->Flash->success(__('Slot status updated to {0}.', $statusStr));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $slotsTable = $this->fetchTable('Slots');
        $slot = $slotsTable->get($id);

        if ($slotsTable->delete($slot)) {
            $this->Flash->success(__('Time slot deleted successfully.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteAll()
    {
        $this->request->allowMethod(['post', 'delete']);
        $slotsTable = $this->fetchTable('Slots');
        
        $beauticianId = $this->request->getQuery('beautician_id');
        
        if ($beauticianId === 'unassigned') {
            $slotsTable->deleteAll(['beautician_id IS' => null]);
            $this->Flash->success(__('All unassigned time slots deleted successfully.'));
        } elseif (!empty($beauticianId)) {
            $slotsTable->deleteAll(['beautician_id' => (int)$beauticianId]);
            $this->Flash->success(__('All time slots for selected beautician deleted successfully.'));
        } else {
            $slotsTable->deleteAll([]);
            $this->Flash->success(__('All time slots deleted successfully.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
