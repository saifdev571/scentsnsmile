-- =====================================================
-- MOMENTS MODULE: CONVERT TO MULTIPLE SELECTION
-- =====================================================
-- This SQL updates the moments module to support multiple moments per product
-- Run this on production after the basic moments module is already set up
-- =====================================================

-- Step 1: Create pivot table for many-to-many relationship
CREATE TABLE IF NOT EXISTS `product_moment` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `moment_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_moment_product_id_moment_id_unique` (`product_id`,`moment_id`),
  KEY `product_moment_product_id_foreign` (`product_id`),
  KEY `product_moment_moment_id_foreign` (`moment_id`),
  CONSTRAINT `product_moment_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_moment_moment_id_foreign` FOREIGN KEY (`moment_id`) REFERENCES `moments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Step 2: Migrate existing data from moment_id column to pivot table
-- This preserves existing moment associations
INSERT INTO `product_moment` (`product_id`, `moment_id`, `created_at`, `updated_at`)
SELECT `id`, `moment_id`, NOW(), NOW()
FROM `products`
WHERE `moment_id` IS NOT NULL
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Step 3: (Optional) Drop the old moment_id column from products table
-- Uncomment the line below if you want to remove the old single-selection column
-- WARNING: Only do this after verifying the pivot table is working correctly!
-- ALTER TABLE `products` DROP FOREIGN KEY `products_moment_id_foreign`;
-- ALTER TABLE `products` DROP COLUMN `moment_id`;

-- =====================================================
-- DONE! Products can now have multiple moments
-- =====================================================
-- Changes made:
-- 1. Created product_moment pivot table
-- 2. Migrated existing moment_id data to pivot table
-- 3. Products can now be associated with multiple moments
-- 4. Old moment_id column kept for safety (can be removed later)
-- =====================================================
