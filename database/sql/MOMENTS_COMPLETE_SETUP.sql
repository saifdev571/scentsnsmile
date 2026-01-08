-- =====================================================
-- MOMENTS MODULE - COMPLETE SETUP (MULTIPLE SELECTION)
-- =====================================================
-- This is the COMPLETE SQL for setting up the Moments module
-- with MULTIPLE SELECTION support from scratch
-- Copy and paste this entire file into phpMyAdmin on Hostinger
-- =====================================================

-- Step 1: Create moments table
CREATE TABLE IF NOT EXISTS `moments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `imagekit_file_id` varchar(255) DEFAULT NULL,
  `imagekit_url` text DEFAULT NULL,
  `imagekit_thumbnail_url` text DEFAULT NULL,
  `imagekit_file_path` varchar(500) DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `original_image_size` int(11) DEFAULT NULL,
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_navbar` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_homepage` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `moments_slug_unique` (`slug`),
  KEY `moments_is_active_index` (`is_active`),
  KEY `moments_is_featured_index` (`is_featured`),
  KEY `moments_show_in_navbar_index` (`show_in_navbar`),
  KEY `moments_show_in_homepage_index` (`show_in_homepage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Step 2: Create product_moment pivot table (for multiple moments per product)
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

-- Step 3: Insert sample moments data (optional - remove if not needed)
INSERT INTO `moments` (`name`, `slug`, `sort_order`, `is_active`, `is_featured`, `show_in_navbar`, `show_in_homepage`, `created_at`, `updated_at`) VALUES
('Anniversary', 'anniversary', 1, 1, 1, 1, 1, NOW(), NOW()),
('Birthday', 'birthday', 2, 1, 1, 1, 1, NOW(), NOW()),
('Date Night', 'date-night', 3, 1, 1, 1, 1, NOW(), NOW()),
('Wedding', 'wedding', 4, 1, 1, 1, 1, NOW(), NOW()),
('Office', 'office', 5, 1, 0, 1, 0, NOW(), NOW()),
('Casual', 'casual', 6, 1, 0, 1, 0, NOW(), NOW()),
('Party', 'party', 7, 1, 0, 1, 0, NOW(), NOW()),
('Formal Event', 'formal-event', 8, 1, 0, 1, 0, NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Step 4: Migrate existing moment_id data to pivot table (if moment_id column exists)
-- This preserves existing single moment associations
INSERT INTO `product_moment` (`product_id`, `moment_id`, `created_at`, `updated_at`)
SELECT `id`, `moment_id`, NOW(), NOW()
FROM `products`
WHERE `moment_id` IS NOT NULL
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- =====================================================
-- DONE! Moments module is now fully set up
-- =====================================================
-- What was created:
-- 1. moments table - stores all moment/occasion data
-- 2. product_moment pivot table - allows multiple moments per product
-- 3. Sample moments data (8 moments)
-- 4. Migrated existing moment_id data to pivot table
-- 
-- Features:
-- - Products can have MULTIPLE moments
-- - Full CRUD in admin panel
-- - Image upload with ImageKit
-- - Active/Featured/Show in Navbar/Show on Homepage toggles
-- - Bulk actions (activate, deactivate, delete)
-- - Export to CSV
-- - Searchable dropdown in product create/edit
-- - Frontend collection pages
-- - Home page moments section
-- =====================================================
