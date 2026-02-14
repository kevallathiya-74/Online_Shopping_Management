<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock', 'image'];

    // Relationship: Product belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship: Product has many Cart items
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relationship: Product has many Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship: Product has many Reviews
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Relationship: Product is in many Wishlists
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Check if product is in wishlist of authenticated user
    public function inWishlist()
    {
        if (auth()->check()) {
            return $this->wishlists()->where('user_id', auth()->id())->exists();
        }
        return false;
    }
}
