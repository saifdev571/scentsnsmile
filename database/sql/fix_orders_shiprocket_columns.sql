-- =====================================================
-- Scents N Smile - Fix Orders Shiprocket Columns
-- =====================================================
-- Run this SQL in phpMyAdmin on Hostinger
-- Database: u426898920_ecom
-- Date: 4th January 2026
-- =====================================================

-- NOTE: If any column already exists, that ALTER will fail
-- but other statements will continue. This is expected.

-- Add shiprocket_awb_code
ALTER TABLE `orders` ADD COLUMN `shiprocket_awb_code` VARCHAR(50) NULL;

-- Add shiprocket_courier_id
ALTER TABLE `orders` ADD COLUMN `shiprocket_courier_id` INT NULL;

-- Add shiprocket_courier_name
ALTER TABLE `orders` ADD COLUMN `shiprocket_courier_name` VARCHAR(100) NULL;

-- Add shiprocket_label_url
ALTER TABLE `orders` ADD COLUMN `shiprocket_label_url` TEXT NULL;

-- Add shiprocket_manifest_url
ALTER TABLE `orders` ADD COLUMN `shiprocket_manifest_url` TEXT NULL;

-- Add shiprocket_invoice_url
ALTER TABLE `orders` ADD COLUMN `shiprocket_invoice_url` TEXT NULL;

-- Add shiprocket_status (THIS FIXES THE ERROR)
ALTER TABLE `orders` ADD COLUMN `shiprocket_status` VARCHAR(50) NULL;

-- Add shiprocket_tracking_url
ALTER TABLE `orders` ADD COLUMN `shiprocket_tracking_url` TEXT NULL;

-- Add shiprocket_pickup_scheduled_date
ALTER TABLE `orders` ADD COLUMN `shiprocket_pickup_scheduled_date` DATE NULL;

-- Add shiprocket_expected_delivery_date
ALTER TABLE `orders` ADD COLUMN `shiprocket_expected_delivery_date` DATE NULL;

-- =====================================================
-- END OF SQL
-- =====================================================
