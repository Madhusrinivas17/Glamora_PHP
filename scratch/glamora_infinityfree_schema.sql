-- Glamora Database Full Export for InfinityFree hosting
-- Generated on 2026-08-04 08:16:47

SET FOREIGN_KEY_CHECKS = 0;

-- Structure for table `admins` --
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `parlour_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `bio` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `admins` --
INSERT INTO `admins` (`id`, `user_id`, `parlour_name`, `phone`, `location`, `bio`, `created`, `modified`) VALUES ('1', '6', 'More_fair', '8309030289', 'Attili', NULL, '2026-08-02 11:50:23', '2026-08-02 11:50:23');

-- Structure for table `appointments` --
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `parlour_id` int DEFAULT NULL,
  `beautician_id` int DEFAULT NULL,
  `slot_id` int DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `notes` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `appointments` --
INSERT INTO `appointments` (`id`, `user_id`, `service_id`, `parlour_id`, `beautician_id`, `slot_id`, `appointment_date`, `appointment_time`, `status`, `total_price`, `notes`, `created`, `modified`) VALUES ('1', '4', '1', NULL, NULL, NULL, '2026-08-02', '10:00:00', 'Completed', '500.00', '', '2026-08-02 11:07:42', '2026-08-02 12:40:30');
INSERT INTO `appointments` (`id`, `user_id`, `service_id`, `parlour_id`, `beautician_id`, `slot_id`, `appointment_date`, `appointment_time`, `status`, `total_price`, `notes`, `created`, `modified`) VALUES ('5', '4', '3', NULL, '3', '82', '2026-08-04', '10:00:00', 'Confirmed', '2000.00', '', '2026-08-02 12:38:42', '2026-08-02 12:40:22');
INSERT INTO `appointments` (`id`, `user_id`, `service_id`, `parlour_id`, `beautician_id`, `slot_id`, `appointment_date`, `appointment_time`, `status`, `total_price`, `notes`, `created`, `modified`) VALUES ('6', '4', '2', NULL, '1', '205', '2026-08-04', '11:00:00', 'Confirmed', '1000.00', '', '2026-08-03 10:05:22', '2026-08-03 10:05:51');

-- Structure for table `availabilities` --
DROP TABLE IF EXISTS `availabilities`;
CREATE TABLE `availabilities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `beautician_id` int DEFAULT NULL,
  `day_of_week` varchar(255) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_off` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Structure for table `beauticians` --
DROP TABLE IF EXISTS `beauticians`;
CREATE TABLE `beauticians` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `experience_years` int DEFAULT NULL,
  `availability_status` varchar(255) DEFAULT NULL,
  `leave_status` int DEFAULT NULL,
  `bio` text,
  `rating` decimal(10,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `beauticians` --
INSERT INTO `beauticians` (`id`, `name`, `profile_image`, `specialization`, `experience_years`, `availability_status`, `leave_status`, `bio`, `rating`, `created`, `modified`) VALUES ('1', 'Madhu', 'beautician_default.jpg', 'Hair Stylist', '5', 'available', '0', '', '5.00', '2026-08-02 11:57:27', '2026-08-02 11:57:27');
INSERT INTO `beauticians` (`id`, `name`, `profile_image`, `specialization`, `experience_years`, `availability_status`, `leave_status`, `bio`, `rating`, `created`, `modified`) VALUES ('2', 'Sirisha', 'beautician_default.jpg', 'Mehendhi Artist', '3', 'available', '0', '', '5.00', '2026-08-02 11:57:53', '2026-08-02 11:57:53');
INSERT INTO `beauticians` (`id`, `name`, `profile_image`, `specialization`, `experience_years`, `availability_status`, `leave_status`, `bio`, `rating`, `created`, `modified`) VALUES ('3', 'Karthika', 'beautician_default.jpg', 'Bridal Makeup', '5', 'available', '0', '', '5.00', '2026-08-02 11:58:15', '2026-08-02 11:58:15');
INSERT INTO `beauticians` (`id`, `name`, `profile_image`, `specialization`, `experience_years`, `availability_status`, `leave_status`, `bio`, `rating`, `created`, `modified`) VALUES ('4', 'Bindhu', 'beautician_default.jpg', 'Facial Spectialist', '5', 'available', '0', '', '5.00', '2026-08-02 11:58:41', '2026-08-02 12:02:22');

-- Structure for table `customer_histories` --
DROP TABLE IF EXISTS `customer_histories`;
CREATE TABLE `customer_histories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `appointment_id` int DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `notes` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `customer_histories` --
INSERT INTO `customer_histories` (`id`, `user_id`, `appointment_id`, `service_name`, `amount_paid`, `visit_date`, `notes`, `created`, `modified`) VALUES ('1', '4', '1', 'Gold Facial', '500.00', '2026-08-02', 'Booked online via Glamora portal.', '2026-08-02 11:07:42', '2026-08-02 11:07:42');

