<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Tests for hero section with video background
 * Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 8.2
 */
class HeroSectionTest extends TestCase
{
    /**
     * Property 2: Video Fallback Handling
     * 
     * For any video element that fails to load, the system should display 
     * a fallback background image without breaking the layout.
     * 
     * Validates: Requirements 1.5
     * 
     * @return void
     */
    public function test_video_fallback_mechanism_is_present()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that video element exists with proper attributes
        $response->assertSee('id="hero-video"', false);
        $response->assertSee('autoplay', false);
        $response->assertSee('muted', false);
        $response->assertSee('loop', false);
        $response->assertSee('playsinline', false);
        
        // Check that video has onerror handler for fallback
        $response->assertSee('onerror=', false);
        
        // Check that fallback background element exists
        $response->assertSee('id="hero-fallback"', false);
        
        // Check that fallback has gradient background classes
        $response->assertSee('bg-gradient-to-br from-purple-100 to-pink-100', false);
        
        // Check that video has onloadeddata handler to hide fallback
        $response->assertSee('onloadeddata=', false);
    }
    
    /**
     * Test that hero section has full-screen dimensions
     * 
     * @return void
     */
    public function test_hero_section_has_fullscreen_dimensions()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check hero section has full viewport height
        $response->assertSee('h-screen w-full', false);
        
        // Check video covers entire section
        $response->assertSee('absolute inset-0 w-full h-full object-cover', false);
    }
    
    /**
     * Test that hero section has overlay with content
     * 
     * @return void
     */
    public function test_hero_section_has_overlay_with_content()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check overlay exists with proper opacity
        $response->assertSee('bg-black/20', false);
        
        // Check headline text is present
        $response->assertSee('Designer-Inspired', false);
        $response->assertSee('Perfumes', false);
        
        // Check subheadline is present
        $response->assertSee('Premium quality. Crafted in France. No excessive markups.', false);
    }
    
    /**
     * Test that CTA buttons are present in hero section
     * 
     * @return void
     */
    public function test_hero_section_has_cta_buttons()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check "SHOP holiday sale" button
        $response->assertSee('SHOP holiday sale', false);
        $response->assertSee('href="#products"', false);
        
        // Check "Shop Bestsellers" button
        $response->assertSee('Shop Bestsellers', false);
        $response->assertSee('href="#bestsellers"', false);
        
        // Check buttons have proper styling classes
        $response->assertSee('rounded-full', false);
        $response->assertSee('hover:bg-gray-100', false);
    }
    
    /**
     * Test that hero section has responsive text sizing
     * 
     * @return void
     */
    public function test_hero_section_has_responsive_text_sizing()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check headline has responsive text classes
        $response->assertSee('text-4xl md:text-6xl lg:text-7xl', false);
        
        // Check subheadline has responsive text classes
        $response->assertSee('text-lg md:text-xl', false);
        
        // Check buttons have responsive layout
        $response->assertSee('flex-col sm:flex-row', false);
    }
    
    /**
     * Test that video element has proper z-index layering
     * 
     * @return void
     */
    public function test_hero_section_has_proper_layering()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check video is at z-0
        $response->assertSee('z-0', false);
        
        // Check overlay is at z-10
        $response->assertSee('z-10', false);
        
        // Verify proper stacking order exists
        $response->assertSee('relative h-screen w-full overflow-hidden', false);
    }
}
