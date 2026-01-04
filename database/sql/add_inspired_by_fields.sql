-- Add inspired_by fields to products table
-- Run this SQL on Hostinger phpMyAdmin

ALTER TABLE `products` 
ADD COLUMN `inspired_by` VARCHAR(255) NULL AFTER `name`,
ADD COLUMN `retail_price` DECIMAL(10,2) NULL AFTER `inspired_by`,
ADD COLUMN `retail_price_color` VARCHAR(20) NULL DEFAULT '#B8860B' AFTER `retail_price`;
