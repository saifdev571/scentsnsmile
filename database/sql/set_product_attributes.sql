-- Set first 12 active products as bestsellers
UPDATE products 
SET is_bestseller = 1 
WHERE status = 'active' 
ORDER BY created_at DESC 
LIMIT 12;

-- Set first 10 active products as new arrivals
UPDATE products 
SET is_new = 1 
WHERE status = 'active' 
ORDER BY created_at DESC 
LIMIT 10;

-- Verify the changes
SELECT 
    COUNT(*) as total_active,
    SUM(CASE WHEN is_bestseller = 1 THEN 1 ELSE 0 END) as bestsellers,
    SUM(CASE WHEN is_new = 1 THEN 1 ELSE 0 END) as new_arrivals
FROM products 
WHERE status = 'active';
