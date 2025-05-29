<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $products = $query->with('category')
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
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
            'images' => $images,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
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
            'images' => array_values($images),
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        // Delete product images
        if (!empty($product->images)) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
} 