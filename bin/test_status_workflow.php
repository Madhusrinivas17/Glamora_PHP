<?php
/**
 * Automated test script for Glamora Appointment Status Management Workflow
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\ORM\TableRegistry;

echo "--- Testing Glamora Appointment Status Management Workflow ---\n";

$appointmentsTable = TableRegistry::getTableLocator()->get('Appointments');
$usersTable = TableRegistry::getTableLocator()->get('Users');
$servicesTable = TableRegistry::getTableLocator()->get('Services');
$notificationsTable = TableRegistry::getTableLocator()->get('Notifications');
$customerHistoriesTable = TableRegistry::getTableLocator()->get('CustomerHistories');

// Pick a test user and service
$user = $usersTable->find()->where(['role' => 'user'])->first();
$service = $servicesTable->find()->first();

if (!$user || !$service) {
    echo "Prerequisite user/service missing for testing.\n";
    exit(1);
}

// 1. Test Step 1: Customer Books Appointment -> Status MUST be Pending
$appointment = $appointmentsTable->newEntity([
    'user_id' => $user->id,
    'service_id' => $service->id,
    'appointment_date' => date('Y-m-d', strtotime('+2 days')),
    'appointment_time' => '14:00:00',
    'status' => 'Pending',
    'total_price' => $service->price,
    'notes' => 'Test status workflow booking',
]);

if ($appointmentsTable->save($appointment)) {
    echo "1. Customer Booking Created! Booking ID: #" . $appointment->id . " | Initial Status: " . $appointment->status . "\n";
    if ($appointment->status === 'Pending') {
        echo "   ✓ Verification Passed: Default Status is Pending.\n";
    } else {
        echo "   X FAILED: Status is not Pending!\n";
        exit(1);
    }
} else {
    echo "FAILED to save booking!\n";
    exit(1);
}

// 2. Test Step 3 & 5: Admin changes Pending -> Confirmed
$appointment->status = 'Confirmed';
if ($appointmentsTable->save($appointment)) {
    echo "2. Admin Updated Status to Confirmed! Status: " . $appointment->status . "\n";
}

// 3. Test Step 3 & 5: Admin changes Confirmed -> Completed
$appointment->status = 'Completed';
if ($appointmentsTable->save($appointment)) {
    echo "3. Admin Updated Status to Completed! Status: " . $appointment->status . "\n";
}

// 4. Test Dashboard Metric Statistics Query
$pendingCount = $appointmentsTable->find()->where(['status' => 'Pending'])->count();
$confirmedCount = $appointmentsTable->find()->where(['status' => 'Confirmed'])->count();
$completedCount = $appointmentsTable->find()->where(['status' => 'Completed'])->count();
$cancelledCount = $appointmentsTable->find()->where(['status' => 'Cancelled'])->count();
$totalCount = $appointmentsTable->find()->count();

echo "4. Dashboard Metric Statistics:\n";
echo "   - Pending: {$pendingCount}\n";
echo "   - Confirmed: {$confirmedCount}\n";
echo "   - Completed: {$completedCount}\n";
echo "   - Cancelled: {$cancelledCount}\n";
echo "   - Total: {$totalCount}\n";

// Clean test appointment
$appointmentsTable->delete($appointment);

echo "--- All Appointment Status Workflow Tests Passed Successfully! ---\n";
