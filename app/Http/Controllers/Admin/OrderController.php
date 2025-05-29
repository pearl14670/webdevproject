<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_PROCESSING,
                Order::STATUS_SHIPPED,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELLED
            ])
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated successfully');
    }

    public function confirmPayment(Order $order)
    {
        if ($order->payment_status !== Order::PAYMENT_STATUS_PENDING) {
            return back()->with('error', 'This order\'s payment has already been processed.');
        }

        $order->markAsPaid();

        // If order is still in pending status, move it to processing
        if ($order->status === Order::STATUS_PENDING) {
            $order->update(['status' => Order::STATUS_PROCESSING]);
        }

        return back()->with('success', 'Payment has been confirmed successfully.');
    }
}
