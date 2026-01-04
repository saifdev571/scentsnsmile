<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Tests for category navigation component
 * Requirements: 3.1, 3.2, 3.3, 3.4
 */
class CategoryNavigationTest extends TestCase
{
    /**
     * Property 8: Category Filter Display
     * 
     * For any category selection, all three categories (Women, Men, Unisex) 
     * plus "View all" should be visible and accessible.
     * 
     * Validates: Requirements 3.1, 3.3
     * 
     * @return void
     */
    public function test_all_categories_are_visible_and_accessible()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that all three main categories are present
        $response->assertSee('Women', false);
        $response->assertSee('Men', false);
        $response->assertSee('Unisex', false);
        
        // Check that "View all" option is present
        $response->assertSee('View all', false);
        
        // Verify category section exists with proper structure
        $response->assertSee('py-8 bg-gray-50', false);
        
        // Check that categories are in a horizontal scrollable layout
        $response->assertSee('flex gap-4 overflow-x-auto', false);
        
        // Verify each category has the proper card structure
        $response->assertSee('flex-shrink-0 w-48 rounded-lg', false);
    }
    
    /**
     * Test that each category has a representative image/icon
     * 
     * @return void
     */
    public function test_categories_have_representative_images()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check Women category has gradient background
        $response->assertSee('bg-gradient-to-br from-pink-200 to-purple-200', false);
        
        // Check Men category has gradient background
        $response->assertSee('bg-gradient-to-br from-blue-200 to-indigo-200', false);
        
        // Check Unisex category has gradient background
        $response->assertSee('bg-gradient-to-br from-green-200 to-teal-200', false);
        
        // Check View all has gradient background
        $response->assertSee('bg-gradient-to-br from-gray-200 to-gray-300', false);
        
        // Verify SVG icons are present for each category
        $response->assertSee('w-20 h-20 text-white', false);
    }
    
    /**
     * Test that categories have hover effects
     * 
     * @return void
     */
    public function test_categories_have_hover_effects()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check hover shadow effect is present
        $response->assertSee('hover:shadow-lg', false);
        
        // Check transition classes are present
        $response->assertSee('transition-all duration-300', false);
        
        // Check cursor pointer is set
        $response->assertSee('cursor-pointer', false);
    }
    
    /**
     * Test that categories have active state functionality
     * 
     * @return void
     */
    public function test_categories_have_active_state_functionality()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check Alpine.js data attribute for active category tracking
        $response->assertSee('x-data="{ activeCategory: \'all\' }"', false);
        
        // Check click handlers are present
        $response->assertSee('@click="activeCategory = \'women\'"', false);
        $response->assertSee('@click="activeCategory = \'men\'"', false);
        $response->assertSee('@click="activeCategory = \'unisex\'"', false);
        $response->assertSee('@click="activeCategory = \'all\'"', false);
        
        // Check conditional styling for active states
        $response->assertSee(':class="activeCategory === \'women\' ? \'ring-2 ring-pink-400 shadow-xl\' : \'\'"', false);
        $response->assertSee(':class="activeCategory === \'men\' ? \'ring-2 ring-blue-400 shadow-xl\' : \'\'"', false);
        $response->assertSee(':class="activeCategory === \'unisex\' ? \'ring-2 ring-green-400 shadow-xl\' : \'\'"', false);
        $response->assertSee(':class="activeCategory === \'all\' ? \'ring-2 ring-gray-400 shadow-xl\' : \'\'"', false);
    }
    
    /**
     * Test that categories are arranged with equal spacing
     * 
     * @return void
     */
    public function test_categories_have_equal_spacing()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check gap spacing between categories
        $response->assertSee('flex gap-4', false);
        
        // Check each category has consistent width
        $response->assertSee('w-48', false);
        
        // Check categories don't shrink
        $response->assertSee('flex-shrink-0', false);
    }
    
    /**
     * Test that category section is responsive
     * 
     * @return void
     */
    public function test_category_section_is_responsive()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check container has responsive padding
        $response->assertSee('container mx-auto px-4', false);
        
        // Check horizontal scrolling is enabled for overflow
        $response->assertSee('overflow-x-auto', false);
        
        // Check scrollbar is hidden for cleaner appearance
        $response->assertSee('scrollbar-hide', false);
    }
    
    /**
     * Test that category cards have proper dimensions
     * 
     * @return void
     */
    public function test_category_cards_have_proper_dimensions()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check card width
        $response->assertSee('w-48', false);
        
        // Check image area height
        $response->assertSee('h-48', false);
        
        // Check rounded corners
        $response->assertSee('rounded-lg', false);
        
        // Check overflow is hidden for rounded corners
        $response->assertSee('overflow-hidden', false);
    }
}
