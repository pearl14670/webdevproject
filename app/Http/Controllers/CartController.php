<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->activeCart;
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'status' => 'active'
            ]);
        }

        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is active and in stock
        if (!$product->is_active) {
            return redirect()->back()->with('error', 'This product is currently not available.');
        }

        // Check if requested quantity is available
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'The requested quantity is not available. Available stock: ' . $product->stock);
        }

        $cart = auth()->user()->activeCart;
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'status' => 'active'
            ]);
        }

        // Check if product already exists in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Check if the combined quantity exceeds available stock
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Cannot add more of this item. Maximum available stock would be exceeded.');
            }

            // Update quantity if product exists
            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->price // Update price in case it changed
            ]);
        } else {
            // Create new cart item if product doesn't exist
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function destroy(CartItem $cartItem)
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = auth()->user()->activeCart;
        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }
} 