<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartComposer
{
    public function compose(View $view)
    {
        $cartCount = $this->getCartCount();
        $view->with('cartCount', $cartCount);
    }

    private function getCartCount()
    {
        $userId = Auth::id();
        $sessionId = session()->get('cart_session_id');

        return Cart::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else if ($sessionId) {
                $query->where('session_id', $sessionId);
            } else {
                $query->whereRaw('1 = 0');
            }
        })->sum('quantity');
    }
}
