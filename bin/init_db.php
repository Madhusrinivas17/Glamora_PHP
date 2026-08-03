<?php
/**
 * Database Initializer & Seeder for Glamora
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\Datasource\ConnectionManager;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Utility\Security;

echo "Initializing Glamora Database...\n";

$connection = ConnectionManager::get('default');
$driver = $connection->getDriver();

// Table creation queries compatible with SQLite & MySQL
$sqls = [
    "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name VARCHAR(150) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        phone VARCHAR(30) NOT NULL,
        location VARCHAR(150) NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'user',
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        parlour_name VARCHAR(150) NOT NULL,
        phone VARCHAR(30) NULL,
        location VARCHAR(150) NULL,
        bio TEXT NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS parlours (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(150) NOT NULL,
        admin_id INTEGER NOT NULL,
        address TEXT NULL,
        city VARCHAR(100) NULL,
        phone VARCHAR(30) NULL,
        email VARCHAR(150) NULL,
        rating DECIMAL(3,2) DEFAULT 5.00,
        total_reviews INTEGER DEFAULT 0,
        description TEXT NULL,
        image VARCHAR(255) NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS service_categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) NOT NULL UNIQUE,
        icon VARCHAR(50) NULL,
        description TEXT NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER NOT NULL,
        name VARCHAR(150) NOT NULL,
        description TEXT NULL,
        price DECIMAL(10,2) NOT NULL,
        duration_minutes INTEGER NOT NULL DEFAULT 45,
        image VARCHAR(255) NULL,
        is_active INTEGER DEFAULT 1,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS beauticians (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(150) NOT NULL,
        profile_image VARCHAR(255) NULL,
        specialization VARCHAR(150) NULL,
        experience_years INTEGER DEFAULT 1,
        availability_status VARCHAR(50) DEFAULT 'available',
        leave_status INTEGER DEFAULT 0,
        bio TEXT NULL,
        rating DECIMAL(3,2) DEFAULT 5.00,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS slots (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        beautician_id INTEGER NULL,
        date DATE NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        is_blocked INTEGER DEFAULT 0,
        max_capacity INTEGER DEFAULT 1,
        booked_count INTEGER DEFAULT 0,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS appointments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        service_id INTEGER NOT NULL,
        beautician_id INTEGER NULL,
        slot_id INTEGER NULL,
        appointment_date DATE NOT NULL,
        appointment_time TIME NOT NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'Pending',
        total_price DECIMAL(10,2) NOT NULL,
        notes TEXT NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS payments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        appointment_id INTEGER NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        payment_method VARCHAR(50) DEFAULT 'Cash/Card at Salon',
        payment_status VARCHAR(50) DEFAULT 'Pending',
        transaction_id VARCHAR(100) NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS offers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(150) NOT NULL,
        description TEXT NULL,
        discount_percentage DECIMAL(5,2) NOT NULL,
        promo_code VARCHAR(50) NULL,
        offer_image VARCHAR(255) NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        is_active INTEGER DEFAULT 1,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        service_id INTEGER NULL,
        appointment_id INTEGER NULL,
        rating INTEGER NOT NULL DEFAULT 5,
        comment TEXT NULL,
        status VARCHAR(50) DEFAULT 'Approved',
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS notifications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title VARCHAR(150) NOT NULL,
        message TEXT NOT NULL,
        type VARCHAR(50) DEFAULT 'info',
        is_read INTEGER DEFAULT 0,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS customer_histories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        appointment_id INTEGER NULL,
        service_name VARCHAR(150) NOT NULL,
        amount_paid DECIMAL(10,2) NOT NULL,
        visit_date DATE NOT NULL,
        notes TEXT NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS holidays (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        holiday_date DATE NOT NULL,
        title VARCHAR(150) NOT NULL,
        holiday_type VARCHAR(50) DEFAULT 'festival',
        description TEXT NULL,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS availabilities (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        beautician_id INTEGER NOT NULL,
        day_of_week VARCHAR(20) NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        is_off INTEGER DEFAULT 0,
        created DATETIME NULL,
        modified DATETIME NULL
    )",
    "CREATE TABLE IF NOT EXISTS otp_verifications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_email VARCHAR(150) NOT NULL,
        otp_code VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'user',
        registration_data TEXT NOT NULL,
        created_at DATETIME NULL,
        expires_at DATETIME NULL,
        last_sent_at DATETIME NULL,
        verified_status INTEGER DEFAULT 0,
        created DATETIME NULL,
        modified DATETIME NULL
    )"
];

foreach ($sqls as $sql) {
    try {
        $connection->execute($sql);
    } catch (\Exception $e) {
        echo "Note: " . $e->getMessage() . "\n";
    }
}

echo "Tables created successfully.\n";

// Password hasher for CakePHP Auth
$hasher = new DefaultPasswordHasher();
$hashedPassword = $hasher->hash('Password123!');

// Seed Users if empty
$userCount = $connection->execute("SELECT COUNT(*) as cnt FROM users")->fetch('assoc')['cnt'];
if ((int)$userCount === 0) {
    echo "Seeding initial users and admins...\n";
    
    // Admin User
    $connection->insert('users', [
        'full_name' => 'Glamora Admin',
        'email' => 'admin@glamora.com',
        'phone' => '+1 555-0192',
        'location' => 'Beverly Hills, CA',
        'password' => $hashedPassword,
        'role' => 'admin',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);
    $adminUserId = (int)$connection->execute("SELECT MAX(id) as last_id FROM users")->fetch('assoc')['last_id'];

    $connection->insert('admins', [
        'user_id' => $adminUserId,
        'parlour_name' => 'Glamora Couture Salon & Spa',
        'phone' => '+1 555-0192',
        'location' => 'Beverly Hills, CA',
        'bio' => 'Premier luxury beauty parlour offering bespoke hair styling, skin therapies, bridal draping, and aesthetics.',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    $connection->insert('parlours', [
        'name' => 'Glamora Couture Salon & Spa',
        'admin_id' => $adminUserId,
        'address' => '9454 Wilshire Blvd, Beverly Hills',
        'city' => 'Beverly Hills',
        'phone' => '+1 555-0192',
        'email' => 'contact@glamora.com',
        'rating' => 4.9,
        'total_reviews' => 128,
        'description' => 'Experience the epitome of elegance and rejuvenation at Glamora. Our certified master beauticians specialize in personalized luxury services.',
        'image' => 'salon_main.jpg',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    // Regular Customers
    $connection->insert('users', [
        'full_name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1 555-0144',
        'location' => 'Los Angeles, CA',
        'password' => $hashedPassword,
        'role' => 'user',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);
    $user1Id = (int)$connection->execute("SELECT MAX(id) as last_id FROM users")->fetch('assoc')['last_id'];

    $connection->insert('users', [
        'full_name' => 'Sarah Jenkins',
        'email' => 'sarah@example.com',
        'phone' => '+1 555-0188',
        'location' => 'Santa Monica, CA',
        'password' => $hashedPassword,
        'role' => 'user',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    // Categories
    $categories = [
        ['Hair', 'hair', 'bi-scissors', 'Precision cuts, balayage, keratin treatments, blowouts, and hair spas.'],
        ['Saree Draping', 'saree-draping', 'bi-gem', 'Custom drape styling including South Indian, Gujarati, Can-Can, and Lehenga drapes.'],
        ['Makeup', 'makeup', 'bi-palette', 'HD party makeup, airbrush glow, editorial styling, and minimal day looks.'],
        ['Facial', 'facial', 'bi-sparkles', 'HydraFacials, Gold Radiance, Collagen Boosters, and Deep Pore cleansing.'],
        ['Skin Care', 'skin-care', 'bi-heart-pulse', 'Dermaplaning, organic peeling, LED photon therapy, and skin hydration.'],
        ['Nails', 'nails', 'bi-hand-index-thumb', 'Gel extensions, French manicures, custom acrylic nail art, and spa pedicures.'],
        ['Bridal Makeup', 'bridal-makeup', 'bi-flower1', 'Complete luxury bridal makeover with trial, hairstyling, jewelry settings, and draping.'],
        ['Packages', 'packages', 'bi-box-seam', 'All-in-one pre-bridal, spa day, pamper packages, and express glam Combos.']
    ];

    foreach ($categories as $cat) {
        $connection->insert('service_categories', [
            'name' => $cat[0],
            'slug' => $cat[1],
            'icon' => $cat[2],
            'description' => $cat[3],
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ]);
    }

    // Services
    $services = [
        [1, 'Royal Hair Spa & Blowdry', 'Deep nourishment with organic argan oil followed by customized scalp massage and signature blowout.', 65.00, 60, 'service_hair_spa.jpg'],
        [1, 'Balayage & Color Melt', 'Artisanal hand-painted highlights tailored to skin tone with glossing finish.', 140.00, 120, 'service_balayage.jpg'],
        [2, 'Royal Silk Saree Draping', 'Precision saree draping in traditional or fusion styles with pleat pin setup.', 35.00, 30, 'service_saree.jpg'],
        [3, 'HD Glam Party Makeup', 'High-definition waterproof makeup, false lashes, contoured highlight, and matte setting.', 95.00, 75, 'service_makeup.jpg'],
        [4, 'HydraFacial Glow Therapy', 'Medical-grade hydro-dermabrasion infusing hyaluronic acid serums for instant radiance.', 110.00, 60, 'service_hydra.jpg'],
        [5, 'Gold Radiance Skin Ritual', '24k gold leaf skin rejuvenation mask with lymphatic drainage face massage.', 85.00, 60, 'service_skin.jpg'],
        [6, 'Luxury Gel Extensions & Nail Art', 'Custom acrylic nail extension set with hand-painted nail design and gel seal.', 55.00, 90, 'service_nails.jpg'],
        [7, 'Imperial Royal Bridal Package', 'Complete 3-day pre-bridal treatment, HD airbrush wedding makeup, hair, saree draping, and touchup kit.', 390.00, 240, 'service_bridal.jpg'],
        [8, 'Weekend Glow Pamper Package', 'Express facial, gel manicure, relaxing hair spa, and blowout.', 145.00, 150, 'service_package.jpg']
    ];

    foreach ($services as $srv) {
        $connection->insert('services', [
            'category_id' => $srv[0],
            'name' => $srv[1],
            'description' => $srv[2],
            'price' => $srv[3],
            'duration_minutes' => $srv[4],
            'image' => $srv[5],
            'is_active' => 1,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ]);
    }

    // Beauticians
    $beauticians = [
        ['Sophia Rodriguez', 'beautician_1.jpg', 'Master Hair Stylist & Colorist', 8, 'available', 0, 'Specializes in balayage, keratin treatments, and red carpet hair designs.', 4.95],
        ['Emma Watson', 'beautician_2.jpg', 'Aesthetician & HydraFacial Specialist', 6, 'available', 0, 'Expert in anti-aging treatments, facial sculpts, and skin detoxing.', 4.90],
        ['Priya Sharma', 'beautician_3.jpg', 'Bridal Stylist & Saree Drape Artist', 10, 'available', 0, 'Acclaimed bridal makeup and draped couture specialist for grand occasions.', 5.00],
        ['Isabella Chen', 'beautician_4.jpg', 'Senior Nail Technologist', 5, 'available', 0, 'Master of Korean nail art, polygel extensions, and spa care.', 4.88]
    ];

    foreach ($beauticians as $b) {
        $connection->insert('beauticians', [
            'name' => $b[0],
            'profile_image' => $b[1],
            'specialization' => $b[2],
            'experience_years' => $b[3],
            'availability_status' => $b[4],
            'leave_status' => $b[5],
            'bio' => $b[6],
            'rating' => $b[7],
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ]);
    }

    // Slots for Today and Next 7 Days
    $times = ['09:00:00', '10:30:00', '12:00:00', '14:00:00', '15:30:00', '17:00:00', '18:30:00'];
    for ($i = 0; $i < 7; $i++) {
        $dateStr = date('Y-m-d', strtotime("+$i days"));
        for ($bId = 1; $bId <= 4; $bId++) {
            foreach ($times as $tIndex => $t) {
                $endTime = date('H:i:s', strtotime("$t + 1 hour 15 minutes"));
                $connection->insert('slots', [
                    'beautician_id' => $bId,
                    'date' => $dateStr,
                    'start_time' => $t,
                    'end_time' => $endTime,
                    'is_blocked' => ($i === 3 && $tIndex === 2) ? 1 : 0, // Sample blocked slot
                    'max_capacity' => 1,
                    'booked_count' => 0,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    // Sample Appointments
    $today = date('Y-m-d');
    $connection->insert('appointments', [
        'user_id' => $user1Id,
        'service_id' => 1,
        'beautician_id' => 1,
        'slot_id' => 1,
        'appointment_date' => $today,
        'appointment_time' => '10:30:00',
        'status' => 'Confirmed',
        'total_price' => 65.00,
        'notes' => 'Please provide extra scalp massage.',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);
    $app1Id = (int)$connection->execute("SELECT MAX(id) as last_id FROM appointments")->fetch('assoc')['last_id'];

    $connection->insert('payments', [
        'appointment_id' => $app1Id,
        'amount' => 65.00,
        'payment_method' => 'Credit Card',
        'payment_status' => 'Paid',
        'transaction_id' => 'TXN-98421045',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    // Notifications
    $connection->insert('notifications', [
        'user_id' => $user1Id,
        'title' => 'Booking Confirmed!',
        'message' => 'Your appointment for Royal Hair Spa & Blowdry on ' . $today . ' at 10:30 AM is confirmed.',
        'type' => 'success',
        'is_read' => 0,
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    // Customer History
    $connection->insert('customer_histories', [
        'user_id' => $user1Id,
        'appointment_id' => $app1Id,
        'service_name' => 'Royal Hair Spa & Blowdry',
        'amount_paid' => 65.00,
        'visit_date' => $today,
        'notes' => 'Client expressed high satisfaction with organic argan hair spa.',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    // Offers
    $connection->insert('offers', [
        'title' => 'Glamora Grand Opening Offer',
        'description' => 'Get 20% flat discount on all luxury facial and skin care services this month.',
        'discount_percentage' => 20.00,
        'promo_code' => 'GLAMORA20',
        'offer_image' => 'offer_opening.jpg',
        'start_date' => date('Y-m-01'),
        'end_date' => date('Y-m-t', strtotime('+1 month')),
        'is_active' => 1,
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    $connection->insert('offers', [
        'title' => 'Bridal Royalty Pamper Package',
        'description' => 'Complimentary hair styling trial with every Imperial Royal Bridal Package booking.',
        'discount_percentage' => 15.00,
        'promo_code' => 'ROYALBRIDAL',
        'offer_image' => 'offer_bridal.jpg',
        'start_date' => date('Y-m-01'),
        'end_date' => date('Y-12-31'),
        'is_active' => 1,
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    // Holidays
    $connection->insert('holidays', [
        'holiday_date' => date('Y-08-15'),
        'title' => 'Independence Day Holiday',
        'holiday_type' => 'festival',
        'description' => 'Salon closed for national holiday festivities.',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    $connection->insert('holidays', [
        'holiday_date' => date('Y-11-12'),
        'title' => 'Diwali Grand Celebration',
        'holiday_type' => 'festival',
        'description' => 'Salon closed for festival of lights.',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    // Reviews
    $connection->insert('reviews', [
        'user_id' => $user1Id,
        'service_id' => 1,
        'appointment_id' => $app1Id,
        'rating' => 5,
        'comment' => 'Absolute bliss! Sophia did an unbelievable job with my scalp treatment and blowdry. The salon vibe is stunning.',
        'status' => 'Approved',
        'created' => date('Y-m-d H:i:s'),
        'modified' => date('Y-m-d H:i:s')
    ]);

    echo "Initial seed data inserted successfully!\n";
} else {
    echo "Database already contains users. Skipping seed.\n";
}

echo "Database initialization complete!\n";
