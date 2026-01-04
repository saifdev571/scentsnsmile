<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Get cart items (works for both guest and logged-in users)
     */
    public function index(): JsonResponse
    {
        return response()->json($this->cartService->getCartSummary());
    }

    /**
     * Add item to cart (no login required)
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $this->cartService->addToCart(
            $request->product_id,
            $request->quantity ?? 1,
            $request->variant_id
        );

        return response()->json($this->cartService->getCartSummary());
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->updateQuantity($id, $request->quantity);

        return response()->json($this->cartService->getCartSummary());
    }

    /**
     * Remove item from cart
     */
    public function remove($id): JsonResponse
    {
        $this->cartService->removeFromCart($id);

        return response()->json($this->cartService->getCartSummary());
    }

    /**
     * Clear entire cart
     */
    public function clear(): JsonResponse
    {
        $this->cartService->clearCart();

        return response()->json([
            'success' => true,
            'items' => [],
            'subtotal' => 0,
            'item_count' => 0,
        ]);
    }

    /**
     * Get cart count (for header badge)
     */
    public function count(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'count' => $this->cartService->getItemCount(),
        ]);
    }
}
