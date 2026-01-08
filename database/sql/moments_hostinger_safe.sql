-- ============================================
-- MOMENTS MODULE - HOSTINGER SAFE SETUP
-- Use this if the first file gives "column already exists" error
-- Copy paste this entire file in Hostinger phpMyAdmin SQL tab and click GO
-- ============================================

-- Drop foreign key if exists (to avoid errors)
ALTER TABLE `products` DROP FOREIGN KEY IF EXISTS `products_moment_id_foreign`;

-- Drop moment_id column if exists (to start fresh)
ALTER TABLE `products` DROP COLUMN IF EXISTS `moment_id`;

-- Drop moments table if exists (to start fresh)
DROP TABLE IF EXISTS `moments`;

-- Now create everything fresh
CREATE TABLE `moments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_navbar` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_homepage` tinyint(1) NOT NULL DEFAULT 0,
  `imagekit_file_id` varchar(255) DEFAULT NULL,
  `imagekit_url` text DEFAULT NULL,
  `imagekit_thumbnail_url` text DEFAULT NULL,
  `imagekit_file_path` varchar(255) DEFAULT NULL,
  `image_size` bigint(20) DEFAULT NULL,
  `original_image_size` bigint(20) DEFAULT NULL,
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `moments_slug_unique` (`slug`),
  KEY `moments_is_active_index` (`is_active`),
  KEY `moments_is_featured_index` (`is_featured`),
  KEY `moments_show_in_navbar_index` (`show_in_navbar`),
  KEY `moments_show_in_homepage_index` (`show_in_homepage`),
  KEY `moments_sort_order_index` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add moment_id column to products table
ALTER TABLE `products` 
ADD COLUMN `moment_id` bigint(20) UNSIGNED NULL DEFAULT NULL AFTER `category_id`,
ADD KEY `products_moment_id_foreign` (`moment_id`),
ADD CONSTRAINT `products_moment_id_foreign` 
FOREIGN KEY (`moment_id`) 
REFERENCES `moments` (`id`) 
ON DELETE SET NULL;
