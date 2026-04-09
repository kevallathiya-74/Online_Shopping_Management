<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Keep existing table for backward compatibility with deployed databases.
    protected $table = 'product_reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getCommentAttribute(): ?string
    {
        return $this->attributes['review'] ?? null;
    }

    public function setCommentAttribute(?string $value): void
    {
        $this->attributes['review'] = $value;
    }
}