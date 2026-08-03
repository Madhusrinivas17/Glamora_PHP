<?php
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\Datasource\ConnectionManager;

$connection = ConnectionManager::get('default');

echo "Updating database schema for new features...\n";

$queries = [
    // 1. Add is_open to parlours
    "ALTER TABLE parlours ADD COLUMN is_open INTEGER DEFAULT 1",
    // 2. Add title to reviews
    "ALTER TABLE reviews ADD COLUMN title VARCHAR(150) NULL",
    // 3. Create favorites table
    "CREATE TABLE IF NOT EXISTS favorites (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        service_id INTEGER NOT NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )"
];

foreach ($queries as $sql) {
    try {
        $connection->execute($sql);
        echo "Executed: {$sql}\n";
    } catch (\Exception $e) {
        echo "Notice: " . $e->getMessage() . "\n";
    }
}

echo "Database schema update complete!\n";
