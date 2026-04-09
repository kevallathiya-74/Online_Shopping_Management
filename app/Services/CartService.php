<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Collection;

class CartService
{
    public function getUserCartItems(int $userId, bool $withCategory = false): Collection
    {
        $relation = $withCategory ? 'product.category' : 'product';

        return Cart::where('user_id', $userId)
            ->with($relation)
            ->get();
    }

    public function calculateTotal(Collection $cartItems): float
    {
        return (float) $cartItems->sum(function ($item) {
            $price = $item->product?->price ?? 0;
            return $price * $item->quantity;
        });
    }

    public function calculateQuantityCount(Collection $cartItems): int
    {
        return (int) $cartItems->sum('quantity');
    }

    public function clearUserCart(int $userId): void
    {
        Cart::where('user_id', $userId)->delete();
    }
}