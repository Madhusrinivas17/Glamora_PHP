<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class AppointmentMailer extends Mailer
{
    public function sendStatusNotification(string $recipientEmail, string $recipientName, string $serviceName, string $appointmentDate, string $appointmentTime, string $status)
    {
        $subjects = [
            'Confirmed' => 'Appointment Confirmed',
            'Completed' => 'Appointment Completed',
            'Cancelled' => 'Appointment Cancelled',
        ];

        $subject = $subjects[$status] ?? "Appointment Status Update: {$status}";

        $this
            ->setTo($recipientEmail, $recipientName)
            ->setSubject($subject)
            ->setEmailFormat('html')
            ->setViewVars([
                'name' => $recipientName,
                'email' => $recipientEmail,
                'serviceName' => $serviceName,
                'appointmentDate' => $appointmentDate,
                'appointmentTime' => date('h:i A', strtotime($appointmentTime)),
                'status' => $status,
            ])
            ->viewBuilder()
                ->setTemplate('appointment_status');
    }
}
