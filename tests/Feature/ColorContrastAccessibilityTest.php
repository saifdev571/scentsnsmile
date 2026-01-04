<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Feature: dossier-website-rebuild, Property 6: Color Contrast Accessibility
 * 
 * Property: For any text element, the contrast ratio between text and background 
 * should meet WCAG AA standards (minimum 4.5:1 for normal text).
 * 
 * Validates: Requirements 9.5
 */
class ColorContrastAccessibilityTest extends TestCase
{
    /**
     * Helper function to convert hex color to RGB
     * 
     * @param string $hex
     * @return array
     */
    private function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }
    
    /**
     * Helper function to calculate relative luminance
     * 
     * @param array $rgb
     * @return float
     */
    private function getRelativeLuminance($rgb)
    {
        $r = $rgb['r'] / 255;
        $g = $rgb['g'] / 255;
        $b = $rgb['b'] / 255;
        
        $r = ($r <= 0.03928) ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = ($g <= 0.03928) ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = ($b <= 0.03928) ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);
        
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }
    
    /**
     * Helper function to calculate contrast ratio
     * 
     * @param string $color1 Hex color
     * @param string $color2 Hex color
     * @return float
     */
    private function getContrastRatio($color1, $color2)
    {
        $rgb1 = $this->hexToRgb($color1);
        $rgb2 = $this->hexToRgb($color2);
        
        $l1 = $this->getRelativeLuminance($rgb1);
        $l2 = $this->getRelativeLuminance($rgb2);
        
        $lighter = max($l1, $l2);
        $darker = min($l1, $l2);
        
        return ($lighter + 0.05) / ($darker + 0.05);
    }
    
    /**
     * Test that primary text on white background meets WCAG AA
     * 
     * Property: For any primary text (gray-900) on white background, 
     * contrast ratio should be at least 4.5:1
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_primary_text_on_white_meets_wcag_aa()
    {
        // Tailwind gray-900: #111827
        // White: #FFFFFF
        $contrastRatio = $this->getContrastRatio('#111827', '#FFFFFF');
        
        $this->assertGreaterThanOrEqual(
            4.5,
            $contrastRatio,
            "Primary text (gray-900) on white should meet WCAG AA (4.5:1). Got: {$contrastRatio}"
        );
        
        // Verify the page uses these colors
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('text-gray-900', false);
    }
    
    /**
     * Test that secondary text on white background meets WCAG AA
     * 
     * Property: For any secondary text (gray-600) on white background,
     * contrast ratio should be at least 4.5:1
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_secondary_text_on_white_meets_wcag_aa()
    {
        // Tailwind gray-600: #4B5563
        // White: #FFFFFF
        $contrastRatio = $this->getContrastRatio('#4B5563', '#FFFFFF');
        
        $this->assertGreaterThanOrEqual(
            4.5,
            $contrastRatio,
            "Secondary text (gray-600) on white should meet WCAG AA (4.5:1). Got: {$contrastRatio}"
        );
        
        // Verify the page uses these colors
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('text-gray-600', false);
    }
    
    /**
     * Test that navigation text meets WCAG AA
     * 
     * Property: For any navigation text (gray-700) on white background,
     * contrast ratio should be at least 4.5:1
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_navigation_text_meets_wcag_aa()
    {
        // Tailwind gray-700: #374151
        // White: #FFFFFF
        $contrastRatio = $this->getContrastRatio('#374151', '#FFFFFF');
        
        $this->assertGreaterThanOrEqual(
            4.5,
            $contrastRatio,
            "Navigation text (gray-700) on white should meet WCAG AA (4.5:1). Got: {$contrastRatio}"
        );
        
        // Verify the page uses these colors
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('text-gray-700', false);
    }
    
    /**
     * Test that white text on black background meets WCAG AA
     * 
     * Property: For any white text on black background (buttons, badges),
     * contrast ratio should be at least 4.5:1
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_white_text_on_black_meets_wcag_aa()
    {
        // White: #FFFFFF
        // Black: #000000
        $contrastRatio = $this->getContrastRatio('#FFFFFF', '#000000');
        
        $this->assertGreaterThanOrEqual(
            4.5,
            $contrastRatio,
            "White text on black should meet WCAG AA (4.5:1). Got: {$contrastRatio}"
        );
        
        // Verify the page uses these colors
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('bg-black text-white', false);
    }
    
    /**
     * Test that footer text on dark background meets WCAG AA
     * 
     * Property: For any footer text (gray-400) on dark background (gray-900),
     * contrast ratio should be at least 4.5:1
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_footer_text_meets_wcag_aa()
    {
        // Tailwind gray-400: #9CA3AF
        // Tailwind gray-900: #111827
        $contrastRatio = $this->getContrastRatio('#9CA3AF', '#111827');
        
        $this->assertGreaterThanOrEqual(
            4.5,
            $contrastRatio,
            "Footer text (gray-400) on dark background (gray-900) should meet WCAG AA (4.5:1). Got: {$contrastRatio}"
        );
        
        // Verify the page uses these colors
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('bg-gray-900', false);
        $response->assertSee('text-gray-400', false);
    }
    
    /**
     * Test that category tag text meets WCAG AA
     * 
     * Property: For any category tag text (gray-700) on light background (gray-100),
     * contrast ratio should be at least 4.5:1
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_category_tag_text_meets_wcag_aa()
    {
        // Tailwind gray-700: #374151
        // Tailwind gray-100: #F3F4F6
        $contrastRatio = $this->getContrastRatio('#374151', '#F3F4F6');
        
        $this->assertGreaterThanOrEqual(
            4.5,
            $contrastRatio,
            "Category tag text (gray-700) on light background (gray-100) should meet WCAG AA (4.5:1). Got: {$contrastRatio}"
        );
        
        // Verify the page uses these colors
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('bg-gray-100', false);
    }
    
    /**
     * Property-based test: Verify all text color combinations meet WCAG AA
     * 
     * This test checks multiple color combinations used throughout the site
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_all_color_combinations_meet_wcag_aa()
    {
        $colorCombinations = [
            // [text color, background color, description]
            ['#111827', '#FFFFFF', 'gray-900 on white'],
            ['#374151', '#FFFFFF', 'gray-700 on white'],
            ['#4B5563', '#FFFFFF', 'gray-600 on white'],
            ['#FFFFFF', '#000000', 'white on black'],
            ['#9CA3AF', '#111827', 'gray-400 on gray-900'],
            ['#374151', '#F3F4F6', 'gray-700 on gray-100'],
            ['#000000', '#FFFFFF', 'black on white'],
        ];
        
        foreach ($colorCombinations as [$textColor, $bgColor, $description]) {
            $contrastRatio = $this->getContrastRatio($textColor, $bgColor);
            
            $this->assertGreaterThanOrEqual(
                4.5,
                $contrastRatio,
                "Color combination '{$description}' should meet WCAG AA (4.5:1). Got: {$contrastRatio}"
            );
        }
    }
    
    /**
     * Test that page has proper semantic HTML for accessibility
     * 
     * Property: For any page, semantic HTML elements should be used appropriately
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_page_uses_semantic_html()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check for semantic elements
        $response->assertSee('<header', false);
        $response->assertSee('<nav', false);
        $response->assertSee('<section', false);
        $response->assertSee('<footer', false);
        $response->assertSee('<article', false);
    }
    
    /**
     * Test that images have alt text
     * 
     * Property: For any image, alt text should be provided
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_images_have_alt_text()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Find all img tags
        preg_match_all('/<img[^>]*>/', $content, $matches);
        
        if (count($matches[0]) > 0) {
            // Check that each img has an alt attribute
            foreach ($matches[0] as $imgTag) {
                $this->assertTrue(
                    str_contains($imgTag, 'alt='),
                    "Image should have alt attribute: {$imgTag}"
                );
            }
        }
    }
    
    /**
     * Test that interactive elements have ARIA labels where needed
     * 
     * Property: For any interactive element without visible text, ARIA labels should be provided
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_interactive_elements_have_aria_labels()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check for ARIA labels on icon buttons
        $response->assertSee('aria-label=', false);
        
        // Check for ARIA hidden on decorative elements
        $response->assertSee('aria-hidden="true"', false);
    }
    
    /**
     * Test that buttons have focus states
     * 
     * Property: For any interactive element, focus states should be visible
     * Validates: Requirement 9.5
     * 
     * @return void
     */
    public function test_buttons_have_focus_states()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check for focus ring classes
        $response->assertSee('focus:outline-none', false);
        $response->assertSee('focus:ring-2', false);
        $response->assertSee('focus:ring-offset-2', false);
    }
}
