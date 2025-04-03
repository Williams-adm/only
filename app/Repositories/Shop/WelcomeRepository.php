<?php

namespace App\Repositories\Shop;

use App\Models\Cover;
use App\Models\Product;

class WelcomeRepository
{
    public function index()
    {
        $covers = Cover::where('is_active', true)
            ->whereDate('start_at', '<=', now())
            ->where(
                fn($query) =>
                $query->whereDate('end_at', '>=', now())
                    ->orWhereNull('end_at')
            )
            ->orderBy('order', 'asc')->with('images')->get();

        $lastProducts = Product::orderBy('created_at', 'desc')
            ->take(12)->with('variants.images')->get();

        return compact('covers', 'lastProducts');
    }
}