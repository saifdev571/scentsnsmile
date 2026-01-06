-- Fix meta_description column size in products table
-- Change from VARCHAR(160) to TEXT to allow unlimited length

ALTER TABLE `products` 
MODIFY COLUMN `meta_description` TEXT NULL;

-- Also update og_description to TEXT if needed
ALTER TABLE `products` 
MODIFY COLUMN `og_description` TEXT NULL;

-- Verify the changes
DESCRIBE `products`;
