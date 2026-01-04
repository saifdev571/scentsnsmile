-- =====================================================
-- Scents N Smile - Database Changes (2nd January 2026)
-- =====================================================
-- Run this SQL in phpMyAdmin or MySQL CLI
-- =====================================================

-- -----------------------------------------------------
-- 1. PROMOTIONS TABLE (for banner promotions)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `promotions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `subtitle` VARCHAR(255) NULL,
    `link` VARCHAR(255) NULL,
    `link_text` VARCHAR(100) NULL DEFAULT 'Shop Now',
    `background_color` VARCHAR(20) NULL DEFAULT '#e8a598',
    `text_color` VARCHAR(20) NULL DEFAULT '#ffffff',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `starts_at` TIMESTAMP NULL,
    `ends_at` TIMESTAMP NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `promotions_is_active_index` (`is_active`),
    INDEX `promotions_starts_at_index` (`starts_at`),
    INDEX `promotions_ends_at_index` (`ends_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- 2. SHIPROCKET FIELDS IN ORDERS TABLE
-- -----------------------------------------------------
ALTER TABLE `orders` 
    ADD COLUMN IF NOT EXISTS `shiprocket_order_id` VARCHAR(50) NULL AFTER `delivered_at`,
    ADD COLUMN IF NOT EXISTS `shiprocket_shipment_id` VARCHAR(50) NULL AFTER `shiprocket_order_id`,
    ADD COLUMN IF NOT EXISTS `shiprocket_awb_code` VARCHAR(50) NULL AFTER `shiprocket_shipment_id`,
    ADD COLUMN IF NOT EXISTS `shiprocket_courier_id` VARCHAR(50) NULL AFTER `shiprocket_awb_code`,
    ADD COLUMN IF NOT EXISTS `shiprocket_courier_name` VARCHAR(100) NULL AFTER `shiprocket_courier_id`,
    ADD COLUMN IF NOT EXISTS `shiprocket_label_url` TEXT NULL AFTER `shiprocket_courier_name`,
    ADD COLUMN IF NOT EXISTS `shiprocket_manifest_url` TEXT NULL AFTER `shiprocket_label_url`,
    ADD COLUMN IF NOT EXISTS `shiprocket_invoice_url` TEXT NULL AFTER `shiprocket_manifest_url`,
    ADD COLUMN IF NOT EXISTS `shiprocket_status` VARCHAR(50) NULL AFTER `shiprocket_invoice_url`,
    ADD COLUMN IF NOT EXISTS `shiprocket_tracking_url` TEXT NULL AFTER `shiprocket_status`,
    ADD COLUMN IF NOT EXISTS `shiprocket_pickup_scheduled_date` DATE NULL AFTER `shiprocket_tracking_url`,
    ADD COLUMN IF NOT EXISTS `shiprocket_expected_delivery_date` DATE NULL AFTER `shiprocket_pickup_scheduled_date`;

-- Add indexes for Shiprocket fields
ALTER TABLE `orders` 
    ADD INDEX IF NOT EXISTS `orders_shiprocket_order_id_index` (`shiprocket_order_id`),
    ADD INDEX IF NOT EXISTS `orders_shiprocket_awb_code_index` (`shiprocket_awb_code`),
    ADD INDEX IF NOT EXISTS `orders_shiprocket_status_index` (`shiprocket_status`);

-- -----------------------------------------------------
-- 3. SHIPPING DIMENSIONS IN PRODUCTS TABLE
-- -----------------------------------------------------
ALTER TABLE `products`
    ADD COLUMN IF NOT EXISTS `length` DECIMAL(8,2) NULL DEFAULT 10.00 COMMENT 'Length in cm',
    ADD COLUMN IF NOT EXISTS `breadth` DECIMAL(8,2) NULL DEFAULT 10.00 COMMENT 'Breadth in cm',
    ADD COLUMN IF NOT EXISTS `height` DECIMAL(8,2) NULL DEFAULT 10.00 COMMENT 'Height in cm',
    ADD COLUMN IF NOT EXISTS `weight` DECIMAL(8,3) NULL DEFAULT 0.500 COMMENT 'Weight in KG';

-- -----------------------------------------------------
-- 4. SCENT FAMILIES TABLE
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `scent_families` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `imagekit_file_id` VARCHAR(255) NULL,
    `imagekit_url` TEXT NULL,
    `imagekit_thumbnail_url` TEXT NULL,
    `imagekit_file_path` VARCHAR(500) NULL,
    `image_size` INT UNSIGNED NULL,
    `original_image_size` INT UNSIGNED NULL,
    `image_width` INT UNSIGNED NULL,
    `image_height` INT UNSIGNED NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `scent_families_slug_unique` (`slug`),
    INDEX `scent_families_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- 5. PRODUCT SCENT FAMILY PIVOT TABLE
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_scent_family` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `scent_family_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `product_scent_family_product_id_index` (`product_id`),
    INDEX `product_scent_family_scent_family_id_index` (`scent_family_id`),
    UNIQUE INDEX `product_scent_family_unique` (`product_id`, `scent_family_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- 6. INSERT DEFAULT SETTINGS (if not exists)
-- -----------------------------------------------------
INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) 
SELECT 'shipping_charge', '99', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `settings` WHERE `key` = 'shipping_charge');

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) 
SELECT 'free_shipping_threshold', '999', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `settings` WHERE `key` = 'free_shipping_threshold');

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) 
SELECT 'shiprocket_enabled', '0', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `settings` WHERE `key` = 'shiprocket_enabled');

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) 
SELECT 'shiprocket_email', '', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `settings` WHERE `key` = 'shiprocket_email');

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) 
SELECT 'shiprocket_password', '', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `settings` WHERE `key` = 'shiprocket_password');

-- =====================================================
-- END OF SQL
-- =====================================================
