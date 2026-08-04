<?php
/*
 * InfinityFree Host Production Configuration Override File for Glamora
 *
 * HOW TO USE ON INFINITYFREE:
 * 1. Upload all project files to your InfinityFree /htdocs folder.
 * 2. Copy this file content into your server's config/app_local.php
 * 3. Fill in your InfinityFree MySQL database details below (from InfinityFree Control Panel -> MySQL Databases):
 *    - DB_HOST: e.g., sql302.infinityfree.com
 *    - DB_DATABASE: e.g., if0_42563941_glamora_db
 *    - DB_USERNAME: e.g., if0_42563941
 *    - DB_PASSWORD: Your vPanel / MySQL Password
 */

return [
    /*
     * Production Mode on InfinityFree:
     * Set debug to false to prevent DebugKit header warnings and session locks.
     */
    'debug' => false,

    'Security' => [
        'salt' => env('SECURITY_SALT', 'e0ba1f63ebeb0e7b6d04224c16c84d836f2138373acb7379550b51130015c4bd'),
    ],

    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'database' => env('DB_DATABASE', 'if0_42563941_glamora_db'),
            'username' => env('DB_USERNAME', 'if0_42563941'),
            'password' => env('DB_PASSWORD', 'YOUR_INFINITYFREE_MYSQL_PASSWORD'),
            'host' => env('DB_HOST', 'sql302.infinityfree.com'),
            'port' => '3306',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ],
    ],
];
