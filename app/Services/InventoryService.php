<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use RuntimeException;

class InventoryService
{
    public function deductStockForCartItems(Collection $cartItems): void
    {
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product ?? Product::find($cartItem->product_id);

            if (!$product) {
                throw new RuntimeException('Product not found while processing the order.');
            }

            if ($cartItem->quantity > $product->stock) {
                throw new RuntimeException('Product "' . $product->name . '" has insufficient stock.');
            }

            $product->stock -= $cartItem->quantity;
            $product->save();
        }
    }

    public function restoreStockForOrderItems(Collection $orderItems): void
    {
        foreach ($orderItems as $orderItem) {
            $product = $orderItem->product ?? Product::find($orderItem->product_id);

            if (!$product) {
                continue;
            }

            $product->stock += $orderItem->quantity;
            $product->save();
        }
    }
}