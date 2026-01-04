<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Tests for navigation header component
 * Requirements: 12.1, 8.1
 */
class NavigationHeaderTest extends TestCase
{
    /**
     * Test that navigation header renders correctly with all required elements
     * 
     * @return void
     */
    public function test_navigation_renders_correctly()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that header exists with correct classes
        $response->assertSee('DOSSIER', false);
        
        // Check desktop navigation links
        $response->assertSee('Shop', false);
        $response->assertSee('Women', false);
        $response->assertSee('Men', false);
        $response->assertSee('Unisex', false);
        $response->assertSee('About', false);
        
        // Check that header has sticky positioning classes
        $response->assertSee('fixed top-0 w-full z-50', false);
        
        // Check cart icon exists
        $response->assertSee('M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', false);
    }
    
    /**
     * Test that mobile menu toggle functionality is present
     * 
     * @return void
     */
    public function test_mobile_menu_toggle_functionality()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check Alpine.js data attribute for mobile menu state
        $response->assertSee('x-data="{ mobileMenuOpen: false }"', false);
        
        // Check mobile menu button exists
        $response->assertSee('@click="mobileMenuOpen = !mobileMenuOpen"', false);
        
        // Check mobile menu container exists with x-show directive
        $response->assertSee('x-show="mobileMenuOpen"', false);
        
        // Check mobile menu has transition classes
        $response->assertSee('x-transition', false);
    }
    
    /**
     * Test that navigation has responsive breakpoints
     * 
     * @return void
     */
    public function test_navigation_has_responsive_breakpoints()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check desktop navigation is hidden on mobile
        $response->assertSee('hidden md:flex', false);
        
        // Check mobile menu button is hidden on desktop
        $response->assertSee('md:hidden', false);
        
        // Check mobile menu container is hidden on desktop
        $response->assertSee('md:hidden bg-white border-t', false);
    }
    
    /**
     * Test that all navigation icons are present
     * 
     * @return void
     */
    public function test_navigation_icons_are_present()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check search icon SVG path
        $response->assertSee('M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', false);
        
        // Check account icon SVG path
        $response->assertSee('M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', false);
        
        // Check cart icon SVG path
        $response->assertSee('M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', false);
        
        // Check hamburger menu icon paths
        $response->assertSee('M4 6h16M4 12h16M4 18h16', false);
        $response->assertSee('M6 18L18 6M6 6l12 12', false);
    }
    
    /**
     * Test that cart badge displays correctly
     * 
     * @return void
     */
    public function test_cart_badge_displays()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check cart badge with count
        $response->assertSee('absolute -top-2 -right-2 bg-black text-white', false);
    }
}
