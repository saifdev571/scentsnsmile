-- Set first 8 active products as featured
UPDATE products 
SET is_featured = 1 
WHERE status = 'active' 
ORDER BY created_at DESC 
LIMIT 8;

-- Verify the changes
SELECT 
    COUNT(*) as total_active,
    SUM(CASE WHEN is_featured = 1 THEN 1 ELSE 0 END) as featured,
    SUM(CASE WHEN is_bestseller = 1 THEN 1 ELSE 0 END) as bestsellers,
    SUM(CASE WHEN is_new = 1 THEN 1 ELSE 0 END) as new_arrivals,
    SUM(CASE WHEN show_in_homepage = 1 THEN 1 ELSE 0 END) as show_homepage
FROM products 
WHERE status = 'active';
