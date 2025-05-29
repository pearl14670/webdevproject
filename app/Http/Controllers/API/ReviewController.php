<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user', 'product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false
        ]);

        return response()->json($review, 201);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        $review->update($validated);

        return response()->json($review);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        $review->delete();

        return response()->json(null, 204);
    }

    public function approve(Review $review)
    {
        $this->authorize('approve', Review::class);

        $review->approve();

        return response()->json([
            'message' => 'Review approved successfully',
            'review' => $review->load(['user', 'product'])
        ]);
    }

    public function reject(Review $review)
    {
        $this->authorize('approve', Review::class);

        $review->reject();

        return response()->json([
            'message' => 'Review rejected successfully',
            'review' => $review->load(['user', 'product'])
        ]);
    }
} 