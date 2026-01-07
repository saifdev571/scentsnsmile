-- Mark first 5 products as bundle products for testing
UPDATE products 
SET is_bundle_product = 1 
WHERE status = 'active' 
ORDER BY created_at DESC 
LIMIT 5;

-- Verify the changes
SELECT 
    id,
    name,
    is_bundle_product,
    status
FROM products 
WHERE is_bundle_product = 1;
