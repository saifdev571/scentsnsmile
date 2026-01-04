<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ReviewHelpful;
use App\Services\ImageKitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    protected $imageKit;

    public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
    }

    /**
     * Get reviews for a product with filters and sorting
     */
    public function index(Request $request, Product $product)
    {
        $perPage = $request->get('per_page', 10);
        $rating = $request->get('rating'); // Filter by rating
        $sort = $request->get('sort', 'recent'); // recent, highest, lowest, helpful

        $query = $product->reviews()->where('is_approved', true);

        // Filter by rating
        if ($rating && $rating >= 1 && $rating <= 5) {
            $query->where('rating', $rating);
        }

        // Sorting
        switch ($sort) {
            case 'highest':
                $query->orderBy('rating', 'desc');
                break;
            case 'lowest':
                $query->orderBy('rating', 'asc');
                break;
            case 'helpful':
                $query->orderBy('helpful_count', 'desc');
                break;
            case 'recent':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $reviews = $query->with('user')->paginate($perPage);

        // Add user's helpful status to each review
        $userIp = $request->ip();
        foreach ($reviews as $review) {
            $review->user_marked_helpful = ReviewHelpful::where('review_id', $review->id)
                ->where('ip_address', $userIp)
                ->exists();
        }

        return response()->json([
            'success' => true,
            'reviews' => $reviews->items(),
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ]
        ]);
    }

    /**
     * Get rating statistics for a product
     */
    public function stats(Product $product)
    {
        $reviews = $product->reviews()->where('is_approved', true);
        
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;

        // Rating breakdown
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
            $ratingBreakdown[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        return response()->json([
            'success' => true,
            'stats' => [
                'total_reviews' => $totalReviews,
                'average_rating' => $averageRating,
                'rating_breakdown' => $ratingBreakdown
            ]
        ]);
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10|max:1000',
            'name' => 'required_without:user_id|string|max:255',
            'email' => 'required_without:user_id|email|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'string', // Image URLs already uploaded
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = Auth::id();

        // Check if user already reviewed this product
        if ($userId) {
            $existingReview = ProductReview::where('product_id', $product->id)
                ->where('user_id', $userId)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this product.'
                ], 422);
            }
        }

        // Check if user purchased this product (for verified purchase badge)
        $isVerifiedPurchase = false;
        if ($userId) {
            $isVerifiedPurchase = \App\Models\Order::where('user_id', $userId)
                ->whereHas('items', function($q) use ($product) {
                    $q->where('product_id', $product->id);
                })
                ->where('status', 'delivered')
                ->exists();
        }

        $review = ProductReview::create([
            'product_id' => $product->id,
            'user_id' => $userId,
            'name' => $userId ? null : $request->name,
            'email' => $userId ? null : $request->email,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'images' => $request->images ?? [],
            'is_verified_purchase' => $isVerifiedPurchase,
            'is_approved' => true, // Auto-approve for now, can add moderation later
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your review!',
            'review' => $review->load('user')
        ]);
    }

    /**
     * Upload review image
     */
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image file',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('image');
            
            // Upload to ImageKit
            $result = $this->imageKit->upload($file, 'reviews');

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'url' => $result['url'],
                    'thumbnail_url' => $result['thumbnail_url'] ?? $result['url']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload image'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark review as helpful
     */
    public function markHelpful(Request $request, ProductReview $review)
    {
        $userId = Auth::id();
        $ipAddress = $request->ip();

        // Check if already marked helpful
        $existing = ReviewHelpful::where('review_id', $review->id)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existing) {
            // Remove helpful mark (toggle)
            $existing->delete();
            $review->decrement('helpful_count');

            return response()->json([
                'success' => true,
                'message' => 'Removed helpful mark',
                'helpful_count' => $review->fresh()->helpful_count,
                'marked' => false
            ]);
        } else {
            // Add helpful mark
            ReviewHelpful::create([
                'review_id' => $review->id,
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'created_at' => now()
            ]);

            $review->increment('helpful_count');

            return response()->json([
                'success' => true,
                'message' => 'Marked as helpful',
                'helpful_count' => $review->fresh()->helpful_count,
                'marked' => true
            ]);
        }
    }
}
