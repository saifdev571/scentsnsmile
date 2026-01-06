<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiSeoController extends Controller
{
    public function generateSeoContent(Request $request)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');
            
            if (empty($apiKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gemini API key not configured. Please add GEMINI_API_KEY to your .env file.'
                ], 500);
            }

            // Get product ID from request (for edit mode)
            $productId = $request->input('product_id');
            
            // Initialize product data
            $productData = [];
            
            // If product ID exists (edit mode), get from database
            if ($productId) {
                $product = \App\Models\Product::find($productId);
                if ($product) {
                    $productData = [
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'short_description' => $product->short_description,
                        'price' => $product->price,
                        'inspired_by' => $product->inspired_by,
                    ];
                    Log::info('Product Data from Database (Edit Mode)', ['data' => $productData]);
                }
            } else {
                // Create mode - get from session
                $productData = session('product_data', []);
                Log::info('Product Data from Session (Create Mode)', ['data' => $productData]);
            }
            
            // Extract product details
            $productName = $productData['name'] ?? 'Product';
            $productSlug = $productData['slug'] ?? \Illuminate\Support\Str::slug($productName);
            $description = $productData['description'] ?? '';
            $shortDescription = $productData['short_description'] ?? '';
            $price = $productData['price'] ?? '';
            $category = $productData['category'] ?? '';
            $inspiredBy = $productData['inspired_by'] ?? '';
            
            Log::info('Extracted Product Details', [
                'name' => $productName,
                'slug' => $productSlug,
                'description' => substr($description, 0, 100),
                'price' => $price
            ]);
            
            // Build the prompt for Gemini
            $prompt = $this->buildPrompt($productName, $description, $shortDescription, $price, $category, $inspiredBy);
            
            // Call Gemini API
            $response = Http::timeout(30)
                ->withHeaders([
                    'x-goog-api-key' => $apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'topK' => 40,
                            'topP' => 0.95,
                            'maxOutputTokens' => 1024,
                        ]
                    ]
                );

            if ($response->failed()) {
                $errorBody = $response->body();
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body' => $errorBody
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Gemini API Error: ' . $errorBody
                ], 500);
            }

            $result = $response->json();
            
            Log::info('Gemini API Response', ['result' => $result]);
            
            // Extract the generated text
            $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            if (empty($generatedText)) {
                Log::error('No content generated', ['result' => $result]);
                return response()->json([
                    'success' => false,
                    'message' => 'No content generated. API Response: ' . json_encode($result)
                ], 500);
            }

            // Parse the generated content
            $seoData = $this->parseGeneratedContent($generatedText);
            
            // Generate canonical URL from product slug (not from AI)
            // Use production domain
            $domain = 'https://scentsnsmile.com';
            $seoData['canonical_url'] = $domain . '/product/' . $productSlug;
            
            Log::info('Final SEO Data with Canonical URL', ['data' => $seoData]);
            
            return response()->json([
                'success' => true,
                'data' => $seoData
            ]);

        } catch (\Exception $e) {
            Log::error('AI SEO Generation Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while generating SEO content: ' . $e->getMessage()
            ], 500);
        }
    }

    private function buildPrompt($productName, $description, $shortDescription, $price, $category, $inspiredBy)
    {
        $prompt = "You are an expert SEO specialist for an e-commerce perfume store. Generate SEO-optimized content for the following product:\n\n";
        $prompt .= "Product Name: {$productName}\n";
        
        if (!empty($inspiredBy)) {
            $prompt .= "Inspired By: {$inspiredBy}\n";
        }
        
        if (!empty($description)) {
            $prompt .= "Description: {$description}\n";
        }
        
        if (!empty($shortDescription)) {
            $prompt .= "Short Description: {$shortDescription}\n";
        }
        
        if (!empty($price)) {
            $prompt .= "Price: ₹{$price}\n";
        }
        
        if (!empty($category)) {
            $prompt .= "Category: {$category}\n";
        }
        
        $prompt .= "\nGenerate the following SEO content in this EXACT format (each field on a NEW LINE):\n\n";
        $prompt .= "META_TITLE: [Write a compelling 50-60 character title with main keyword]\n\n";
        $prompt .= "META_DESCRIPTION: [Write a detailed 150-200 character description with keywords and call-to-action]\n\n";
        $prompt .= "FOCUS_KEYWORDS: [List 5-7 relevant keywords, comma-separated]\n\n";
        $prompt .= "OG_TITLE: [Write an engaging social media title, 50-60 characters]\n\n";
        $prompt .= "OG_DESCRIPTION: [Write a compelling social media description, 150-200 characters that encourages sharing]\n\n";
        $prompt .= "IMPORTANT: Make sure to write content for ALL 5 fields. Make content engaging and SEO-friendly for perfume/fragrance products. Each field should be on its own line.";
        
        return $prompt;
    }

    private function parseGeneratedContent($text)
    {
        Log::info('Parsing Generated Text', ['text' => $text]);
        
        $seoData = [
            'meta_title' => '',
            'meta_description' => '',
            'focus_keywords' => '',
            'og_title' => '',
            'og_description' => ''
        ];

        // Parse each field - improved regex to handle multi-line and various formats
        if (preg_match('/META_TITLE:\s*(.+?)(?=\n\w+:|$)/is', $text, $matches)) {
            $seoData['meta_title'] = trim($matches[1]);
        }

        if (preg_match('/META_DESCRIPTION:\s*(.+?)(?=\n\w+:|$)/is', $text, $matches)) {
            $seoData['meta_description'] = trim($matches[1]);
        }

        if (preg_match('/FOCUS_KEYWORDS:\s*(.+?)(?=\n\w+:|$)/is', $text, $matches)) {
            $seoData['focus_keywords'] = trim($matches[1]);
        }

        if (preg_match('/OG_TITLE:\s*(.+?)(?=\n\w+:|$)/is', $text, $matches)) {
            $seoData['og_title'] = trim($matches[1]);
        }

        if (preg_match('/OG_DESCRIPTION:\s*(.+?)(?=\n\w+:|$)/is', $text, $matches)) {
            $seoData['og_description'] = trim($matches[1]);
        }

        Log::info('Parsed SEO Data', ['data' => $seoData]);

        return $seoData;
    }
}
