<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Comprehensive responsive behavior tests across all breakpoints
 * Requirements: 8.1, 8.2, 8.3, 8.4
 */
class ResponsiveBehaviorTest extends TestCase
{
    /**
     * Test mobile breakpoint (< 640px) responsive classes
     * 
     * Validates: Requirements 8.1, 8.2
     * 
     * @return void
     */
    public function test_mobile_breakpoint_responsive_classes()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Hero section - mobile text sizing
        $response->assertSee('text-4xl md:text-6xl lg:text-7xl', false);
        
        // Hero section - mobile button layout (stacked)
        $response->assertSee('flex-col sm:flex-row', false);
        
        // Trust badges - 1 column on mobile
        $response->assertSee('grid-cols-1 md:grid-cols-2 lg:grid-cols-4', false);
        
        // Product grid - 1 column on mobile
        $response->assertSee('grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4', false);
        
        // Navigation - mobile menu button visible
        $response->assertSee('md:hidden', false);
        
        // Footer - 1 column on mobile
        $response->assertSee('grid-cols-1 md:grid-cols-4', false);
        
        // Promotional banner - mobile text sizing
        $response->assertSee('text-3xl md:text-5xl', false);
        
        // Brand story - mobile text sizing
        $response->assertSee('text-3xl md:text-4xl', false);
    }
    
    /**
     * Test tablet breakpoint (640px - 1024px) responsive classes
     * 
     * Validates: Requirements 8.1, 8.2
     * 
     * @return void
     */
    public function test_tablet_breakpoint_responsive_classes()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Hero section - tablet text sizing (md breakpoint)
        $response->assertSee('md:text-6xl', false);
        
        // Hero section - tablet button layout (horizontal)
        $response->assertSee('sm:flex-row', false);
        
        // Trust badges - 2 columns on tablet (md breakpoint)
        $response->assertSee('md:grid-cols-2', false);
        
        // Product grid - 2 columns on tablet (sm breakpoint)
        $response->assertSee('sm:grid-cols-2', false);
        
        // Navigation - desktop menu visible on tablet
        $response->assertSee('hidden md:flex', false);
        
        // Footer - 4 columns on tablet
        $response->assertSee('md:grid-cols-4', false);
        
        // Promotional banner - tablet text sizing
        $response->assertSee('md:text-5xl', false);
        
        // Brand story - tablet text sizing
        $response->assertSee('md:text-4xl', false);
        
        // Section padding - tablet sizing
        $response->assertSee('py-12 md:py-16', false);
    }
    
    /**
     * Test desktop breakpoint (> 1024px) responsive classes
     * 
     * Validates: Requirements 8.1, 8.2
     * 
     * @return void
     */
    public function test_desktop_breakpoint_responsive_classes()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Hero section - desktop text sizing (lg breakpoint)
        $response->assertSee('lg:text-7xl', false);
        
        // Trust badges - 4 columns on desktop (lg breakpoint)
        $response->assertSee('lg:grid-cols-4', false);
        
        // Product grid - 3 columns on desktop (lg breakpoint)
        $response->assertSee('lg:grid-cols-3', false);
        
        // Product grid - 4 columns on extra large desktop (xl breakpoint)
        $response->assertSee('xl:grid-cols-4', false);
        
        // Container max width for desktop
        $response->assertSee('container mx-auto', false);
        
        // Desktop navigation spacing
        $response->assertSee('space-x-8', false);
    }
    
    /**
     * Test that all interactive elements are touch-friendly
     * 
     * Validates: Requirements 8.3
     * 
     * @return void
     */
    public function test_interactive_elements_are_touch_friendly()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Buttons have adequate padding for touch targets
        $response->assertSee('px-6 sm:px-8 py-3', false);
        $response->assertSee('px-8 py-3', false);
        
        // Category cards are adequately sized
        $response->assertSee('w-48', false);
        
        // Mobile menu button has adequate size
        $response->assertSee('w-6 h-6', false);
        
        // Product cards have adequate spacing
        $response->assertSee('gap-6', false);
        
        // Trust badges have adequate spacing
        $response->assertSee('gap-8', false);
    }
    
    /**
     * Test that visual hierarchy is maintained across screen sizes
     * 
     * Validates: Requirements 8.4
     * 
     * @return void
     */
    public function test_visual_hierarchy_maintained_across_sizes()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Headings maintain hierarchy with responsive sizing
        $response->assertSee('text-4xl md:text-6xl lg:text-7xl font-bold', false);
        $response->assertSee('text-3xl md:text-5xl font-bold', false);
        $response->assertSee('text-3xl md:text-4xl font-bold', false);
        
        // Body text maintains readability
        $response->assertSee('text-lg text-gray-600', false);
        $response->assertSee('text-sm text-gray-600', false);
        
        // Consistent spacing hierarchy
        $response->assertSee('mb-4 md:mb-6', false);
        $response->assertSee('mb-6 md:mb-8', false);
        
        // Container padding maintains consistency
        $response->assertSee('px-4', false);
        $response->assertSee('container mx-auto px-4', false);
    }
    
    /**
     * Test that images and videos scale appropriately
     * 
     * Validates: Requirements 8.5
     * 
     * @return void
     */
    public function test_images_and_videos_scale_appropriately()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Hero video scales to full viewport
        $response->assertSee('h-screen w-full', false);
        $response->assertSee('object-cover', false);
        
        // Product images maintain aspect ratio
        $response->assertSee('aspect-square', false);
        
        // Category images scale properly
        $response->assertSee('w-full', false);
        $response->assertSee('h-48', false);
        $response->assertSee('object-cover', false);
        
        // Images have proper width constraints
        $response->assertSee('w-full', false);
        
        // Max width constraints for content
        $response->assertSee('max-w-3xl mx-auto', false);
        $response->assertSee('max-w-5xl mx-auto', false);
    }
    
    /**
     * Test responsive container padding
     * 
     * Validates: Requirements 8.2
     * 
     * @return void
     */
    public function test_responsive_container_padding()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Standard container padding
        $response->assertSee('container mx-auto px-4', false);
        
        // Hero section responsive padding
        $response->assertSee('px-4 sm:px-6 md:px-8', false);
        
        // Section vertical padding
        $response->assertSee('py-8', false);
        $response->assertSee('py-12 md:py-16', false);
        $response->assertSee('py-16', false);
        $response->assertSee('py-20', false);
    }
    
    /**
     * Test that no horizontal scrolling occurs on any breakpoint
     * 
     * Validates: Requirements 8.2, 8.4
     * 
     * @return void
     */
    public function test_no_horizontal_scrolling_classes()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Overflow hidden on hero section
        $response->assertSee('overflow-hidden', false);
        
        // Full width constraints
        $response->assertSee('w-full', false);
        
        // Container constrains content width
        $response->assertSee('container mx-auto', false);
        
        // Category navigation has intentional horizontal scroll
        $response->assertSee('overflow-x-auto scrollbar-hide', false);
    }
    
    /**
     * Test responsive gap and spacing utilities
     * 
     * Validates: Requirements 8.2
     * 
     * @return void
     */
    public function test_responsive_gap_and_spacing()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Product grid gap
        $response->assertSee('gap-6', false);
        
        // Trust badges gap
        $response->assertSee('gap-8', false);
        
        // Category navigation gap
        $response->assertSee('gap-4', false);
        
        // Button group gap
        $response->assertSee('gap-3 sm:gap-4', false);
        
        // Navigation spacing
        $response->assertSee('space-x-8', false);
    }
}

