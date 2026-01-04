<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Tests for trust badges section
 * Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 8.2
 */
class TrustBadgesTest extends TestCase
{
    /**
     * Property 3: Product Grid Responsiveness (applies to trust badges grid too)
     * 
     * For any screen size, the product grid should display the appropriate number 
     * of columns (1 on mobile, 2 on tablet, 4 on desktop) with consistent spacing.
     * 
     * Validates: Requirements 2.5, 8.2
     * 
     * @return void
     */
    public function test_trust_badges_grid_has_responsive_layout()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that trust badges section exists
        $response->assertSee('py-12 md:py-16 bg-white', false);
        
        // Check responsive grid classes are present
        // 1 column on mobile, 2 on tablet (md), 4 on desktop (lg)
        $response->assertSee('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8', false);
        
        // Verify the grid maintains consistent spacing across breakpoints
        $response->assertSee('gap-8', false);
    }
    
    /**
     * Test that all four trust badges are present
     * 
     * @return void
     */
    public function test_all_four_trust_badges_are_displayed()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check Free Returns badge
        $response->assertSee('Free Returns', false);
        $response->assertSee('no questions asked.', false);
        
        // Check Bottles Sold badge
        $response->assertSee('6,000,000+ Bottles', false);
        $response->assertSee('over 6M bottles sold worldwide.', false);
        
        // Check Reviews badge
        $response->assertSee('100,000+ Reviews', false);
        $response->assertSee('over 100,000 5-star reviews.', false);
        
        // Check Viral Brand badge
        $response->assertSee('Viral fragrance brand', false);
        $response->assertSee('1B+ views & dazzling social reviews.', false);
    }
    
    /**
     * Test that each badge has an icon
     * 
     * @return void
     */
    public function test_each_badge_has_icon()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that icon wrapper exists for each badge
        // Each badge should have a w-12 h-12 icon container
        $content = $response->getContent();
        
        // Count occurrences of icon wrapper class in trust badges section
        $iconWrapperCount = substr_count($content, 'w-12 h-12 mb-4 flex items-center justify-center');
        
        // Should have at least 4 icons (one for each badge)
        $this->assertGreaterThanOrEqual(4, $iconWrapperCount);
        
        // Check that SVG elements exist
        $svgCount = substr_count($content, '<svg class="w-12 h-12 text-gray-900"');
        $this->assertGreaterThanOrEqual(4, $svgCount);
    }
    
    /**
     * Test that badges have proper structure and styling
     * 
     * @return void
     */
    public function test_badges_have_proper_structure()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check badge container structure
        $response->assertSee('flex flex-col items-center text-center', false);
        
        // Check headline styling
        $response->assertSee('text-lg font-bold mb-1', false);
        
        // Check description styling
        $response->assertSee('text-sm text-gray-600', false);
    }
    
    /**
     * Test that trust badges section has proper spacing
     * 
     * @return void
     */
    public function test_trust_badges_section_has_proper_spacing()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check section padding (responsive)
        $response->assertSee('py-12 md:py-16', false);
        
        // Check container has proper horizontal padding
        $response->assertSee('container mx-auto px-4', false);
    }
    
    /**
     * Test that badges are centered and aligned properly
     * 
     * @return void
     */
    public function test_badges_are_centered_and_aligned()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that each badge uses flexbox centering
        $response->assertSee('flex flex-col items-center text-center', false);
        
        // Check that container uses auto margins for centering
        $response->assertSee('container mx-auto', false);
    }
}
