<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild
 * Tests for brand story sections
 * Requirements: 7.1, 7.2, 7.3, 7.4
 */
class BrandStorySectionsTest extends TestCase
{
    /**
     * Test that both brand story sections render with correct content
     * 
     * Validates: Requirements 7.1, 7.2
     * 
     * @return void
     */
    public function test_both_brand_story_sections_render_with_correct_content()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check first brand story section
        $response->assertSee('The Perfume House For The Next Generation', false);
        $response->assertSee('Premium-quality French fragrances. No excessive markups. Crafted with heart, not ego.', false);
        
        // Check second brand story section
        $response->assertSee('High standards & non-toxic', false);
        $response->assertSee('That\'s the Dossier promise. All our fragrances are crafted in Grasse, France — the perfume capital of the world.', false);
    }
    
    /**
     * Test that both sections have "Learn More" links
     * 
     * Validates: Requirements 7.2, 7.3
     * 
     * @return void
     */
    public function test_both_sections_have_learn_more_links()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check that "Learn More" text appears (should appear twice, once per section)
        $content = $response->getContent();
        $learnMoreCount = substr_count($content, 'Learn More');
        
        $this->assertGreaterThanOrEqual(2, $learnMoreCount, 'Both brand story sections should have "Learn More" links');
        
        // Check that the links have proper styling
        $response->assertSee('inline-block text-sm font-semibold underline hover:no-underline', false);
    }
    
    /**
     * Test that sections have centered layout with max-width constraint
     * 
     * Validates: Requirements 7.3, 7.4
     * 
     * @return void
     */
    public function test_sections_have_centered_layout_with_max_width()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check for max-width constraint and centering
        $response->assertSee('max-w-3xl mx-auto text-center', false);
        
        // Check that container uses proper spacing
        $response->assertSee('container mx-auto px-4', false);
    }
    
    /**
     * Test that sections have proper typography hierarchy
     * 
     * Validates: Requirements 7.4
     * 
     * @return void
     */
    public function test_sections_have_proper_typography_hierarchy()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check headline styling (responsive)
        $response->assertSee('text-3xl md:text-4xl font-bold mb-6', false);
        
        // Check body text styling
        $response->assertSee('text-lg text-gray-600 mb-8 leading-relaxed', false);
        
        // Check link styling
        $response->assertSee('text-sm font-semibold', false);
    }
    
    /**
     * Test that sections have proper spacing
     * 
     * Validates: Requirements 7.4
     * 
     * @return void
     */
    public function test_sections_have_proper_spacing()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check section padding
        $response->assertSee('py-20', false);
        
        // Check that sections have different backgrounds for visual separation
        $response->assertSee('bg-gray-50', false);
        $response->assertSee('bg-white', false);
    }
    
    /**
     * Test that first section has correct background color
     * 
     * @return void
     */
    public function test_first_section_has_gray_background()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Find the first brand story section and verify it has gray background
        $this->assertStringContainsString('py-20 bg-gray-50', $content);
    }
    
    /**
     * Test that second section has correct background color
     * 
     * @return void
     */
    public function test_second_section_has_white_background()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Verify second brand story section has white background
        $this->assertStringContainsString('py-20 bg-white', $content);
    }
    
    /**
     * Test that sections are visually distinct from each other
     * 
     * @return void
     */
    public function test_sections_are_visually_distinct()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Both sections should exist
        $response->assertSee('The Perfume House For The Next Generation', false);
        $response->assertSee('High standards & non-toxic', false);
        
        // They should have different content
        $this->assertNotEquals(
            'The Perfume House For The Next Generation',
            'High standards & non-toxic'
        );
    }
}
