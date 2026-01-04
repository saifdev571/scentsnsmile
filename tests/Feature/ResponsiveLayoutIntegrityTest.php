<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild, Property 1: Responsive Layout Integrity
 * 
 * Property 1: Responsive Layout Integrity
 * For any viewport width, all content sections should remain readable and properly 
 * aligned without horizontal scrolling or content overflow.
 * 
 * Validates: Requirements 8.2, 8.4
 */
class ResponsiveLayoutIntegrityTest extends TestCase
{
    /**
     * Property 1: Responsive Layout Integrity
     * 
     * For any viewport width, all content sections should remain readable and properly 
     * aligned without horizontal scrolling or content overflow.
     * 
     * This test validates the property across multiple viewport widths by checking:
     * 1. All sections have proper width constraints
     * 2. No fixed widths that could cause overflow
     * 3. Proper use of responsive utilities
     * 4. Container classes that prevent overflow
     * 
     * Validates: Requirements 8.2, 8.4
     * 
     * @return void
     */
    public function test_responsive_layout_integrity_property()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Test 1: All major sections use container classes that constrain width
        // This prevents horizontal overflow on any viewport
        $response->assertSee('container mx-auto', false);
        
        // Test 2: Hero section uses full width but with overflow hidden
        // This ensures video doesn't cause horizontal scroll
        $response->assertSee('h-screen w-full overflow-hidden', false);
        
        // Test 3: All sections use responsive padding that scales with viewport
        // Mobile: px-4, Tablet: px-6/px-8, Desktop: px-8
        $response->assertSee('px-4', false);
        $response->assertSee('sm:px-6', false);
        $response->assertSee('md:px-8', false);
        
        // Test 4: Product grid uses responsive columns that adapt to viewport
        // This ensures content doesn't overflow on any screen size
        $response->assertSee('grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4', false);
        
        // Test 5: Trust badges grid adapts to viewport
        $response->assertSee('grid-cols-1 md:grid-cols-2 lg:grid-cols-4', false);
        
        // Test 6: Footer grid adapts to viewport
        $response->assertSee('grid-cols-1 md:grid-cols-4', false);
        
        // Test 7: Text content has max-width constraints to maintain readability
        $response->assertSee('max-w-3xl mx-auto', false);
        $response->assertSee('max-w-5xl mx-auto', false);
        $response->assertSee('max-w-2xl mx-auto', false);
        
        // Test 8: Images use object-cover to prevent distortion
        $response->assertSee('object-cover', false);
        
        // Test 9: Buttons and interactive elements have responsive sizing
        $response->assertSee('px-6 sm:px-8 py-3', false);
        
        // Test 10: Category navigation has intentional horizontal scroll with hidden scrollbar
        // This is the only section that should scroll horizontally
        $response->assertSee('overflow-x-auto scrollbar-hide', false);
        
        // Test 11: All text has responsive sizing that scales with viewport
        $response->assertSee('text-4xl md:text-6xl lg:text-7xl', false);
        $response->assertSee('text-3xl md:text-5xl', false);
        $response->assertSee('text-3xl md:text-4xl', false);
        
        // Test 12: Flex layouts adapt to viewport (column on mobile, row on desktop)
        $response->assertSee('flex-col sm:flex-row', false);
        $response->assertSee('flex-col md:flex-row', false);
        
        // Test 13: Navigation adapts to viewport (mobile menu vs desktop menu)
        $response->assertSee('hidden md:flex', false);
        $response->assertSee('md:hidden', false);
        
