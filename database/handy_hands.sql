-- ========================================================
-- Handy Hands (BSCS FYP, University of Haripur - Arooj Khan)
-- Complete MySQL Schema & Seed Data for XAMPP
-- ========================================================

CREATE DATABASE IF NOT EXISTS `handy_hands` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `handy_hands`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `service_providers`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `city` VARCHAR(50) DEFAULT 'Haripur',
  `role` ENUM('customer', 'provider', 'admin') NOT NULL DEFAULT 'customer',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `icon_class` VARCHAR(50) DEFAULT 'fa-wrench',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `services` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(120) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `base_price` DECIMAL(10,2) NOT NULL DEFAULT 500.00,
  `estimated_time` VARCHAR(50) DEFAULT '1-2 hours',
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `service_providers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL UNIQUE,
  `category_id` INT NOT NULL,
  `experience_years` INT DEFAULT 2,
  `hourly_rate` DECIMAL(10,2) NOT NULL DEFAULT 600.00,
  `bio` TEXT DEFAULT NULL,
  `status` ENUM('pending', 'approved', 'suspended') DEFAULT 'approved',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_code` VARCHAR(20) NOT NULL UNIQUE,
  `customer_id` INT NOT NULL,
  `service_id` INT NOT NULL,
  `provider_id` INT DEFAULT NULL,
  `booking_date` DATE NOT NULL,
  `time_slot` VARCHAR(30) NOT NULL,
  `service_address` TEXT NOT NULL,
  `notes` TEXT DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'confirmed',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`customer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`provider_id`) REFERENCES `service_providers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL UNIQUE,
  `customer_id` INT NOT NULL,
  `provider_id` INT NOT NULL,
  `rating` INT NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `comment` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`customer_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`provider_id`) REFERENCES `service_providers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Data (Password123 for demo logins)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `city`, `role`) VALUES
(1, 'Administrator', 'admin@handyhands.com', '$2y$10$wK5h6uM8hCjD9xLzC9x9v.7jK3f4pL1m0v4wY2r1s0t4u8v9w0x1y', '0300-1112233', 'Central Hub, Haripur', 'Haripur', 'admin'),
(2, 'Muhammad Tariq', 'tariq.plumber@gmail.com', '$2y$10$wK5h6uM8hCjD9xLzC9x9v.7jK3f4pL1m0v4wY2r1s0t4u8v9w0x1y', '0312-5551234', 'Circular Road, Haripur', 'Haripur', 'provider'),
(3, 'Sajid Ali', 'sajid.electric@gmail.com', '$2y$10$wK5h6uM8hCjD9xLzC9x9v.7jK3f4pL1m0v4wY2r1s0t4u8v9w0x1y', '0333-9876543', 'Sikandar Pur, Haripur', 'Haripur', 'provider'),
(4, 'Zainab Bibi', 'zainab.clean@gmail.com', '$2y$10$wK5h6uM8hCjD9xLzC9x9v.7jK3f4pL1m0v4wY2r1s0t4u8v9w0x1y', '0345-2233445', 'Shah Maqsood, Haripur', 'Haripur', 'provider'),
(5, 'Arooj Khan', 'customer@handyhands.com', '$2y$10$wK5h6uM8hCjD9xLzC9x9v.7jK3f4pL1m0v4wY2r1s0t4u8v9w0x1y', '0300-5203610', 'Model Town, Haripur', 'Haripur', 'customer');

INSERT INTO `categories` (`id`, `name`, `description`, `icon_class`) VALUES
(1, 'Plumbing Services', 'Pipe leak repairs, fixture installations, and drainage solutions.', 'fa-faucet'),
(2, 'Electrical Repairs', 'Wiring, switchboard replacement, fan installation, and safety checks.', 'fa-bolt'),
(3, 'Painting & Decor', 'Interior and exterior home wall painting and touchups.', 'fa-paint-roller'),
(4, 'Home Cleaning', 'Deep cleaning, kitchen sanitation, and carpet care.', 'fa-broom'),
(5, 'Carpentry & Furniture', 'Door fixing, furniture repairs, and customized woodwork.', 'fa-hammer');

INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `base_price`, `estimated_time`) VALUES
(1, 1, 'Pipe Leakage & Tap Repair', 'Fix leaking pipes, taps, and bathroom fixtures.', 600.00, '1 hour'),
(2, 1, 'Water Motor / Geyser Fitting', 'Installation and maintenance of geysers and pumps.', 1500.00, '2-3 hours'),
(3, 2, 'Ceiling Fan Installation & Repair', 'Install or repair ceiling and exhaust fans.', 500.00, '1 hour'),
(4, 2, 'Short Circuit & Wiring Repair', 'Diagnose and fix circuit tripping and damaged wiring.', 1000.00, '1-2 hours'),
(5, 3, 'Single Room Painting', 'Wall preparation, primer, and two coats of paint.', 4500.00, '1 day'),
(6, 4, 'Full House Deep Cleaning', 'Comprehensive cleaning of all rooms, kitchen, and washrooms.', 5000.00, '4-6 hours'),
(7, 5, 'Door Lock & Hinge Repair', 'Fix sticking doors, replace locks and handles.', 700.00, '1 hour');

INSERT INTO `service_providers` (`id`, `user_id`, `category_id`, `experience_years`, `hourly_rate`, `bio`, `status`) VALUES
(1, 2, 1, 6, 700.00, 'Certified sanitary and plumbing technician with 6+ years experience in Haripur and Abbottabad.', 'approved'),
(2, 3, 2, 5, 800.00, 'Licensed residential electrician specializing in safety wiring and appliances.', 'approved'),
(3, 4, 4, 4, 600.00, 'Professional deep-cleaning and sanitation specialist for modern homes.', 'approved');

INSERT INTO `bookings` (`id`, `booking_code`, `customer_id`, `service_id`, `provider_id`, `booking_date`, `time_slot`, `service_address`, `notes`, `total_amount`, `status`) VALUES
(1, 'HH-2026-1001', 5, 1, 1, '2026-11-01', '10:00 AM - 12:00 PM', 'House 42, Street 3, Model Town, Haripur', 'Kitchen tap is leaking continuously.', 600.00, 'completed'),
(2, 'HH-2026-1002', 5, 3, 2, '2026-11-03', '02:00 PM - 04:00 PM', 'House 42, Street 3, Model Town, Haripur', 'Need installation of two new ceiling fans.', 1000.00, 'confirmed');

INSERT INTO `reviews` (`id`, `booking_id`, `customer_id`, `provider_id`, `rating`, `comment`) VALUES
(1, 1, 5, 1, 5, 'Tariq arrived right on time and fixed the tap in 20 minutes. Excellent service!');