-- Structure for table `favorites` --
DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `favorites` --
INSERT INTO `favorites` (`id`, `user_id`, `service_id`, `created`, `modified`) VALUES ('6', '4', '1', '2026-08-02 14:43:41', '2026-08-02 14:43:41');
INSERT INTO `favorites` (`id`, `user_id`, `service_id`, `created`, `modified`) VALUES ('8', '4', '3', '2026-08-02 14:43:47', '2026-08-02 14:43:47');

-- Structure for table `holidays` --
DROP TABLE IF EXISTS `holidays`;
CREATE TABLE `holidays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `holiday_date` date DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `holiday_type` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `holidays` --
INSERT INTO `holidays` (`id`, `holiday_date`, `title`, `holiday_type`, `description`, `created`, `modified`) VALUES ('1', '2026-08-02', 'Sunday', 'weekly', '', '2026-08-02 11:59:04', '2026-08-02 11:59:04');
INSERT INTO `holidays` (`id`, `holiday_date`, `title`, `holiday_type`, `description`, `created`, `modified`) VALUES ('2', '2026-08-09', 'Sunday', 'weekly', '', '2026-08-02 11:59:20', '2026-08-02 11:59:20');

-- Structure for table `notifications` --
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text,
  `type` varchar(255) DEFAULT NULL,
  `is_read` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `notifications` --
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('1', '4', 'Appointment Booked!', 'Your appointment for Gold Facial on 2026-08-02 at 10:00:00 has been successfully confirmed.', 'success', '1', '2026-08-02 11:07:42', '2026-08-02 11:07:58');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('2', '4', 'Appointment Completed', 'Thank you for visiting Glamora.\n\nYour appointment has been marked as completed.\n\nWe hope to see you again.', 'success', '0', '2026-08-02 11:56:54', '2026-08-02 11:56:54');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('3', '4', 'Appointment Confirmed', 'Your Glamora appointment has been confirmed.\n\nService: Gold Facial\nDate: 2026-08-02\nTime: 10:00 AM\n\nWe look forward to serving you.', 'success', '0', '2026-08-02 11:56:59', '2026-08-02 11:56:59');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('4', '4', 'Appointment Submitted', 'Your appointment for Bridal MAkeup on 2026-08-04 at 10:00 AM has been submitted and is waiting for admin approval.', 'warning', '0', '2026-08-02 12:38:42', '2026-08-02 12:38:42');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('5', '4', 'Appointment Confirmed', 'Your Glamora appointment has been confirmed.\n\nService: Bridal MAkeup\nDate: 2026-08-04\nTime: 10:00 AM\n\nWe look forward to serving you.', 'success', '0', '2026-08-02 12:40:22', '2026-08-02 12:40:22');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('6', '4', 'Appointment Completed', 'Thank you for visiting Glamora.\n\nYour appointment has been marked as completed.\n\nWe hope to see you again.', 'success', '0', '2026-08-02 12:40:30', '2026-08-02 12:40:30');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('7', '4', 'Appointment Submitted', 'Your appointment for Hair Styles on 2026-08-04 at 11:00 AM has been submitted and is waiting for admin approval.', 'warning', '0', '2026-08-03 10:05:23', '2026-08-03 10:05:23');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created`, `modified`) VALUES ('8', '4', 'Appointment Confirmed', 'Your Glamora appointment has been confirmed.\n\nService: Hair Styles\nDate: 2026-08-04\nTime: 11:00 AM\n\nWe look forward to serving you.', 'success', '0', '2026-08-03 10:05:51', '2026-08-03 10:05:51');

-- Structure for table `offers` --
DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `discount_percentage` decimal(10,2) DEFAULT NULL,
  `promo_code` varchar(255) DEFAULT NULL,
  `offer_image` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `offers` --
INSERT INTO `offers` (`id`, `title`, `description`, `discount_percentage`, `promo_code`, `offer_image`, `start_date`, `end_date`, `is_active`, `created`, `modified`) VALUES ('1', 'Marriage Season', 'Enjoy our unlimited services', '45.00', '', 'offer_default.jpg', '2026-08-09', '2026-08-30', '1', '2026-08-02 12:00:13', '2026-08-02 12:00:13');

