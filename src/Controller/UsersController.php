<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Log\Log;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions([
            'login',
            'register',
            'registerAdmin',
            'verifyOtp',
            'resendOtp'
        ]);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            $roleInput = $this->request->getData('role_type') ?: 'user';
            $loginField = trim((string)$this->request->getData('login_field'));
            $password = (string)$this->request->getData('password');

            // Find user by email OR phone
            $usersTable = $this->fetchTable('Users');
            $user = $usersTable->find()
                ->where([
                    'OR' => [
                        'Users.email' => $loginField,
                        'Users.phone' => $loginField,
                    ]
                ])
                ->first();

            if ($user && password_verify($password, $user->password)) {
                // Strict Role Validation & Session Cleanup
                if ($roleInput === 'admin' && $user->role !== 'admin') {
                    $this->Authentication->logout();
                    $this->Flash->error(__('Access Denied. Customer accounts cannot sign in under Salon Owner role. Please select Customer role.'));
                    return $this->redirect(['action' => 'login', '?' => ['role' => 'user']]);
                }

                if ($roleInput === 'user' && $user->role === 'admin') {
                    $this->Authentication->logout();
                    $this->Flash->error(__('Access Denied. Salon Owner / Admin accounts must select Salon Owner role to sign in.'));
                    return $this->redirect(['action' => 'login', '?' => ['role' => 'admin']]);
                }

                $this->Authentication->setIdentity($user);
                $this->Flash->success(__('Welcome back, {0}!', $user->full_name));

                if ($user->role === 'admin') {
                    return $this->redirect('/admin/dashboard');
                } else {
                    return $this->redirect('/my-appointments');
                }
            } else {
                $this->Authentication->logout();
                $this->Flash->error(__('Invalid email/phone or password. Please try again.'));
                return $this->redirect(['action' => 'login', '?' => ['role' => $roleInput]]);
            }
        }

        // On GET request, handle auto-redirect only if authenticated and roles align
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $user = $this->Authentication->getIdentity();
            $requestedRole = $this->request->getQuery('role');

            if ($requestedRole === 'admin' && $user->role !== 'admin') {
                $this->Authentication->logout();
                return $this->redirect(['action' => 'login', '?' => ['role' => 'admin']]);
            }

            if ($requestedRole === 'user' && $user->role === 'admin') {
                $this->Authentication->logout();
                return $this->redirect(['action' => 'login', '?' => ['role' => 'user']]);
            }

            if ($user->role === 'admin') {
                return $this->redirect('/admin/dashboard');
            } else {
                return $this->redirect('/my-appointments');
            }
        }

        $this->set('title', 'Login - Glamora Salon');
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('You have been logged out safely.'));
        }
        return $this->redirect(['action' => 'login']);
    }

    public function register()
    {
        $userTable = $this->fetchTable('Users');
        $otpTable = $this->fetchTable('OtpVerifications');
        $user = $userTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            if ($data['password'] !== $data['confirm_password']) {
                $this->Flash->error(__('Passwords do not match. Please verify your password.'));
            } else {
                $existing = $userTable->find()->where(['email' => $data['email']])->first();
                if ($existing) {
                    $this->Flash->error(__('An account with this email address already exists.'));
                } else {
                    $otpCode = sprintf('%06d', random_int(100000, 999999));
                    $data['role'] = 'user';

                    // Remove old unverified OTPs for this email
                    $otpTable->deleteAll(['user_email' => $data['email'], 'verified_status' => 0]);

                    $now = date('Y-m-d H:i:s');
                    $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

                    $otpEntity = $otpTable->newEntity([
                        'user_email' => $data['email'],
                        'otp_code' => $otpCode,
                        'role' => 'user',
                        'registration_data' => json_encode($data),
                        'created_at' => $now,
                        'expires_at' => $expires,
                        'last_sent_at' => $now,
                        'verified_status' => 0,
                    ]);

                    if ($otpTable->save($otpEntity)) {
                        $this->sendOtpEmail($data['email'], $data['full_name'], $otpCode, 'user');
                        $this->Flash->success(__('Registration initiated! A 6-digit OTP has been sent to {0}.', $data['email']));
                        return $this->redirect(['action' => 'verifyOtp', '?' => ['email' => $data['email']]]);
                    } else {
                        $this->Flash->error(__('Unable to process registration. Please try again.'));
                    }
                }
            }
        }

        $this->set(compact('user'));
    }

    public function registerAdmin()
    {
        $usersTable = $this->fetchTable('Users');
        $otpTable = $this->fetchTable('OtpVerifications');
        $user = $usersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if ($data['password'] !== $data['confirm_password']) {
                $this->Flash->error(__('Passwords do not match. Please verify your password.'));
            } else {
                $existing = $usersTable->find()->where(['email' => $data['email']])->first();
                if ($existing) {
                    $this->Flash->error(__('An admin account with this email already exists.'));
                } else {
                    $otpCode = sprintf('%06d', random_int(100000, 999999));
                    $data['role'] = 'admin';

                    // Remove old unverified OTPs for this email
                    $otpTable->deleteAll(['user_email' => $data['email'], 'verified_status' => 0]);

                    $now = date('Y-m-d H:i:s');
                    $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

                    $otpEntity = $otpTable->newEntity([
                        'user_email' => $data['email'],
                        'otp_code' => $otpCode,
                        'role' => 'admin',
                        'registration_data' => json_encode($data),
                        'created_at' => $now,
                        'expires_at' => $expires,
                        'last_sent_at' => $now,
                        'verified_status' => 0,
                    ]);

                    if ($otpTable->save($otpEntity)) {
                        $this->sendOtpEmail($data['email'], $data['full_name'], $otpCode, 'admin');
                        $this->Flash->success(__('Admin registration initiated! A 6-digit OTP code has been sent to {0}.', $data['email']));
                        return $this->redirect(['action' => 'verifyOtp', '?' => ['email' => $data['email']]]);
                    } else {
                        $this->Flash->error(__('Unable to process admin registration. Please try again.'));
                    }
                }
            }
        }

        $this->set(compact('user'));
    }

    public function verifyOtp()
    {
        $email = $this->request->getQuery('email') ?: $this->request->getData('email');
        if (empty($email)) {
            $this->Flash->error(__('No email address provided for OTP verification.'));
            return $this->redirect(['action' => 'login']);
        }

        $otpTable = $this->fetchTable('OtpVerifications');
        $usersTable = $this->fetchTable('Users');
        $adminsTable = $this->fetchTable('Admins');
        $parloursTable = $this->fetchTable('Parlours');

        $otpRecord = $otpTable->find()
            ->where(['user_email' => $email, 'verified_status' => 0])
            ->order(['id' => 'DESC'])
            ->first();

        if (!$otpRecord) {
            $this->Flash->error(__('No pending OTP verification session found for {0}.', $email));
            return $this->redirect(['action' => 'login']);
        }

        if ($this->request->is('post')) {
            $inputOtp = trim((string)$this->request->getData('otp_code'));
            $now = time();
            $expiresAt = $this->getTimestampVal($otpRecord->expires_at);

            if ($now > $expiresAt) {
                $this->Flash->error(__('OTP code has expired (valid for 5 mins). Please click "Resend OTP".'));
            } elseif ($inputOtp !== $otpRecord->otp_code) {
                $this->Flash->error(__('Invalid OTP code. Please enter the correct 6-digit code sent to your email.'));
            } else {
                // Correct OTP & Not Expired -> Create Account
                $regData = json_decode($otpRecord->registration_data, true);

                $userEntity = $usersTable->newEntity([
                    'full_name' => $regData['full_name'],
                    'email' => $regData['email'],
                    'phone' => $regData['phone'],
                    'location' => $regData['location'] ?? '',
                    'password' => $regData['password'],
                    'role' => $regData['role'] ?? 'user',
                ]);

                if ($usersTable->save($userEntity)) {
                    if (($regData['role'] ?? 'user') === 'admin') {
                        // Create Admin entity
                        $adminEntity = $adminsTable->newEntity([
                            'user_id' => $userEntity->id,
                            'parlour_name' => $regData['parlour_name'] ?? 'Glamora Salon',
                            'phone' => $regData['phone'],
                            'location' => $regData['location'] ?? '',
                        ]);
                        $adminsTable->save($adminEntity);

                        // Create Parlour entity
                        $parlourEntity = $parloursTable->newEntity([
                            'name' => $regData['parlour_name'] ?? 'Glamora Salon',
                            'admin_id' => $userEntity->id,
                            'city' => $regData['location'] ?? '',
                            'phone' => $regData['phone'],
                            'email' => $regData['email'],
                        ]);
                        $parloursTable->save($parlourEntity);
                    }

                    // Mark OTP as verified
                    $otpRecord->verified_status = 1;
                    $otpTable->save($otpRecord);

                    $this->Flash->success(__('Email verified successfully! Your account is now active. Please sign in.'));
                    return $this->redirect(['action' => 'login', '?' => ['role' => $otpRecord->role]]);
                } else {
                    $this->Flash->error(__('Account activation failed. Please try registering again.'));
                }
            }
        }

        // Calculate cooldown remaining seconds for UI safely supporting Cake\I18n\DateTime objects
        $cooldown = 60;
        $lastSentVal = $otpRecord->last_sent_at ?: $otpRecord->created_at;
        $lastSent = $this->getTimestampVal($lastSentVal);
        $elapsed = time() - $lastSent;
        $remainingCooldown = max(0, $cooldown - $elapsed);

        $this->set(compact('email', 'otpRecord', 'remainingCooldown'));
    }

    public function resendOtp()
    {
        $this->request->allowMethod(['get', 'post']);
        $email = $this->request->getQuery('email') ?: $this->request->getData('email');

        if (empty($email)) {
            $this->Flash->error(__('No email address specified.'));
            return $this->redirect(['action' => 'login']);
        }

        $otpTable = $this->fetchTable('OtpVerifications');
        $otpRecord = $otpTable->find()
            ->where(['user_email' => $email, 'verified_status' => 0])
            ->order(['id' => 'DESC'])
            ->first();

        if (!$otpRecord) {
            $this->Flash->error(__('No pending registration session found.'));
            return $this->redirect(['action' => 'login']);
        }

        $cooldown = 60;
        $lastSentVal = $otpRecord->last_sent_at ?: $otpRecord->created_at;
        $lastSent = $this->getTimestampVal($lastSentVal);
        $elapsed = time() - $lastSent;

        if ($elapsed < $cooldown) {
            $rem = $cooldown - $elapsed;
            $this->Flash->warning(__('Please wait {0} seconds before requesting a new OTP.', $rem));
        } else {
            $newOtp = sprintf('%06d', random_int(100000, 999999));
            $now = date('Y-m-d H:i:s');
            $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

            $otpRecord->otp_code = $newOtp;
            $otpRecord->expires_at = $expires;
            $otpRecord->last_sent_at = $now;

            if ($otpTable->save($otpRecord)) {
                $regData = json_decode($otpRecord->registration_data, true);
                $name = $regData['full_name'] ?? 'User';

                $this->sendOtpEmail($email, $name, $newOtp, $otpRecord->role);
                $this->Flash->success(__('A new 6-digit OTP code has been sent to {0}.', $email));
            } else {
                $this->Flash->error(__('Failed to generate new OTP.'));
            }
        }

        return $this->redirect(['action' => 'verifyOtp', '?' => ['email' => $email]]);
    }

    public function profile()
    {
        $identity = $this->Authentication->getIdentity();
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->get($identity->id);

        if ($this->request->is(['post', 'put'])) {
            $user = $usersTable->patchEntity($user, $this->request->getData());
            if ($usersTable->save($user)) {
                $this->Flash->success(__('Profile updated successfully.'));
            } else {
                $this->Flash->error(__('Unable to update profile.'));
            }
        }

        $this->set(compact('user'));
    }

    private function getTimestampVal($datetime): int
    {
        if (empty($datetime)) {
            return time();
        }
        if (is_object($datetime) && method_exists($datetime, 'getTimestamp')) {
            return $datetime->getTimestamp();
        }
        if (is_numeric($datetime)) {
            return (int)$datetime;
        }
        return strtotime((string)$datetime) ?: time();
    }

    private function sendOtpEmail(string $email, string $name, string $otpCode, string $role = 'user'): bool
    {
        try {
            $mailer = new \App\Mailer\OtpMailer();
            $mailer->send('sendOtp', [$email, $name, $otpCode, $role]);
            return true;
        } catch (\Throwable $e) {
            Log::warning('OTP Email send failed (falling back to UI demo helper): ' . $e->getMessage());
            return false;
        }
    }
}
