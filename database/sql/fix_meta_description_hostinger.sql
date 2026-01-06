-- Fix meta_description column size in products table for Hostinger
-- Database: u426898920_ecom
-- Change from VARCHAR(160) to TEXT to allow unlimited length

USE u426898920_ecom;

ALTER TABLE `products` 
MODIFY COLUMN `meta_description` TEXT NULL;

ALTER TABLE `products` 
MODIFY COLUMN `og_description` TEXT NULL;

-- Verify the changes
DESCRIBE `products`;
