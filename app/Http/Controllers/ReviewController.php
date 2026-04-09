<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Product::findOrFail($validated['product_id']);

        try {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => (int) $validated['product_id'],
                'rating' => (int) $validated['rating'],
                'comment' => $request->filled('comment') ? trim(strip_tags($validated['comment'])) : null,
            ]);
        } catch (QueryException $exception) {
            if ((string) $exception->getCode() === '23000') {
                return back()->with('error', 'You have already reviewed this product.');
            }

            throw $exception;
        }

        return back()->with('success', 'Review submitted successfully!');
    }

    public function storeForProduct(Request $request, $id)
    {
        $request->merge(['product_id' => $id]);

        return $this->store($request);
    }
}