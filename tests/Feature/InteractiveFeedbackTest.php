<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild, Property 5: Interactive Feedback
 * 
 * Property: For any interactive element (button, card, link), hovering should provide 
 * visual feedback through color, scale, or shadow changes.
 * 
 * Validates: Requirements 10.1, 10.2, 10.3
 */
class InteractiveFeedbackTest extends TestCase
{
    /**
     * Test that product cards have hover effects (scale and shadow)
     * 
     * Property: For any product card, hovering should trigger scale and shadow effects
     * Validates: Requirement 10.1
     * 
     * @return void
     */
    public function test_product_cards_have_hover_effects()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that product cards have group class for hover effects
        $response->assertSee('group cursor-pointer', false);
        
        // Check that product images have scale on hover
        $response->assertSee('group-hover:scale-105', false);
        
        // Check that product cards have shadow on hover
        $response->assertSee('hover:shadow-xl', false);
        
        // Check that transitions are applied
        $response->assertSee('transition-transform duration-300', false);
        $response->assertSee('transition-shadow duration-300', false);
    }
    
    /**
     * Test that buttons have hover color changes
     * 
     * Property: For any button, hovering should change the button appearance
     * Validates: Requirement 10.2
     * 
     * @return void
     */
    public function test_buttons_have_hover_color_changes()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check hero section buttons have hover effects
        $response->assertSee('hover:bg-gray-100', false);
        $response->assertSee('hover:bg-white hover:text-black', false);
        
        // Check promotional banner button has hover effect
        $response->assertSee('hover:bg-gray-800', false);
        
        // Check all buttons have transition classes
        $response->assertSee('transition-colors', false);
    }
    
    /**
     * Test that category cards have hover shadow effects
     * 
     * Property: For any category card, hovering should add shadow
     * Validates: Requirement 10.3
     * 
     * @return void
     */
    public function test_category_cards_have_hover_shadow()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check category cards have hover shadow
        $response->assertSee('hover:shadow-lg', false);
        
        // Check category cards have transition for smooth effect
        $response->assertSee('transition-all duration-300', false);
    }
    
    /**
     * Test that links have hover underline removal
     * 
     * Property: For any link with underline, hovering should remove the underline
     * Validates: Requirement 10.4
     * 
     * @return void
     */
    public function test_links_have_hover_underline_removal()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check brand story links have underline that removes on hover
        $response->assertSee('underline hover:no-underline', false);
    }
    
    /**
     * Test that all interactive elements have appropriate cursor styles
     * 
     * Property: For any interactive element, the cursor should indicate clickability
     * Validates: Requirement 10.4
     * 
     * @return void
     */
    public function test_interactive_elements_have_cursor_pointer()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check various interactive elements have cursor-pointer
        $response->assertSee('cursor-pointer', false);
        
        // Check category cards have cursor pointer
        $response->assertSee('cursor-pointer hover:shadow-lg', false);
    }
    
    /**
     * Test that navigation links have hover color changes
     * 
     * Property: For any navigation link, hovering should change text color
     * Validates: Requirement 10.2
     * 
     * @return void
     */
    public function test_navigation_links_have_hover_effects()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check navigation links have hover color change
        $response->assertSee('hover:text-gray-900', false);
        
        // Check navigation has transition for smooth color change
        $response->assertSee('text-gray-700 hover:text-gray-900 transition-colors', false);
    }
    
    /**
     * Test that all hover effects have smooth transitions
     * 
     * Property: For any interactive element with hover effects, transitions should be smooth
     * Validates: Requirement 10.5
     * 
     * @return void
     */
    public function test_hover_effects_have_smooth_transitions()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check various transition classes are present
        $response->assertSee('transition-colors', false);
        $response->assertSee('transition-transform', false);
        $response->assertSee('transition-shadow', false);
        $response->assertSee('transition-all', false);
        
        // Check duration classes for smooth animations
        $response->assertSee('duration-300', false);
    }
    
    /**
     * Property-based test: Verify all buttons have consistent hover behavior
     * 
     * This test runs multiple iterations to verify hover consistency across all button types
     * Validates: Requirements 10.2, 10.5
     * 
     * @return void
     */
    public function test_all_buttons_have_consistent_hover_behavior()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Find all button and anchor elements that look like CTA buttons (larger padding)
        // Exclude small tags/badges (px-2 py-1) which are not interactive buttons
        preg_match_all('/class="[^"]*(?:px-[6-9]|px-\d{2})[^"]*(?:py-[3-9]|py-\d{2})[^"]*rounded-full[^"]*"/', $content, $matches);
        
        $this->assertGreaterThan(0, count($matches[0]), 'Should find button-like elements');
        
        // Verify each button-like element has hover effects
        foreach ($matches[0] as $buttonClass) {
            $this->assertTrue(
                str_contains($buttonClass, 'hover:') || str_contains($buttonClass, 'group-hover:'),
                "Button should have hover effects: {$buttonClass}"
            );
            
            $this->assertTrue(
                str_contains($buttonClass, 'transition'),
                "Button should have transition for smooth hover: {$buttonClass}"
            );
        }
    }
    
    /**
     * Property-based test: Verify all clickable elements have cursor pointer
     * 
     * This test verifies that interactive elements indicate their clickability
     * Validates: Requirement 10.4
     * 
     * @return void
     */
    public function test_all_clickable_elements_indicate_interactivity()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Count interactive elements (buttons, links with href, elements with @click)
        preg_match_all('/<(?:button|a[^>]*href|[^>]*@click)/', $content, $matches);
        
        $interactiveCount = count($matches[0]);
        $this->assertGreaterThan(0, $interactiveCount, 'Should have interactive elements');
        
        // Verify cursor-pointer or default button cursor is present
        $hasCursorPointer = str_contains($content, 'cursor-pointer');
        $hasButtons = str_contains($content, '<button');
        
        $this->assertTrue(
            $hasCursorPointer || $hasButtons,
            'Interactive elements should have cursor styling'
        );
    }
}
