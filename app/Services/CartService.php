<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Get or create session ID for guest cart
     */
    public function getSessionId(): string
    {
        if (!session()->has('cart_session_id')) {
            session()->put('cart_session_id', uniqid('cart_', true));
        }
        return session()->get('cart_session_id');
    }

    /**
     * Get cart items for current user/guest
     */
    public function getCartItems()
    {
        $userId = Auth::id();
        $sessionId = $this->getSessionId();

        return Cart::with('product')
            ->where(function($query) use ($sessionId, $userId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();
    }

    /**
     * Get cart summary data
     */
    public function getCartSummary(): array
    {
        $cartItems = $this->getCartItems();

        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $itemCount = $cartItems->sum('quantity');

        return [
            'success' => true,
            'items' => $cartItems->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name ?? 'Product',
                    'image' => $item->product->image_url ?? '',
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->price * $item->quantity,
                ];
            }),
            'subtotal' => $subtotal,
            'item_count' => $itemCount,
        ];
    }

    /**
     * Add item to cart
     */
    public function addToCart(int $productId, int $quantity = 1, ?int $variantId = null): Cart
    {
        $product = Product::findOrFail($productId);
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        // Get the price (sale price if available)
        $price = ($product->sale_price && $product->sale_price < $product->price) 
            ? $product->sale_price 
            : $product->price;

        // Check if item already in cart
        $query = Cart::where('product_id', $product->id);
        
        if ($variantId) {
            $query->where('variant_id', $variantId);
        } else {
            $query->whereNull('variant_id');
        }

        $existingItem = $query->where(function($q) use ($sessionId, $userId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
            return $existingItem;
        }

        return Cart::create([
            'session_id' => $userId ? null : $sessionId,
            'user_id' => $userId,
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'quantity' => $quantity,
            'price' => $price,
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(int $cartId, int $quantity): ?Cart
    {
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        $cartItem = Cart::where('id', $cartId)
            ->where(function($query) use ($sessionId, $userId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return $cartItem;
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(int $cartId): bool
    {
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        return Cart::where('id', $cartId)
            ->where(function($query) use ($sessionId, $userId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->delete() > 0;
    }

    /**
     * Clear entire cart
     */
    public function clearCart(): bool
    {
        $sessionId = $this->getSessionId();
        $userId = Auth::id();

        return Cart::where(function($query) use ($sessionId, $userId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete() > 0;
    }

    /**
     * Merge guest cart into user cart on login/register
     * This is the key method for cart persistence
     */
    public function mergeGuestCartToUser(int $userId): void
    {
        $sessionId = session()->get('cart_session_id');
        
        if (!$sessionId) {
            return; // No guest cart to merge
        }

        // Get all guest cart items
        $guestCartItems = Cart::where('session_id', $sessionId)->get();

        if ($guestCartItems->isEmpty()) {
            return; // No items to merge
        }

        foreach ($guestCartItems as $guestItem) {
            // Check if user already has this product in cart
            $query = Cart::where('user_id', $userId)
                ->where('product_id', $guestItem->product_id);
            
            if ($guestItem->variant_id) {
                $query->where('variant_id', $guestItem->variant_id);
            } else {
                $query->whereNull('variant_id');
            }

            $existingUserItem = $query->first();

            if ($existingUserItem) {
                // Merge quantities - add guest quantity to existing user cart item
                $existingUserItem->quantity += $guestItem->quantity;
                $existingUserItem->save();
                
                // Delete the guest cart item
                $guestItem->delete();
            } else {
                // Transfer guest cart item to user
                $guestItem->update([
                    'user_id' => $userId,
                    'session_id' => null,
                ]);
            }
        }

        // Clear the session cart ID after merge
        session()->forget('cart_session_id');
    }

    /**
     * Check if cart has items
     */
    public function hasItems(): bool
    {
        return $this->getCartItems()->isNotEmpty();
    }

    /**
     * Get cart item count
     */
    public function getItemCount(): int
    {
        return $this->getCartItems()->sum('quantity');
    }

    /**
     * Get cart subtotal
     */
    public function getSubtotal(): float
    {
        return $this->getCartItems()->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }
}
