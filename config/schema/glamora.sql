-- Glamora Salon Management & Appointment Booking Database Schema (MySQL)
CREATE DATABASE IF NOT EXISTS `glamora` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `glamora`;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `phone` VARCHAR(30) NOT NULL,
  `location` VARCHAR(150) NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Admins Table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `parlour_name` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NULL,
  `location` VARCHAR(150) NULL,
  `bio` TEXT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Parlours Table
CREATE TABLE IF NOT EXISTS `parlours` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `admin_id` INT NOT NULL,
  `address` TEXT NULL,
  `city` VARCHAR(100) NULL,
  `phone` VARCHAR(30) NULL,
  `email` VARCHAR(150) NULL,
  `rating` DECIMAL(3,2) DEFAULT 5.00,
  `total_reviews` INT DEFAULT 0,
  `description` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Service Categories Table
CREATE TABLE IF NOT EXISTS `service_categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `icon` VARCHAR(50) NULL,
  `description` TEXT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Services Table
CREATE TABLE IF NOT EXISTS `services` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `duration_minutes` INT NOT NULL DEFAULT 45,
  `image` VARCHAR(255) NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`category_id`) REFERENCES `service_categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Beauticians Table
CREATE TABLE IF NOT EXISTS `beauticians` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `profile_image` VARCHAR(255) NULL,
  `specialization` VARCHAR(150) NULL,
  `experience_years` INT DEFAULT 1,
  `availability_status` VARCHAR(50) DEFAULT 'available',
  `leave_status` TINYINT(1) DEFAULT 0,
  `bio` TEXT NULL,
  `rating` DECIMAL(3,2) DEFAULT 5.00,
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Slots Table
CREATE TABLE IF NOT EXISTS `slots` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `beautician_id` INT NULL,
  `date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `is_blocked` TINYINT(1) DEFAULT 0,
  `max_capacity` INT DEFAULT 1,
  `booked_count` INT DEFAULT 0,
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Appointments Table
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `service_id` INT NOT NULL,
  `beautician_id` INT NULL,
  `slot_id` INT NULL,
  `appointment_date` DATE NOT NULL,
  `appointment_time` TIME NOT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Pending',
  `total_price` DECIMAL(10,2) NOT NULL,
  `notes` TEXT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Payments Table
CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `appointment_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(50) DEFAULT 'Cash/Card at Salon',
  `payment_status` VARCHAR(50) DEFAULT 'Pending',
  `transaction_id` VARCHAR(100) NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`appointment_id`) REFERENCES `appointments`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. Offers Table
CREATE TABLE IF NOT EXISTS `offers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  `discount_percentage` DECIMAL(5,2) NOT NULL,
  `promo_code` VARCHAR(50) NULL,
  `offer_image` VARCHAR(255) NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 11. Reviews Table
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `service_id` INT NULL,
  `appointment_id` INT NULL,
  `rating` INT NOT NULL DEFAULT 5,
  `comment` TEXT NULL,
  `status` VARCHAR(50) DEFAULT 'Approved',
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 12. Notifications Table
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `message` TEXT NOT NULL,
  `type` VARCHAR(50) DEFAULT 'info',
  `is_read` TINYINT(1) DEFAULT 0,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 13. Customer Histories Table
CREATE TABLE IF NOT EXISTS `customer_histories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `appointment_id` INT NULL,
  `service_name` VARCHAR(150) NOT NULL,
  `amount_paid` DECIMAL(10,2) NOT NULL,
  `visit_date` DATE NOT NULL,
  `notes` TEXT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 14. Holidays Table
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `holiday_date` DATE NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `holiday_type` VARCHAR(50) DEFAULT 'festival',
  `description` TEXT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 15. Availabilities Table
CREATE TABLE IF NOT EXISTS `availabilities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `beautician_id` INT NOT NULL,
  `day_of_week` VARCHAR(20) NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `is_off` TINYINT(1) DEFAULT 0,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  FOREIGN KEY (`beautician_id`) REFERENCES `beauticians`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 16. OTP Verifications Table
CREATE TABLE IF NOT EXISTS `otp_verifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_email` VARCHAR(150) NOT NULL,
  `otp_code` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) NOT NULL DEFAULT 'user',
  `registration_data` TEXT NOT NULL,
  `created_at` DATETIME NULL,
  `expires_at` DATETIME NULL,
  `last_sent_at` DATETIME NULL,
  `verified_status` TINYINT(1) DEFAULT 0,
  `created` DATETIME NULL,
  `modified` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

