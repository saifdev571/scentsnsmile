<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Tests for promotional banner component
 * Requirements: 6.1, 6.2, 6.3, 6.4
 */
class PromotionalBannerTest extends TestCase
{
    /**
     * Test that promotional banner renders with correct content
     * 
     * Validates: Requirements 6.1, 6.2
     * 
     * @return void
     */
    public function test_banner_renders_with_correct_content()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that promotional banner section exists with gradient background
        $response->assertSee('bg-gradient-to-r from-pink-50 to-purple-50', false);
        
        // Check that "NEW" badge is present
        $response->assertSee('NEW', false);
        $response->assertSee('inline-block px-3 py-1 bg-black text-white text-xs font-bold rounded-full', false);
        
        // Check that headline is present
        $response->assertSee('Smell our NEW It Factor perfume.', false);
        
        // Check that headline has proper styling
        $response->assertSee('text-3xl md:text-5xl font-bold', false);
    }
    
    /**
     * Test that CTA button functionality is present
     * 
     * Validates: Requirements 6.1, 6.2
     * 
     * @return void
     */
    public function test_cta_button_functionality()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that CTA button text is present
        $response->assertSee('Shop it factor', false);
        
        // Check that button has proper styling classes
        $response->assertSee('inline-block px-8 py-3 bg-black text-white font-semibold rounded-full', false);
        
        // Check that button has hover effect
        $response->assertSee('hover:bg-gray-800 transition-colors', false);
    }
    
    /**
     * Test that promotional banner has gradient background
     * 
     * Validates: Requirements 6.4
     * 
     * @return void
     */
    public function test_banner_has_gradient_background()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check gradient background classes
        $response->assertSee('bg-gradient-to-r from-pink-50 to-purple-50', false);
        
        // Check section has proper padding
        $response->assertSee('py-20', false);
    }
    
    /**
     * Test that promotional banner has responsive text sizing
     * 
     * Validates: Requirements 6.3
     * 
     * @return void
     */
    public function test_banner_has_responsive_text_sizing()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check headline has responsive text classes
        $response->assertSee('text-3xl md:text-5xl', false);
        
        // Check that content is centered
        $response->assertSee('text-center', false);
        
        // Check container has proper responsive padding
        $response->assertSee('container mx-auto px-4', false);
    }
    
    /**
     * Test that NEW badge has proper styling
     * 
     * Validates: Requirements 6.2
     * 
     * @return void
     */
    public function test_new_badge_has_proper_styling()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check badge background and text colors
        $response->assertSee('bg-black text-white', false);
        
        // Check badge is rounded
        $response->assertSee('rounded-full', false);
        
        // Check badge has proper spacing
        $response->assertSee('mb-4', false);
    }
    
    /**
     * Test that promotional banner is visually distinct
     * 
     * Validates: Requirements 6.4
     * 
     * @return void
     */
    public function test_banner_is_visually_distinct()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that banner uses relative positioning
        $response->assertSee('relative py-20', false);
        
        // Check that gradient makes it distinct from white sections
        $response->assertSee('from-pink-50 to-purple-50', false);
        
        // Check that content is properly centered
        $response->assertSee('container mx-auto px-4 text-center', false);
    }
}
