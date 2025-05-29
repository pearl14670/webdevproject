@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Stats -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-5">
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary p-3 rounded-3 me-3">
                            <svg class="bi text-white" width="24" height="24" fill="currentColor">
                                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h6 class="card-subtitle text-muted mb-0">Total Orders</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="card-title mb-0 me-2">{{ $stats['total_orders'] }}</h3>
                        <small class="text-success">
                            +{{ $stats['orders_increase'] }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary p-3 rounded-3 me-3">
                            <svg class="bi text-white" width="24" height="24" fill="currentColor">
                                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h6 class="card-subtitle text-muted mb-0">Revenue</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="card-title mb-0 me-2">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        <small class="text-success">
                            +{{ $stats['revenue_increase'] }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary p-3 rounded-3 me-3">
                            <svg class="bi text-white" width="24" height="24" fill="currentColor">
                                <path d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h6 class="card-subtitle text-muted mb-0">Products</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="card-title mb-0 me-2">{{ $stats['total_products'] }}</h3>
                        <small class="text-success">
                            +{{ $stats['products_increase'] }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary p-3 rounded-3 me-3">
                            <svg class="bi text-white" width="24" height="24" fill="currentColor">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h6 class="card-subtitle text-muted mb-0">Customers</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="card-title mb-0 me-2">{{ $stats['total_customers'] }}</h3>
                        <small class="text-success">
                            +{{ $stats['customers_increase'] }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Recent Orders -->
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Recent Orders</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->order_number }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_color }}">{{ $order->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-link p-0">
                        View all orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Reviews -->
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Pending Reviews</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingReviews as $review)
                                    <tr>
                                        <td>{{ $review->product->name }}</td>
                                        <td>{{ $review->user->name }}</td>
                                        <td>{{ $review->rating }}/5</td>
                                        <td>
                                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check-lg"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline ms-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-x-lg"></i> Reject
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">No pending reviews</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($pendingReviews->isNotEmpty())
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-link p-0">
                            View all reviews
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <h5 class="mb-4">Quick Actions</h5>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <a href="{{ route('admin.products.create') }}" class="card h-100 text-decoration-none text-dark">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg class="bi text-muted" width="24" height="24" fill="currentColor">
                                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <h6 class="card-title mb-1">Add New Product</h6>
                            <p class="card-text text-muted small">Create a new product listing</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('admin.categories.create') }}" class="card h-100 text-decoration-none text-dark">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg class="bi text-muted" width="24" height="24" fill="currentColor">
                                <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h6 class="card-title mb-1">Add New Category</h6>
                            <p class="card-text text-muted small">Create a new product category</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('admin.orders.index') }}" class="card h-100 text-decoration-none text-dark">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <svg class="bi text-muted" width="24" height="24" fill="currentColor">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h6 class="card-title mb-1">Manage Orders</h6>
                            <p class="card-text text-muted small">View and process orders</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection 