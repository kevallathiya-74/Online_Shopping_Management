<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relationship: Cart belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Cart belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
