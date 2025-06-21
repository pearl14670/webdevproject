<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlistProducts()->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Product $product)
    {
        try {
            auth()->user()->wishlistProducts()->attach($product->id);
            return redirect()->back()->with('success', 'Product added to wishlist successfully!');
        } catch (\Exception $e) {
            // Handle case where item is already in wishlist
            if ($e->getCode() == 23000) { // MySQL duplicate entry error code
                return redirect()->back()->with('error', 'Product is already in your wishlist.');
            }
            return redirect()->back()->with('error', 'Failed to add product to wishlist.');
        }
    }

    public function remove(Product $product)
    {
        auth()->user()->wishlistProducts()->detach($product->id);
        return redirect()->back()->with('success', 'Product removed from wishlist successfully!');
    }
} 