-- Structure for table `otp_verifications` --
DROP TABLE IF EXISTS `otp_verifications`;
CREATE TABLE `otp_verifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `registration_data` text,
  `created_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `last_sent_at` datetime DEFAULT NULL,
  `verified_status` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `otp_verifications` --
INSERT INTO `otp_verifications` (`id`, `user_email`, `otp_code`, `role`, `registration_data`, `created_at`, `expires_at`, `last_sent_at`, `verified_status`, `created`, `modified`) VALUES ('2', 'madhusridamarasingu@gmail.com', '224202', 'user', '{\"full_name\":\"Madhusri Damarasingu\",\"email\":\"madhusridamarasingu@gmail.com\",\"phone\":\"+919491398697\",\"location\":\"Tanuku\",\"password\":\"ZXCASD!@#123\",\"confirm_password\":\"ZXCASD!@#123\",\"role\":\"user\"}', '2026-08-02 11:00:25', '2026-08-02 11:09:38', '2026-08-02 11:04:38', '1', '2026-08-02 11:00:25', '2026-08-02 11:05:00');
INSERT INTO `otp_verifications` (`id`, `user_email`, `otp_code`, `role`, `registration_data`, `created_at`, `expires_at`, `last_sent_at`, `verified_status`, `created`, `modified`) VALUES ('5', 'madhudamarasingu@gmail.com', '154848', 'admin', '{\"full_name\":\"Sumasri\",\"parlour_name\":\"More_fair\",\"email\":\"madhudamarasingu@gmail.com\",\"phone\":\"8309030289\",\"location\":\"Attili\",\"password\":\"ZXCASD!@#123\",\"confirm_password\":\"ZXCASD!@#123\",\"role\":\"admin\"}', '2026-08-02 11:41:34', '2026-08-02 11:54:59', '2026-08-02 11:49:59', '1', '2026-08-02 11:41:34', '2026-08-02 11:50:23');

-- Structure for table `parlours` --
DROP TABLE IF EXISTS `parlours`;
CREATE TABLE `parlours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `address` text,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rating` decimal(10,2) DEFAULT NULL,
  `total_reviews` int DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `is_open` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `parlours` --
INSERT INTO `parlours` (`id`, `name`, `admin_id`, `address`, `city`, `phone`, `email`, `rating`, `total_reviews`, `description`, `image`, `created`, `modified`, `is_open`) VALUES ('1', 'More_fair', '6', NULL, 'Attili', '8309030289', 'madhudamarasingu@gmail.com', '5.00', '0', NULL, NULL, '2026-08-02 11:50:23', '2026-08-03 10:47:14', '1');

-- Structure for table `payments` --
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `appointment_id` int DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `payments` --
INSERT INTO `payments` (`id`, `appointment_id`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `created`, `modified`) VALUES ('1', '1', '500.00', 'Pay at Salon', 'Confirmed', 'GLAM-EFCF49BD', '2026-08-02 11:07:42', '2026-08-02 11:07:42');
INSERT INTO `payments` (`id`, `appointment_id`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `created`, `modified`) VALUES ('2', '5', '2000.00', 'Pay at Salon', 'Pending', 'GLAM-CD7038C3', '2026-08-02 12:38:42', '2026-08-02 12:38:42');
INSERT INTO `payments` (`id`, `appointment_id`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `created`, `modified`) VALUES ('3', '6', '1000.00', 'Pay at Salon', 'Pending', 'GLAM-73B40901', '2026-08-03 10:05:22', '2026-08-03 10:05:22');

-- Structure for table `reviews` --
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `appointment_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `status` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Structure for table `service_categories` --
DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `service_categories` --
INSERT INTO `service_categories` (`id`, `name`, `slug`, `icon`, `description`, `created`, `modified`) VALUES ('1', 'Facials', 'facials', '', '', '2026-07-31 16:19:25', '2026-07-31 16:19:25');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `icon`, `description`, `created`, `modified`) VALUES ('2', 'Hair styles', 'hair-styles', 'bi-sparkles', '', '2026-07-31 16:19:37', '2026-07-31 16:19:37');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `icon`, `description`, `created`, `modified`) VALUES ('3', 'Hair cuts', 'hair-cuts', 'bi-sparkles', '', '2026-07-31 16:19:46', '2026-07-31 16:19:46');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `icon`, `description`, `created`, `modified`) VALUES ('4', 'Bridal MAkeup', 'bridal-makeup', 'bi-sparkles', '', '2026-07-31 16:20:01', '2026-07-31 16:20:01');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `icon`, `description`, `created`, `modified`) VALUES ('5', 'Birthday Makeover', 'birthday-makeover', 'bi-sparkles', '', '2026-07-31 16:20:14', '2026-07-31 16:20:14');

-- Structure for table `services` --
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `services` --
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price`, `duration_minutes`, `image`, `is_active`, `created`, `modified`) VALUES ('1', '1', 'Gold Facial', 'Try it...!', '500.00', '45', '1785672363_Screenshot 2026-08-02 173441.png', '1', '2026-07-31 16:21:06', '2026-08-02 12:06:03');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price`, `duration_minutes`, `image`, `is_active`, `created`, `modified`) VALUES ('2', '2', 'Hair Styles', '', '1000.00', '40', '1785672559_Screenshot 2026-08-02 173505.png', '1', '2026-08-02 12:09:19', '2026-08-02 12:09:19');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price`, `duration_minutes`, `image`, `is_active`, `created`, `modified`) VALUES ('3', '4', 'Bridal MAkeup', '', '2000.00', '60', '1785672584_Screenshot 2026-08-02 173527.png', '1', '2026-08-02 12:09:44', '2026-08-02 12:09:44');

