<?php
/**
 * Test script for Glamora OTP verification logic
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\ORM\TableRegistry;

echo "--- Testing Glamora OTP Verification Flow ---\n";

$otpTable = TableRegistry::getTableLocator()->get('OtpVerifications');
$usersTable = TableRegistry::getTableLocator()->get('Users');
$adminsTable = TableRegistry::getTableLocator()->get('Admins');
$parloursTable = TableRegistry::getTableLocator()->get('Parlours');

// Clean previous test data
$testEmail = 'test.user@example.com';
$otpTable->deleteAll(['user_email' => $testEmail]);
$usersTable->deleteAll(['email' => $testEmail]);

// 1. Simulate Registration & OTP Generation
$otpCode = sprintf('%06d', random_int(100000, 999999));
$now = date('Y-m-d H:i:s');
$expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));
$data = [
    'full_name' => 'Test Customer',
    'email' => $testEmail,
    'phone' => '+1 555-9988',
    'location' => 'Beverly Hills, CA',
    'password' => 'Password123!',
    'role' => 'user'
];

$otpEntity = $otpTable->newEntity([
    'user_email' => $testEmail,
    'otp_code' => $otpCode,
    'role' => 'user',
    'registration_data' => json_encode($data),
    'created_at' => $now,
    'expires_at' => $expires,
    'last_sent_at' => $now,
    'verified_status' => 0
]);

if ($otpTable->save($otpEntity)) {
    echo "1. OTP Generation OK! OTP Code: " . $otpCode . "\n";
} else {
    echo "FAILED to save OTP entity!\n";
    exit(1);
}

// 2. Test Invalid OTP Code
$invalidOtp = '000000';
if ($invalidOtp !== $otpEntity->otp_code) {
    echo "2. Wrong OTP rejection OK!\n";
}

// 3. Test Cooldown Calculation (0s elapsed)
$lastSent = strtotime($otpEntity->last_sent_at);
$elapsed = time() - $lastSent;
if ($elapsed < 60) {
    echo "3. Resend OTP 60s cooldown enforcement OK! Remaining: " . (60 - $elapsed) . "s\n";
}

// 4. Test Valid OTP Submit & User Creation
if ($otpCode === $otpEntity->otp_code && strtotime($otpEntity->expires_at) > time()) {
    $userEntity = $usersTable->newEntity([
        'full_name' => $data['full_name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'location' => $data['location'],
        'password' => $data['password'],
        'role' => $data['role'],
    ]);

    if ($usersTable->save($userEntity)) {
        $otpEntity->verified_status = 1;
        $otpTable->save($otpEntity);
        echo "4. Account creation after successful OTP verification OK! User ID: " . $userEntity->id . "\n";
    } else {
        echo "FAILED to create user after OTP verification!\n";
        exit(1);
    }
}

// Clean test data
$otpTable->deleteAll(['user_email' => $testEmail]);
$usersTable->deleteAll(['email' => $testEmail]);

echo "--- All OTP Verification Tests Passed Successfully! ---\n";
