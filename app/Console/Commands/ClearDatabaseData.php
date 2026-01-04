<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearDatabaseData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear-data {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all database data except admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('This will delete ALL data except admin users. Are you sure?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Clearing database data...');

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            // Clear Products & Related
            $this->clearTable('product_reviews', 'Product Reviews');
            $this->clearTable('review_helpful', 'Review Helpful');
            $this->clearTable('product_variants', 'Product Variants');
            $this->clearTable('product_tag', 'Product Tags');
            $this->clearTable('product_collection', 'Product Collections');
            $this->clearTable('product_gender', 'Product Genders');
            $this->clearTable('product_size', 'Product Sizes');
            $this->clearTable('product_highlight_note', 'Product Highlight Notes');
            $this->clearTable('products', 'Products');

            // Clear Orders & Related
            $this->clearTable('order_items', 'Order Items');
            $this->clearTable('orders', 'Orders');

            // Clear Carts & Wishlists
            $this->clearTable('carts', 'Carts');
            $this->clearTable('wishlists', 'Wishlists');

            // Clear Users (except those who are admins)
            // Since admins are in separate table, we can clear all regular users
            // But let's keep users who have admin email
            $adminEmails = DB::table('admins')->pluck('email')->toArray();
            $deletedUsers = DB::table('users')->whereNotIn('email', $adminEmails)->delete();
            $this->line("  ✓ Users (kept users with admin emails, deleted $deletedUsers regular users)");
            
            $this->clearTable('user_addresses', 'User Addresses');

            // Clear Categories, Collections, Tags
            $this->clearTable('categories', 'Categories');
            $this->clearTable('collections', 'Collections');
            $this->clearTable('tags', 'Tags');

            // Clear Brands
            $this->clearTable('brands', 'Brands');

            // Clear Sizes
            $this->clearTable('sizes', 'Sizes');

            // Clear Genders images but keep the records
            try {
                DB::table('genders')->update([
                    'thumb_image' => null,
                    'main_image' => null,
                ]);
                $this->line("  ✓ Genders (cleared images, kept records)");
            } catch (\Exception $e) {
                $this->line("  ✓ Genders (kept as is)");
            }

            // Clear Highlight Notes
            $this->clearTable('highlight_notes', 'Highlight Notes');

            // Clear Scent Families
            $this->clearTable('scent_families', 'Scent Families');

            // Clear Testimonials
            $this->clearTable('testimonials', 'Testimonials');

            // Clear Banners
            $this->clearTable('banners', 'Banners');

            // Clear Blogs & Lookbooks
            $this->clearTable('blog_images', 'Blog Images');
            $this->clearTable('blogs', 'Blogs');
            $this->clearTable('lookbooks', 'Lookbooks');

            // Clear Coupons
            $this->clearTable('coupons', 'Coupons');

            // Clear Promotions
            $this->clearTable('promotions', 'Promotions');

            // Clear Bundles
            $this->clearTable('bundle_products', 'Bundle Products');
            $this->clearTable('bundles', 'Bundles');

            // Clear Contact Messages
            $this->clearTable('contact_messages', 'Contact Messages');

            // Clear Newsletter Subscribers
            $this->clearTable('newsletter_subscribers', 'Newsletter Subscribers');

            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

            $this->newLine();
            $this->info('✅ Database cleared successfully!');
            $this->info('Admin users have been preserved.');

            return 0;

        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            $this->error('Error clearing database: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Clear a table and show progress
     */
    private function clearTable($table, $label)
    {
        try {
            $count = DB::table($table)->count();
            DB::table($table)->truncate();
            $this->line("  ✓ $label ($count records cleared)");
        } catch (\Exception $e) {
            $this->warn("  ⚠ $label (table might not exist)");
        }
    }
}
