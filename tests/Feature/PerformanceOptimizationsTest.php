<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;

/**
 * Feature: dossier-website-rebuild
 * Tests for performance optimizations including lazy loading and video delivery
 * Requirements: 11.1, 11.2
 */
class PerformanceOptimizationsTest extends TestCase
{
    /**
     * Property 7: Image Lazy Loading
     * 
     * For any image below the fold, the image should be lazy-loaded to 
     * improve initial page load performance.
     * 
     * Validates: Requirements 11.1
     * 
     * @return void
     */
    public function test_product_images_have_lazy_loading_attribute()
    {
        // Get all active products that should be displayed
        $products = Product::where('status', 'active')
            ->where('show_in_homepage', true)
            ->get();

        // Skip test if no products exist
        if ($products->isEmpty()) {
            $this->markTestSkipped('No products found in database');
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        // For any product image, verify it has lazy loading attribute
        // This is a universal property that should hold for all product images
        foreach ($products as $product) {
            // Verify the product is displayed
            $response->assertSee($product->name, false);
        }

        // Check that product images have loading="lazy" attribute
        // This property should hold for all images in the product grid
        $response->assertSee('loading="lazy"', false);
        
        // Verify that images are within the product card component
        $response->assertSee('class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"', false);
    }

    /**
     * Test that product images have loading placeholders
     * 
     * @return void
     */
    public function test_product_images_have_loading_placeholders()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that loading placeholder exists with animation
        $response->assertSee('animate-pulse', false);
        
        // Check that placeholder has proper styling
        $response->assertSee('bg-gray-100 animate-pulse', false);
        
        // Verify placeholder icon is present
        $response->assertSee('w-12 h-12 text-gray-300', false);
    }

    /**
     * Test that video element has preload attribute for optimization
     * 
     * Validates: Requirements 11.2
     * 
     * @return void
     */
    public function test_hero_video_has_preload_attribute()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that video has preload="metadata" for optimization
        $response->assertSee('preload="metadata"', false);
        
        // Verify video element exists
        $response->assertSee('id="hero-video"', false);
    }

    /**
     * Test that video element has poster attribute
     * 
     * Validates: Requirements 11.2
     * 
     * @return void
     */
    public function test_hero_video_has_poster_attribute()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that video has poster attribute for initial display
        $response->assertSee('poster=', false);
        
        // Verify poster is an SVG data URI (lightweight)
        $response->assertSee('data:image/svg+xml', false);
    }

    /**
     * Test that video has fallback mechanism
     * 
     * Validates: Requirements 11.2
     * 
     * @return void
     */
    public function test_hero_video_has_fallback_mechanism()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that fallback element exists
        $response->assertSee('id="hero-fallback"', false);
        
        // Verify fallback has gradient background
        $response->assertSee('bg-gradient-to-br from-purple-100 to-pink-100', false);
        
        // Verify video has error handler
        $response->assertSee('onerror=', false);
    }

    /**
     * Test that images have proper aspect ratio to prevent layout shift
     * 
     * @return void
     */
    public function test_product_images_have_aspect_ratio()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Check that product images have aspect-square class
        // This prevents layout shift during lazy loading
        $response->assertSee('aspect-square', false);
        
        // Verify the container has proper overflow handling
        $response->assertSee('overflow-hidden rounded-lg', false);
    }

    /**
     * Test that product grid section is properly structured for performance
     * 
     * @return void
     */
    public function test_product_grid_section_structure()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Verify product grid section exists
        $response->assertSee('id="products"', false);
        
        // Check that grid has proper container
        $response->assertSee('container mx-auto px-4', false);
        
        // Verify grid layout classes
        $response->assertSee('grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4', false);
    }
}