-- Structure for table `slots` --
DROP TABLE IF EXISTS `slots`;
CREATE TABLE `slots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `beautician_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_blocked` int DEFAULT NULL,
  `max_capacity` int DEFAULT NULL,
  `booked_count` int DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `slots` --
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('80', '3', '2026-08-02', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:15', '2026-08-02 12:34:15');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('81', '3', '2026-08-03', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:15', '2026-08-02 12:34:15');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('82', '3', '2026-08-04', '10:00:00', '11:15:00', '0', '1', '1', '2026-08-02 12:34:15', '2026-08-02 12:38:42');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('83', '3', '2026-08-05', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:15', '2026-08-02 12:34:15');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('84', '3', '2026-08-06', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('85', '3', '2026-08-07', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('86', '3', '2026-08-08', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('87', '3', '2026-08-09', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('88', '3', '2026-08-10', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('89', '3', '2026-08-11', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('90', '3', '2026-08-12', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('91', '3', '2026-08-13', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('92', '3', '2026-08-14', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('93', '3', '2026-08-15', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('94', '3', '2026-08-16', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('95', '3', '2026-08-17', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('96', '3', '2026-08-18', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('97', '3', '2026-08-19', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('98', '3', '2026-08-20', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('99', '3', '2026-08-21', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('100', '3', '2026-08-22', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('101', '3', '2026-08-23', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('102', '3', '2026-08-24', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('103', '3', '2026-08-25', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('104', '3', '2026-08-26', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('105', '3', '2026-08-27', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('106', '3', '2026-08-28', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('107', '3', '2026-08-29', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('108', '3', '2026-08-30', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('109', '3', '2026-08-31', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('110', '3', '2026-09-01', '10:00:00', '11:15:00', '0', '1', '0', '2026-08-02 12:34:16', '2026-08-02 12:34:16');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('142', NULL, '2026-08-02', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:44', '2026-08-02 12:37:44');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('143', NULL, '2026-08-03', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:44', '2026-08-02 12:37:44');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('144', NULL, '2026-08-04', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:44', '2026-08-02 12:37:44');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('145', NULL, '2026-08-05', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:44', '2026-08-02 12:37:44');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('146', NULL, '2026-08-06', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:44', '2026-08-02 12:37:44');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('147', NULL, '2026-08-07', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:44', '2026-08-02 12:37:44');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('148', NULL, '2026-08-08', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:44', '2026-08-02 12:37:44');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('149', NULL, '2026-08-09', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('150', NULL, '2026-08-10', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('151', NULL, '2026-08-11', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('152', NULL, '2026-08-12', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('153', NULL, '2026-08-13', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('154', NULL, '2026-08-14', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('155', NULL, '2026-08-15', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('156', NULL, '2026-08-16', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('157', NULL, '2026-08-17', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('158', NULL, '2026-08-18', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('159', NULL, '2026-08-19', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('160', NULL, '2026-08-20', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('161', NULL, '2026-08-21', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('162', NULL, '2026-08-22', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('163', NULL, '2026-08-23', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('164', NULL, '2026-08-24', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('165', NULL, '2026-08-25', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('166', NULL, '2026-08-26', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('167', NULL, '2026-08-27', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('168', NULL, '2026-08-28', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('169', NULL, '2026-08-29', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('170', NULL, '2026-08-30', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('171', NULL, '2026-08-31', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('172', NULL, '2026-09-01', '11:30:00', '00:15:00', '0', '1', '0', '2026-08-02 12:37:45', '2026-08-02 12:37:45');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('173', '1', '2026-08-03', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('174', '1', '2026-08-04', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('175', '1', '2026-08-05', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('176', '1', '2026-08-06', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('177', '1', '2026-08-07', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('178', '1', '2026-08-08', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('179', '1', '2026-08-09', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('180', '1', '2026-08-10', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('181', '1', '2026-08-11', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('182', '1', '2026-08-12', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('183', '1', '2026-08-13', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('184', '1', '2026-08-14', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('185', '1', '2026-08-15', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('186', '1', '2026-08-16', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('187', '1', '2026-08-17', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('188', '1', '2026-08-18', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('189', '1', '2026-08-19', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('190', '1', '2026-08-20', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('191', '1', '2026-08-21', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('192', '1', '2026-08-22', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('193', '1', '2026-08-23', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('194', '1', '2026-08-24', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('195', '1', '2026-08-25', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('196', '1', '2026-08-26', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:31', '2026-08-03 10:03:31');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('197', '1', '2026-08-27', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:32', '2026-08-03 10:03:32');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('198', '1', '2026-08-28', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:32', '2026-08-03 10:03:32');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('199', '1', '2026-08-29', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:32', '2026-08-03 10:03:32');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('200', '1', '2026-08-30', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:32', '2026-08-03 10:03:32');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('201', '1', '2026-08-31', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:32', '2026-08-03 10:03:32');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('202', '1', '2026-09-01', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:32', '2026-08-03 10:03:32');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('203', '1', '2026-09-02', '10:00:00', '11:00:00', '0', '1', '0', '2026-08-03 10:03:32', '2026-08-03 10:03:32');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('204', '1', '2026-08-03', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('205', '1', '2026-08-04', '11:00:00', '11:30:00', '0', '1', '1', '2026-08-03 10:04:12', '2026-08-03 10:05:22');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('206', '1', '2026-08-05', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('207', '1', '2026-08-06', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('208', '1', '2026-08-07', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('209', '1', '2026-08-08', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('210', '1', '2026-08-09', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('211', '1', '2026-08-10', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('212', '1', '2026-08-11', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('213', '1', '2026-08-12', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('214', '1', '2026-08-13', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('215', '1', '2026-08-14', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('216', '1', '2026-08-15', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('217', '1', '2026-08-16', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('218', '1', '2026-08-17', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('219', '1', '2026-08-18', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('220', '1', '2026-08-19', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('221', '1', '2026-08-20', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('222', '1', '2026-08-21', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('223', '1', '2026-08-22', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('224', '1', '2026-08-23', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('225', '1', '2026-08-24', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('226', '1', '2026-08-25', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('227', '1', '2026-08-26', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('228', '1', '2026-08-27', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('229', '1', '2026-08-28', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('230', '1', '2026-08-29', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('231', '1', '2026-08-30', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('232', '1', '2026-08-31', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('233', '1', '2026-09-01', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');
INSERT INTO `slots` (`id`, `beautician_id`, `date`, `start_time`, `end_time`, `is_blocked`, `max_capacity`, `booked_count`, `created`, `modified`) VALUES ('234', '1', '2026-09-02', '11:00:00', '11:30:00', '0', '1', '0', '2026-08-03 10:04:12', '2026-08-03 10:04:12');

-- Structure for table `users` --
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `users` --
INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `location`, `password`, `role`, `created`, `modified`) VALUES ('1', 'Glamora Admin', 'admin@glamora.com', '+1 555-0192', 'Beverly Hills, CA', '$2y$10$8DUV7FPXImveqipbxQ6cEOAUJCImJ0pQ1kLAwIgitHWMKI4XaXBv2', 'admin', '2026-07-31 15:58:34', '2026-07-31 15:58:34');
INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `location`, `password`, `role`, `created`, `modified`) VALUES ('4', 'Madhusri Damarasingu', 'madhusridamarasingu@gmail.com', '+919491398697', 'Tanuku', '$2y$10$k6ab0.sQxw2HvY2fN6GooON.P.XuXCp0zHLTIc9JomJCR0Y3qmmBS', 'user', '2026-08-02 11:05:00', '2026-08-02 11:05:00');
INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `location`, `password`, `role`, `created`, `modified`) VALUES ('6', 'Sumasri', 'madhudamarasingu@gmail.com', '8309030289', 'Attili', '$2y$10$6Gc468u0oJfNw/ns3Re77OKYDJ1h.uPtewe15yj4/JnhBojFFBRZi', 'admin', '2026-08-02 11:50:23', '2026-08-02 11:50:23');

SET FOREIGN_KEY_CHECKS = 1;
