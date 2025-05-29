@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-2">Welcome to StyleSack</h1>
            <p class="text-muted mb-4">Modern Bag Essentials</p>
            
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Welcome back, {{ auth()->user()->name }}!</h5>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 bg-primary bg-opacity-10 rounded-3">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-cart3 fs-1 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Active Cart</h6>
                                            <p class="mb-0">
                                                @if($activeCart = auth()->user()->carts()->where('status', 'active')->first())
                                                    {{ $activeCart->items->count() }} items
                                                @else
                                                    No items
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 bg-success bg-opacity-10 rounded-3">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-bag-check fs-1 text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Completed Orders</h6>
                                            <p class="mb-0">
                                                {{ auth()->user()->carts()->where('status', 'completed')->count() }} orders
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 bg-info bg-opacity-10 rounded-3">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-heart fs-1 text-info"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Wishlist</h6>
                                            <p class="mb-0">Coming soon</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent Orders</h5>
                        </div>
                        <div class="card-body">
                            @if($recentOrders = auth()->user()->carts()->where('status', 'completed')->latest()->take(5)->get())
                                @forelse($recentOrders as $order)
                                    <div class="d-flex align-items-center p-3 border-bottom">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Order #{{ $order->id }}</h6>
                                            <p class="mb-0 text-muted">
                                                {{ $order->items->count() }} items • {{ $order->updated_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="mb-0">${{ number_format($order->total, 2) }}</h6>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <div class="text-muted mb-3">
                                            <i class="bi bi-clock-history fs-1"></i>
                                        </div>
                                        <h5>No Orders Yet</h5>
                                        <p class="text-muted mb-0">Start shopping to see your orders here.</p>
                                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                                            Browse Products
                                        </a>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-shop me-2"></i>Browse Products
                                </a>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-cart3 me-2"></i>View Cart
                                </a>
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-person me-2"></i>Edit Profile
                                </a>
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-shield-check me-2"></i>Admin Dashboard
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection