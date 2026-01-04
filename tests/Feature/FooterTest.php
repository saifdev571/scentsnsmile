<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Tests for footer component
 * Requirements: 12.5
 */
class FooterTest extends TestCase
{
    /**
     * Test that footer renders correctly with all required elements
     * 
     * @return void
     */
    public function test_footer_renders_correctly()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that footer exists with correct styling
        $response->assertSee('bg-gray-900 text-white', false);
        
        // Check company branding
        $response->assertSee('DOSSIER', false);
        $response->assertSee('Designer-inspired perfumes', false);
        
        // Check footer has proper structure
        $response->assertSee('grid grid-cols-1 md:grid-cols-4', false);
    }
    
    /**
     * Test that all required footer links are present
     * 
     * @return void
     */
    public function test_all_footer_links_are_present()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check About section links
        $response->assertSee('About', false);
        $response->assertSee('Our Story', false);
        $response->assertSee('Contact', false);
        
        // Check Support section links (Terms and Privacy)
        $response->assertSee('Support', false);
        $response->assertSee('Terms of Service', false);
        $response->assertSee('Privacy Policy', false);
        
        // Check Shop section links
        $response->assertSee('Shop', false);
        $response->assertSee('Women', false);
        $response->assertSee('Men', false);
        $response->assertSee('Unisex', false);
        $response->assertSee('Bestsellers', false);
    }
    
    /**
     * Test that social media icons are present
     * 
     * @return void
     */
    public function test_social_media_icons_are_present()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check for social media links container
        $response->assertSee('Social media links', false);
        
        // Check Facebook icon SVG path
        $response->assertSee('M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669', false);
        
        // Check Instagram icon SVG path
        $response->assertSee('M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919', false);
        
        // Check Twitter icon SVG path
        $response->assertSee('M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184', false);
        
        // Check TikTok icon SVG path
        $response->assertSee('M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74', false);
        
        // Check aria labels for accessibility
        $response->assertSee('Follow us on Facebook', false);
        $response->assertSee('Follow us on Instagram', false);
        $response->assertSee('Follow us on Twitter', false);
        $response->assertSee('Follow us on TikTok', false);
    }
    
    /**
     * Test that copyright information is present
     * 
     * @return void
     */
    public function test_copyright_information_is_present()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check copyright text with current year (checking for HTML entity)
        $currentYear = date('Y');
        $response->assertSee("&copy; {$currentYear} Dossier. All rights reserved.", false);
    }
    
    /**
     * Test that footer has proper responsive layout
     * 
     * @return void
     */
    public function test_footer_has_responsive_layout()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check responsive grid classes
        $response->assertSee('grid grid-cols-1 md:grid-cols-4 gap-8', false);
        
        // Check responsive flex classes for copyright section
        $response->assertSee('flex flex-col md:flex-row justify-between items-center', false);
    }
    
    /**
     * Test that footer links have proper hover states
     * 
     * @return void
     */
    public function test_footer_links_have_hover_states()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check hover transition classes on links
        $response->assertSee('text-gray-400 hover:text-white transition-colors', false);
    }
    
    /**
     * Test that footer has accessibility features
     * 
     * @return void
     */
    public function test_footer_has_accessibility_features()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check focus ring classes for keyboard navigation
        $response->assertSee('focus:outline-none focus:ring-2 focus:ring-white', false);
        
        // Check aria labels on social links
        $response->assertSee('aria-label="Follow us on', false);
        
        // Check role attributes
        $response->assertSee('role="list"', false);
        $response->assertSee('role="listitem"', false);
    }
}
