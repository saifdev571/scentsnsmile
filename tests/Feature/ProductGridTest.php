<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;

/**
 * Feature: dossier-website-rebuild
 * Tests for product grid display and functionality
 * Requirements: 4.1, 4.2, 4.3, 4.4, 4.6, 5.1, 5.2, 8.2
 */
class ProductGridTest extends TestCase
{

    /**
     * Property 4: Price Display Consistency
     * 
     * For any product with a sale price, the regular price should always be 
     * displayed with strikethrough styling and the sale price should be more prominent.
     * 
     * Validates: Requirements 5.1, 5.2
     * 
     * @return void
     */
    public function test_products_with_sale_price_display_strikethrough_regular_price()
    {
        // Get products from the database that have sale prices
        $products = Product::where('status', 'active')
            ->where('show_in_homepage', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '<', \DB::raw('price'))
            ->get();

        // Skip test if no products with sale prices exist
        if ($products->isEmpty()) {
            $this->markTestSkipped('No products with sale prices found in database');
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        // For each product with a sale price, verify the property holds
        foreach ($products as $product) {
            // Check that sale price is displayed prominently
            $response->assertSee('€' . number_format($product->sale_price, 2), false);
            
            // Check that regular price is displayed
            $response->assertSee('€' . number_format($product->price, 2), false);
            
            // Verify the HTML structure contains strikethrough class for regular price
            $response->assertSee('line-through', false);
            
            // Verify sale price has prominent styling
            $response->assertSee('text-xl font-bold text-black', false);
            
            // Verify regular price has muted styling
            $response->assertSee('text-sm text-gray-500 line-through', false);
        }
    }

    /**
     * Test that products without sale price display only regular price
     * 
     * @return void
     */
    public function test_products_without_sale_price_display_only_regular_price()
    {
        // Get a product without a sale price
        $product = Product::where('status', 'active')
            ->where('show_in_homepage', true)
            ->where(function($query) {
                $query->whereNull('sale_price')
                      ->orWhere('sale_price', '>=', \DB::raw('price'));
            })
            ->first();

        // Skip test if no such product exists
        if (!$product) {
            $this->markTestSkipped('No products without sale prices found in database');
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that regular price is displayed
        $response->assertSee('€' . number_format($product->price, 2), false);
        
        // Check that product name is displayed
        $response->assertSee($product->name, false);
    }

    /**
     * Test that product grid displays category tags
     * 
     * @return void
     */
    public function test_product_grid_displays_category_tags()
    {
        // Get a product with tags
        $product = Product::with('tagsList')
            ->where('status', 'active')
            ->where('show_in_homepage', true)
            ->whereHas('tagsList')
            ->first();

        // Skip test if no product with tags exists
        if (!$product || $product->tagsList->isEmpty()) {
            $this->markTestSkipped('No products with tags found in database');
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that at least one tag is displayed
        $firstTag = $product->tagsList->first();
        $response->assertSee($firstTag->name, false);
        
        // Check that tags have proper styling
        $response->assertSee('text-xs px-2 py-1 bg-gray-100 rounded-full text-gray-700', false);
    }

    /**
     * Test that product grid displays product images with hover effect
     * 
     * @return void
     */
    public function test_product_grid_displays_images_with_hover_effect()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that image has hover scale effect
        $response->assertSee('group-hover:scale-105 transition-transform duration-300', false);
        
        // Check that image container has proper aspect ratio
        $response->assertSee('aspect-square', false);
        
        // Check that image has lazy loading
        $response->assertSee('loading="lazy"', false);
    }

    /**
     * Test that product grid only displays active products
     * 
     * @return void
     */
    public function test_product_grid_only_displays_active_products()
    {
        // Get an active product
        $activeProduct = Product::where('status', 'active')
            ->where('show_in_homepage', true)
            ->first();

        // Get an inactive product if it exists
        $inactiveProduct = Product::where('status', '!=', 'active')
            ->first();

        $response = $this->get('/');
        $response->assertStatus(200);

        // If we have an active product, check it's displayed
        if ($activeProduct) {
            $response->assertSee($activeProduct->name, false);
        }
        
        // If we have an inactive product, check it's NOT displayed
        if ($inactiveProduct) {
            $response->assertDontSee($inactiveProduct->name);
        }
    }

    /**
     * Property 3: Product Grid Responsiveness
     * 
     * For any screen size, the product grid should display the appropriate 
     * number of columns (1 on mobile, 2 on tablet, 3-4 on desktop) with consistent spacing.
     * 
     * Validates: Requirements 4.6, 8.2
     * 
     * @return void
     */
    public function test_product_grid_has_responsive_layout_classes()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that the grid has responsive column classes
        // Mobile: 1 column (grid-cols-1)
        // Tablet: 2 columns (sm:grid-cols-2)
        // Desktop: 3-4 columns (lg:grid-cols-3 xl:grid-cols-4)
        $response->assertSee('grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6', false);
        
        // Verify the grid container exists
        $response->assertSee('id="products"', false);
        
        // Verify the grid has consistent gap spacing
        $response->assertSee('gap-6', false);
    }

    /**
     * Test that product grid section has proper container and padding
     * 
     * @return void
     */
    public function test_product_grid_has_proper_container_and_padding()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that product grid section has proper padding
        $response->assertSee('py-16 bg-white', false);
        
        // Check that grid uses container with proper padding
        $response->assertSee('container mx-auto px-4', false);
    }

    /**
     * Test that product cards have group class for hover effects
     * 
     * @return void
     */
    public function test_product_cards_have_group_class_for_hover_effects()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that product cards have group class
        $response->assertSee('group cursor-pointer', false);
        
        // Check that images have group-hover effect
        $response->assertSee('group-hover:scale-105', false);
    }
}
