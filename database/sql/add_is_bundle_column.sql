-- Add is_bundle_product column to products table
-- Run this on your SCENTSNSMILE database

ALTER TABLE products 
ADD COLUMN is_bundle_product TINYINT(1) NOT NULL DEFAULT 0 
AFTER show_in_homepage;

-- Optional: Mark some existing products as bundle products (example)
-- UPDATE products SET is_bundle_product = 1 WHERE id IN (1, 2, 3, 4, 5);
