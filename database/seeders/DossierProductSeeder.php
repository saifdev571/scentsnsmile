<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;

class DossierProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories if they don't exist
        $womenCategory = Category::firstOrCreate(
            ['slug' => 'women'],
            [
                'name' => 'Women',
                'description' => 'Perfumes for Women',
                'is_active' => true,
                'show_in_homepage' => true,
            ]
        );

        $menCategory = Category::firstOrCreate(
            ['slug' => 'men'],
            [
                'name' => 'Men',
                'description' => 'Perfumes for Men',
                'is_active' => true,
                'show_in_homepage' => true,
            ]
        );

        $unisexCategory = Category::firstOrCreate(
            ['slug' => 'unisex'],
            [
                'name' => 'Unisex',
                'description' => 'Perfumes for Everyone',
                'is_active' => true,
                'show_in_homepage' => true,
            ]
        );

        // Create scent tags if they don't exist
        $floralTag = Tag::firstOrCreate(
            ['slug' => 'floral'],
            ['name' => 'Floral', 'is_active' => true]
        );

        $woodyTag = Tag::firstOrCreate(
            ['slug' => 'woody'],
            ['name' => 'Woody', 'is_active' => true]
        );

        $amberyTag = Tag::firstOrCreate(
            ['slug' => 'ambery'],
            ['name' => 'Ambery', 'is_active' => true]
        );

        $citrusTag = Tag::firstOrCreate(
            ['slug' => 'citrus'],
            ['name' => 'Citrus', 'is_active' => true]
        );

        // Sample products matching the Dossier website
        $products = [
            [
                'name' => 'Marshmallow',
                'scent_note' => 'Marshmallow',
                'slug' => 'marshmallow',
                'sku' => 'DOS-MARSH-001',
                'description' => 'A sweet, gourmand fragrance with notes of marshmallow, vanilla, and caramel.',
                'short_description' => 'Sweet and comforting marshmallow scent',
                'price' => 49.00,
                'sale_price' => 29.00,
                'stock' => 100,
                'stock_status' => 'in_stock',
                'category_id' => $womenCategory->id,
                'images' => json_encode(['https://images.unsplash.com/photo-1541643600914-78b084683601?w=800']),
                'status' => 'active',
                'is_new' => true,
                'is_featured' => true,
                'show_in_homepage' => true,
                'tags' => [$floralTag->id, $amberyTag->id],
            ],
            [
                'name' => 'Sandalwood',
                'scent_note' => 'Sandalwood',
                'slug' => 'sandalwood',
                'sku' => 'DOS-SAND-001',
                'description' => 'A warm, woody fragrance featuring rich sandalwood with hints of cedar and musk.',
                'short_description' => 'Warm and woody sandalwood essence',
                'price' => 49.00,
                'sale_price' => 29.00,
                'stock' => 100,
                'stock_status' => 'in_stock',
                'category_id' => $menCategory->id,
                'images' => json_encode(['https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=800']),
                'status' => 'active',
                'is_featured' => true,
                'show_in_homepage' => true,
                'tags' => [$woodyTag->id],
            ],
            [
                'name' => 'Saffron',
                'scent_note' => 'Saffron',
                'slug' => 'saffron',
                'sku' => 'DOS-SAFF-001',
                'description' => 'An exotic, spicy fragrance with saffron, amber, and leather notes.',
                'short_description' => 'Exotic and spicy saffron blend',
                'price' => 49.00,
                'sale_price' => 29.00,
                'stock' => 100,
                'stock_status' => 'in_stock',
                'category_id' => $unisexCategory->id,
                'images' => json_encode(['https://images.unsplash.com/photo-1588405748880-12d1d2a59d75?w=800']),
                'status' => 'active',
                'is_featured' => true,
                'show_in_homepage' => true,
                'tags' => [$amberyTag->id, $woodyTag->id],
            ],
            [
                'name' => 'Sage',
                'scent_note' => 'Sage',
                'slug' => 'sage',
                'sku' => 'DOS-SAGE-001',
                'description' => 'A fresh, herbal fragrance with sage, lavender, and citrus notes.',
                'short_description' => 'Fresh and herbal sage aroma',
                'price' => 49.00,
                'sale_price' => 29.00,
                'stock' => 100,
                'stock_status' => 'in_stock',
                'category_id' => $unisexCategory->id,
                'images' => json_encode(['https://images.unsplash.com/photo-1615634260167-c8cdede054de?w=800']),
                'status' => 'active',
                'is_new' => true,
                'show_in_homepage' => true,
                'tags' => [$citrusTag->id],
            ],
            [
                'name' => 'Vanilla',
                'scent_note' => 'Vanilla',
                'slug' => 'vanilla',
                'sku' => 'DOS-VANI-001',
                'description' => 'A classic, sweet fragrance with vanilla, tonka bean, and caramel.',
                'short_description' => 'Classic sweet vanilla scent',
                'price' => 49.00,
                'sale_price' => 29.00,
                'stock' => 100,
                'stock_status' => 'in_stock',
                'category_id' => $womenCategory->id,
                'images' => json_encode(['https://images.unsplash.com/photo-1594035910387-fea47794261f?w=800']),
                'status' => 'active',
                'is_bestseller' => true,
                'show_in_homepage' => true,
                'tags' => [$floralTag->id, $amberyTag->id],
            ],
            [
                'name' => 'Tea',
                'scent_note' => 'Tea',
                'slug' => 'tea',
                'sku' => 'DOS-TEA-001',
                'description' => 'A refreshing, clean fragrance with green tea, bergamot, and white musk.',
                'short_description' => 'Refreshing green tea fragrance',
                'price' => 49.00,
                'sale_price' => 29.00,
                'stock' => 100,
                'stock_status' => 'in_stock',
                'category_id' => $unisexCategory->id,
                'images' => json_encode(['https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=800']),
                'status' => 'active',
                'is_trending' => true,
                'show_in_homepage' => true,
                'tags' => [$citrusTag->id, $floralTag->id],
            ],
        ];

        foreach ($products as $productData) {
            $tags = $productData['tags'] ?? [];
            unset($productData['tags']);

            $product = Product::updateOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );

            // Attach tags to product
            if (!empty($tags)) {
                $product->tagsList()->sync($tags);
            }
        }

        $this->command->info('Dossier products seeded successfully!');
    }
}
