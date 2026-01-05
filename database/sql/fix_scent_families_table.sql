-- =====================================================
-- Scents N Smile - Fix Scent Families Table
-- =====================================================
-- Run this SQL in phpMyAdmin on Hostinger
-- Database: u426898920_ecom
-- Date: 4th January 2026
-- =====================================================

-- Add missing image dimension columns to scent_families table

-- Add image_size column
ALTER TABLE `scent_families` ADD COLUMN `image_size` INT UNSIGNED NULL AFTER `imagekit_file_path`;

-- Add original_image_size column
ALTER TABLE `scent_families` ADD COLUMN `original_image_size` INT UNSIGNED NULL AFTER `image_size`;

-- Add image_width column
ALTER TABLE `scent_families` ADD COLUMN `image_width` INT UNSIGNED NULL AFTER `original_image_size`;

-- Add image_height column
ALTER TABLE `scent_families` ADD COLUMN `image_height` INT UNSIGNED NULL AFTER `image_width`;

-- =====================================================
-- VERIFICATION: Run this to check columns were added
-- =====================================================
-- SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
-- WHERE TABLE_NAME = 'scent_families' AND COLUMN_NAME LIKE 'image%';

-- =====================================================
-- END OF SQL
-- =====================================================
