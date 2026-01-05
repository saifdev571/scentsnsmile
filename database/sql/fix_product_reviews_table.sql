-- =====================================================
-- Scents N Smile - Fix Product Reviews Table
-- =====================================================
-- Run this SQL in phpMyAdmin on Hostinger
-- Database: u426898920_ecom
-- Date: 4th January 2026
-- =====================================================

-- Step 1: Add missing columns to product_reviews table

-- Add name column for guest users
ALTER TABLE `product_reviews` ADD COLUMN `name` VARCHAR(255) NULL AFTER `user_id`;

-- Add email column for guest users
ALTER TABLE `product_reviews` ADD COLUMN `email` VARCHAR(255) NULL AFTER `name`;

-- Add comment column (rename from review)
ALTER TABLE `product_reviews` ADD COLUMN `comment` TEXT NULL AFTER `title`;

-- Copy data from review to comment
UPDATE `product_reviews` SET `comment` = `review` WHERE `review` IS NOT NULL;

-- Add images column for review images
ALTER TABLE `product_reviews` ADD COLUMN `images` JSON NULL AFTER `comment`;

-- Add is_verified_purchase column
ALTER TABLE `product_reviews` ADD COLUMN `is_verified_purchase` TINYINT(1) DEFAULT 0 AFTER `images`;

-- Copy data from is_verified to is_verified_purchase
UPDATE `product_reviews` SET `is_verified_purchase` = `is_verified` WHERE `is_verified` IS NOT NULL;

-- Add helpful_count column
ALTER TABLE `product_reviews` ADD COLUMN `helpful_count` INT DEFAULT 0 AFTER `is_approved`;

-- Step 2: Create review_helpful table
CREATE TABLE IF NOT EXISTS `review_helpful` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `review_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `review_helpful_unique` (`review_id`, `ip_address`),
    INDEX `review_helpful_review_id_index` (`review_id`),
    CONSTRAINT `review_helpful_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `product_reviews` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- END OF SQL
-- =====================================================
