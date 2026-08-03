<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class OtpMailer extends Mailer
{
    public function sendOtp(string $recipientEmail, string $recipientName, string $otpCode, string $role = 'user')
    {
        $this
            ->setTo($recipientEmail, $recipientName)
            ->setSubject('Your Glamora Email Verification OTP Code')
            ->setEmailFormat('html')
            ->setViewVars([
                'name' => $recipientName,
                'email' => $recipientEmail,
                'otpCode' => $otpCode,
                'role' => $role,
                'expiryMinutes' => 5,
            ])
            ->viewBuilder()
                ->setTemplate('otp_verification');
    }
}
