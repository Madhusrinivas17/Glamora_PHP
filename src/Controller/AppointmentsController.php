<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\I18n\Date;

class AppointmentsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['getSlots']);
    }

    public function book()
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            $this->Flash->info(__('Please log in or create an account to book your appointment.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $servicesTable = $this->fetchTable('Services');
        $beauticiansTable = $this->fetchTable('Beauticians');
        $slotsTable = $this->fetchTable('Slots');
        $appointmentsTable = $this->fetchTable('Appointments');
        $notificationsTable = $this->fetchTable('Notifications');
        $paymentsTable = $this->fetchTable('Payments');
        $customerHistoriesTable = $this->fetchTable('CustomerHistories');
        $holidaysTable = $this->fetchTable('Holidays');

        $parloursTable = $this->fetchTable('Parlours');
        $serviceId = $this->request->getQuery('service_id');
        $selectedService = null;
        if ($serviceId) {
            $selectedService = $servicesTable->find()->where(['id' => $serviceId])->first();
        }

        $parlours = $parloursTable->find()->all();
        $services = $servicesTable->find()->where(['is_active' => 1])->all();
        $beauticians = $beauticiansTable->find()->where(['availability_status' => 'available', 'leave_status' => 0])->all();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $service = $servicesTable->get($data['service_id']);
            $date = $data['appointment_date'];
            $beauticianId = !empty($data['beautician_id']) ? (int)$data['beautician_id'] : null;
            $parlourId = !empty($data['parlour_id']) ? (int)$data['parlour_id'] : null;

            // Check if selected date is a Holiday
            $holiday = $holidaysTable->find()->where(['holiday_date' => $date])->first();
            if ($holiday) {
                $this->Flash->error(__('Sorry, the salon is closed on {0} due to "{1}". Please select another date.', $date, $holiday->title));
                return $this->redirect($this->referer());
            }

            // Auto-assign beautician if not explicitly selected
            if (!$beauticianId) {
                $availableBeautician = $beauticiansTable->find()
                    ->where(['availability_status' => 'available', 'leave_status' => 0])
                    ->first();
                if ($availableBeautician) {
                    $beauticianId = $availableBeautician->id;
                }
            }

            // Slot validation & Double Booking prevention
            $slotId = !empty($data['slot_id']) ? (int)$data['slot_id'] : null;
            $appointmentTime = $data['appointment_time'] ?? '10:00:00';

            if ($slotId) {
                $slot = $slotsTable->find()->where(['id' => $slotId, 'is_blocked' => 0])->first();
                if (!$slot) {
                    $this->Flash->error(__('Selected slot is unavailable or blocked. Please choose another time.'));
                    return $this->redirect($this->referer());
                }

                // Check double booking for the same slot
                $existingCount = $appointmentsTable->find()
                    ->where([
                        'slot_id' => $slotId,
                        'appointment_date' => $date,
                        'status IN' => ['Pending', 'Confirmed']
                    ])->count();

                if ($existingCount >= $slot->max_capacity) {
                    $this->Flash->error(__('Selected time slot is already fully booked. Please choose another slot.'));
                    return $this->redirect($this->referer());
                }
                $appointmentTime = $slot->start_time;
            }

            // Save Appointment
            $appointment = $appointmentsTable->newEntity([
                'user_id' => $identity->id,
                'parlour_id' => $parlourId,
                'service_id' => $service->id,
                'beautician_id' => $beauticianId,
                'slot_id' => $slotId,
                'appointment_date' => $date,
                'appointment_time' => $appointmentTime,
                'status' => 'Pending',
                'total_price' => $service->price,
                'notes' => $data['notes'] ?? '',
            ]);

            if ($appointmentsTable->save($appointment)) {
                // Update Slot booked_count if slot_id used
                if ($slotId) {
                    $slotEntity = $slotsTable->get($slotId);
                    $slotEntity->booked_count += 1;
                    $slotsTable->save($slotEntity);
                }

                // Payment record
                $payment = $paymentsTable->newEntity([
                    'appointment_id' => $appointment->id,
                    'amount' => $service->price,
                    'payment_method' => $data['payment_method'] ?? 'Pay at Salon',
                    'payment_status' => 'Pending',
                    'transaction_id' => 'GLAM-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                ]);
                $paymentsTable->save($payment);

                // Notification
                $notif = $notificationsTable->newEntity([
                    'user_id' => $identity->id,
                    'title' => 'Appointment Submitted',
                    'message' => "Your appointment for {$service->name} on {$date} at {$appointmentTime} has been submitted and is waiting for admin approval.",
                    'type' => 'warning',
                    'is_read' => 0
                ]);
                $notificationsTable->save($notif);

                $this->Flash->success(__('Your appointment has been submitted successfully and is waiting for admin approval.'));
                return $this->redirect(['action' => 'myAppointments']);
            } else {
                $this->Flash->error(__('Failed to create appointment. Please verify details.'));
            }
        }

        $this->set(compact('services', 'beauticians', 'selectedService', 'parlours'));
    }

    public function getSlots()
    {
        $this->request->allowMethod(['get']);
        $date = $this->request->getQuery('date');
        $beauticianId = $this->request->getQuery('beautician_id');

        $slotsTable = $this->fetchTable('Slots');
        $appointmentsTable = $this->fetchTable('Appointments');
        $holidaysTable = $this->fetchTable('Holidays');

        // Check holiday
        if ($date) {
            $holiday = $holidaysTable->find()->where(['holiday_date' => $date])->first();
            if ($holiday) {
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['status' => 'holiday', 'message' => "Salon is closed on $date: " . $holiday->title, 'slots' => []]));
            }
        }

        $query = $slotsTable->find()->where(['is_blocked' => 0]);
        if ($date) {
            $query->where(['date' => $date]);
        }
        if ($beauticianId) {
            $query->where(['beautician_id' => $beauticianId]);
        }

        $rawSlots = $query->contain(['Beauticians'])->all();

        $slots = [];
        foreach ($rawSlots as $s) {
            $bookedCount = $appointmentsTable->find()->where([
                'slot_id' => $s->id,
                'status IN' => ['Pending', 'Confirmed']
            ])->count();

            if ($bookedCount < $s->max_capacity) {
                $timeStr = is_object($s->start_time) ? $s->start_time->format('h:i A') : date('h:i A', strtotime((string)$s->start_time));
                $slots[] = [
                    'id' => $s->id,
                    'time' => $timeStr,
                    'start_time' => $s->start_time,
                    'end_time' => $s->end_time,
                    'beautician' => $s->beautician ? $s->beautician->name : 'Any Beautician',
                ];
            }
        }

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['status' => 'success', 'slots' => $slots]));
    }

    public function myAppointments()
    {
        $identity = $this->Authentication->getIdentity();
        $appointmentsTable = $this->fetchTable('Appointments');

        $appointments = $appointmentsTable->find()
            ->contain(['Services', 'Beauticians', 'Payments'])
            ->where(['Appointments.user_id' => $identity->id])
            ->order(['Appointments.appointment_date' => 'DESC', 'Appointments.appointment_time' => 'DESC'])
            ->all();

        $this->set(compact('appointments'));
    }

    public function cancel($id = null)
    {
        $identity = $this->Authentication->getIdentity();
        $appointmentsTable = $this->fetchTable('Appointments');
        $notificationsTable = $this->fetchTable('Notifications');

        $appointment = $appointmentsTable->find()
            ->contain(['Services'])
            ->where(['Appointments.id' => $id, 'Appointments.user_id' => $identity->id])
            ->firstOrFail();

        if ($appointment->status === 'Completed') {
            $this->Flash->error(__('Completed appointments cannot be cancelled.'));
            return $this->redirect(['action' => 'myAppointments']);
        }

        $appointment->status = 'Cancelled';
        if ($appointmentsTable->save($appointment)) {
            // Send cancellation notification
            $notif = $notificationsTable->newEntity([
                'user_id' => $identity->id,
                'title' => 'Appointment Cancelled',
                'message' => "Your appointment for {$appointment->service->name} on {$appointment->appointment_date} has been cancelled.",
                'type' => 'warning',
                'is_read' => 0
            ]);
            $notificationsTable->save($notif);

            $this->Flash->success(__('Your appointment has been cancelled successfully.'));
        } else {
            $this->Flash->error(__('Unable to cancel appointment.'));
        }

        return $this->redirect(['action' => 'myAppointments']);
    }
}