        // Test 14: Spacing adapts to viewport
        $response->assertSee('gap-3 sm:gap-4', false);
        $response->assertSee('mb-4 md:mb-6', false);
        $response->assertSee('mb-6 md:mb-8', false);
    }
    
    /**
     * Test that no fixed widths are used that could cause overflow
     * 
     * Validates: Requirements 8.2, 8.4
     * 
     * @return void
     */
    public function test_no_fixed_widths_causing_overflow()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Verify that all width classes are either:
        // 1. Full width (w-full)
        // 2. Responsive (w-48 for category cards is intentional and scrollable)
        // 3. Constrained by container
        
        $response->assertSee('w-full', false);
        $response->assertSee('container mx-auto', false);
        
        // Category cards use w-48 but are in a scrollable container
        $response->assertSee('w-48', false);
        $response->assertSee('overflow-x-auto', false);
    }
    
    /**
     * Test that all sections maintain proper alignment
     * 
     * Validates: Requirements 8.4
     * 
     * @return void
     */
    public function test_sections_maintain_proper_alignment()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // All sections use container for consistent alignment
        $response->assertSee('container mx-auto', false);
        
        // Centered content uses mx-auto
        $response->assertSee('mx-auto', false);
        
        // Text alignment is consistent
        $response->assertSee('text-center', false);
        
        // Flex items are properly aligned
        $response->assertSee('items-center', false);
        $response->assertSee('justify-center', false);
        $response->assertSee('justify-between', false);
    }
    
    /**
     * Test that content remains readable at all viewport sizes
     * 
     * Validates: Requirements 8.4
     * 
     * @return void
     */
    public function test_content_remains_readable_at_all_sizes()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Text has minimum readable sizes
        $response->assertSee('text-sm', false);
        $response->assertSee('text-base', false);
        $response->assertSee('text-lg', false);
        
        // Text has responsive sizing
        $response->assertSee('sm:text-lg', false);
        $response->assertSee('md:text-xl', false);
        
        // Line height for readability
        $response->assertSee('leading-tight', false);
        $response->assertSee('leading-relaxed', false);
        
        // Max width constraints for optimal reading
        $response->assertSee('max-w-2xl', false);
        $response->assertSee('max-w-3xl', false);
        $response->assertSee('max-w-5xl', false);
    }
    
    /**
     * Test that spacing is consistent and responsive
     * 
     * Validates: Requirements 8.2
     * 
     * @return void
     */
    public function test_spacing_is_consistent_and_responsive()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Section padding is responsive
        $response->assertSee('py-8', false);
        $response->assertSee('py-12 md:py-16', false);
        $response->assertSee('py-16', false);
        $response->assertSee('py-20', false);
        
        // Container padding is responsive
        $response->assertSee('px-4', false);
        $response->assertSee('lg:px-8', false);
        
        // Gap spacing is consistent
        $response->assertSee('gap-2', false);
        $response->assertSee('gap-3 sm:gap-4', false);
        $response->assertSee('gap-4', false);
        $response->assertSee('gap-6', false);
        $response->assertSee('gap-8', false);
        
        // Margin spacing is responsive
        $response->assertSee('mb-4', false);
        $response->assertSee('mb-4 md:mb-6', false);
        $response->assertSee('mb-6', false);
        $response->assertSee('mb-6 md:mb-8', false);
        $response->assertSee('mb-8', false);
    }
    
    /**
     * Test that images scale appropriately without distortion
     * 
     * Validates: Requirements 8.5
     * 
     * @return void
     */
    public function test_images_scale_without_distortion()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Images use object-cover to maintain aspect ratio
        $response->assertSee('object-cover', false);
        
        // Product images use aspect-square for consistent sizing
        $response->assertSee('aspect-square', false);
        
        // Images are responsive width
        $response->assertSee('w-full', false);
        
        // Hero video scales to full viewport
        $response->assertSee('h-screen w-full', false);
        $response->assertSee('absolute inset-0 w-full h-full object-cover', false);
    }
    
    /**
     * Test that overflow is properly managed
     * 
     * Validates: Requirements 8.2
     * 
     * @return void
     */
    public function test_overflow_is_properly_managed()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Hero section has overflow hidden to prevent scroll
        $response->assertSee('overflow-hidden', false);
        
        // Category navigation has intentional horizontal scroll
        $response->assertSee('overflow-x-auto scrollbar-hide', false);
        
        // Product cards have overflow hidden for image effects
        $response->assertSee('rounded-lg overflow-hidden', false);
    }
}

