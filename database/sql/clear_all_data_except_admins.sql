-- Clear All Database Data Except Admin Users
-- Run this carefully!

SET FOREIGN_KEY_CHECKS = 0;

-- Clear Products & Related
TRUNCATE TABLE product_reviews;
TRUNCATE TABLE review_helpful;
TRUNCATE TABLE product_variants;
TRUNCATE TABLE product_tag;
TRUNCATE TABLE product_collection;
TRUNCATE TABLE product_gender;
TRUNCATE TABLE product_size;
TRUNCATE TABLE product_highlight_note;
TRUNCATE TABLE products;

-- Clear Orders & Related
TRUNCATE TABLE order_items;
TRUNCATE TABLE orders;

-- Clear Carts & Wishlists
TRUNCATE TABLE carts;
TRUNCATE TABLE wishlists;

-- Clear Users (except admins)
DELETE FROM users WHERE id NOT IN (SELECT user_id FROM admins);
TRUNCATE TABLE user_addresses;

-- Clear Categories, Collections, Tags
TRUNCATE TABLE categories;
TRUNCATE TABLE collections;
TRUNCATE TABLE tags;

-- Clear Brands
TRUNCATE TABLE brands;

-- Clear Sizes & Genders
TRUNCATE TABLE sizes;
-- Keep genders but clear their data
UPDATE genders SET thumb_image = NULL, thumb_imagekit_file_id = NULL, thumb_imagekit_url = NULL, thumb_imagekit_thumbnail_url = NULL, main_image = NULL, main_imagekit_file_id = NULL, main_imagekit_url = NULL, main_imagekit_thumbnail_url = NULL;

-- Clear Highlight Notes
TRUNCATE TABLE highlight_notes;

-- Clear Scent Families
TRUNCATE TABLE scent_families;

-- Clear Testimonials
TRUNCATE TABLE testimonials;

-- Clear Banners
TRUNCATE TABLE banners;

-- Clear Blogs & Lookbooks
TRUNCATE TABLE blog_images;
TRUNCATE TABLE blogs;
TRUNCATE TABLE lookbooks;

-- Clear Coupons
TRUNCATE TABLE coupons;

-- Clear Promotions
TRUNCATE TABLE promotions;

-- Clear Bundles
TRUNCATE TABLE bundle_products;
TRUNCATE TABLE bundles;

-- Clear Contact Messages
TRUNCATE TABLE contact_messages;

-- Clear Newsletter Subscribers
TRUNCATE TABLE newsletter_subscribers;

-- Clear Activity Logs (optional - keep if you want history)
-- TRUNCATE TABLE activity_logs;

-- Clear Login Histories (optional - keep if you want history)
-- TRUNCATE TABLE login_histories;

SET FOREIGN_KEY_CHECKS = 1;

-- Success message
SELECT 'Database cleared successfully! Admin users preserved.' AS Status;
