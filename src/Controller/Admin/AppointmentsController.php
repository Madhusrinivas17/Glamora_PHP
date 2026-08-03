<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Mailer\AppointmentMailer;
use Cake\Log\Log;

class AppointmentsController extends AdminAppController
{
    public function index()
    {
        $appointmentsTable = $this->fetchTable('Appointments');
        $beauticiansTable = $this->fetchTable('Beauticians');

        $query = $appointmentsTable->find()
            ->contain(['Users', 'Services', 'Beauticians', 'Payments'])
            ->order(['Appointments.created' => 'DESC', 'Appointments.appointment_date' => 'DESC']);

        $statusFilter = $this->request->getQuery('status');
        if (!empty($statusFilter)) {
            $query->where(['Appointments.status' => $statusFilter]);
        }

        $appointments = $query->all();
        $beauticians = $beauticiansTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        $this->set(compact('appointments', 'beauticians', 'statusFilter'));
    }

    public function updateStatus($id = null, $status = null)
    {
        $this->request->allowMethod(['post']);
        $appointmentsTable = $this->fetchTable('Appointments');
        $notificationsTable = $this->fetchTable('Notifications');
        $customerHistoriesTable = $this->fetchTable('CustomerHistories');

        $appointment = $appointmentsTable->find()
            ->contain(['Services', 'Users'])
            ->where(['Appointments.id' => $id])
            ->firstOrFail();

        $validStatuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled', 'Rescheduled'];
        if (!in_array($status, $validStatuses)) {
            $this->Flash->error(__('Invalid status action.'));
            return $this->redirect(['action' => 'index']);
        }

        $appointment->status = $status;

        if ($appointmentsTable->save($appointment)) {
            $serviceName = $appointment->service->name ?? 'Salon Service';
            $rawDate = $appointment->appointment_date;
            $appDate = is_object($rawDate) ? $rawDate->format('Y-m-d') : (string)$rawDate;

            $rawTime = $appointment->appointment_time;
            $appTime = is_object($rawTime) ? $rawTime->format('h:i A') : date('h:i A', strtotime((string)$rawTime));

            // Custom Notification Messages per Spec
            $inAppMessages = [
                'Confirmed' => "Your Glamora appointment has been confirmed.\n\nService: {$serviceName}\nDate: {$appDate}\nTime: {$appTime}\n\nWe look forward to serving you.",
                'Completed' => "Thank you for visiting Glamora.\n\nYour appointment has been marked as completed.\n\nWe hope to see you again.",
                'Cancelled' => "Your appointment has been cancelled.\n\nIf you have any questions, please contact Glamora.",
                'Rescheduled' => "Your appointment for {$serviceName} has been rescheduled.",
            ];

            $notifText = $inAppMessages[$status] ?? "Your appointment status was updated to {$status}.";

            // 1. Save In-App Notification
            $notif = $notificationsTable->newEntity([
                'user_id' => $appointment->user_id,
                'title' => "Appointment " . ucfirst(strtolower($status)),
                'message' => $notifText,
                'type' => ($status === 'Confirmed' || $status === 'Completed') ? 'success' : 'warning',
                'is_read' => 0
            ]);
            $notificationsTable->save($notif);

            // 2. Dispatch Email Notification via CakePHP Mailer
            if (!empty($appointment->user->email)) {
                try {
                    $mailer = new AppointmentMailer();
                    $mailer->send('sendStatusNotification', [
                        $appointment->user->email,
                        $appointment->user->full_name ?? 'Client',
                        $serviceName,
                        $appDate,
                        $appTime,
                        $status
                    ]);
                } catch (\Throwable $e) {
                    Log::warning('Appointment email status notification failed: ' . $e->getMessage());
                }
            }

            // 3. Record customer history entry if completed
            if ($status === 'Completed') {
                $historyExists = $customerHistoriesTable->find()->where(['appointment_id' => $appointment->id])->first();
                if (!$historyExists) {
                    $history = $customerHistoriesTable->newEntity([
                        'user_id' => $appointment->user_id,
                        'appointment_id' => $appointment->id,
                        'service_name' => $serviceName,
                        'amount_paid' => $appointment->total_price,
                        'visit_date' => $appDate,
                        'notes' => 'Service completed at salon.',
                    ]);
                    $customerHistoriesTable->save($history);
                }
            }

            $this->Flash->success(__('Booking #{0} status updated to {1}.', $appointment->id, $status));
        } else {
            $this->Flash->error(__('Unable to update appointment status.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function reschedule($id = null)
    {
        $this->request->allowMethod(['post']);
        $appointmentsTable = $this->fetchTable('Appointments');
        $notificationsTable = $this->fetchTable('Notifications');

        $appointment = $appointmentsTable->find()
            ->contain(['Services', 'Users'])
            ->where(['Appointments.id' => $id])
            ->firstOrFail();

        $newDate = $this->request->getData('new_date');
        $newTime = $this->request->getData('new_time');
        $beauticianId = $this->request->getData('beautician_id');

        if ($newDate && $newTime) {
            $appointment->appointment_date = $newDate;
            $appointment->appointment_time = $newTime;
            if (!empty($beauticianId)) {
                $appointment->beautician_id = (int)$beauticianId;
            }
            $appointment->status = 'Rescheduled';

            if ($appointmentsTable->save($appointment)) {
                $notif = $notificationsTable->newEntity([
                    'user_id' => $appointment->user_id,
                    'title' => 'Appointment Rescheduled',
                    'message' => "Your appointment for {$appointment->service->name} has been rescheduled to {$newDate} at {$newTime}.",
                    'type' => 'info',
                    'is_read' => 0
                ]);
                $notificationsTable->save($notif);

                $this->Flash->success(__('Appointment rescheduled to {0} at {1}.', $newDate, $newTime));
            } else {
                $this->Flash->error(__('Failed to reschedule appointment.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}
