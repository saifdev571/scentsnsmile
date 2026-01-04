<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Promotion;

class PromotionComposer
{
    public function compose(View $view)
    {
        // Get active promotion for header/cart
        $activePromotion = Promotion::active()
            ->orderBy('sort_order')
            ->first();

        // Get all active promotions for display
        $headerPromotion = Promotion::forHeader()->first();
        $cartPromotions = Promotion::forCart()->get();

        $view->with([
            'activePromotion' => $activePromotion,
            'headerPromotion' => $headerPromotion,
            'cartPromotions' => $cartPromotions,
        ]);
    }
}
