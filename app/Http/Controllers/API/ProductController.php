<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->with('category')
            ->latest()
            ->paginate($request->per_page ?? 12);

        return response()->json($products);
    }

    public function show(Product $product)
    {
        if (!$product->is_active || $product->stock <= 0) {
            return response()->json(['message' => 'Product not available'], 404);
        }

        return response()->json($product->load('category'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product = Product::create([
            ...$validatedData,
            'images' => $images
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product->load('category')
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = $product->images ?? [];

        // Remove images if requested
        if ($request->remove_images) {
            foreach ($request->remove_images as $image) {
                if (in_array($image, $images)) {
                    Storage::disk('public')->delete($image);
                    $images = array_diff($images, [$image]);
                }
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product->update([
            ...$validatedData,
            'images' => array_values($images)
        ]);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->load('category')
        ]);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        // Delete product images
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
} 
 