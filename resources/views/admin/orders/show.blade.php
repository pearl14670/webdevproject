@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order #{{ $order->order_number }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ $item->product->image }}" 
                                                         alt="{{ $item->product->name }}"
                                                         class="me-3"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product_name }}</h6>
                                                    @if($item->product)
                                                        <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal:</td>
                                    <td>${{ number_format($order->total_amount - $order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Shipping Cost:</td>
                                    <td>${{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Status:</dt>
                        <dd class="col-sm-8">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach([
                                        \App\Models\Order::STATUS_PENDING,
                                        \App\Models\Order::STATUS_PROCESSING,
                                        \App\Models\Order::STATUS_SHIPPED,
                                        \App\Models\Order::STATUS_DELIVERED,
                                        \App\Models\Order::STATUS_CANCELLED
                                    ] as $status)
                                        <option value="{{ $status }}" 
                                                {{ $order->status == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </dd>

                        <dt class="col-sm-4">Payment:</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                @if($order->payment_status === 'pending')
                                    <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to confirm this payment?')">
                                            <i class="bi bi-check-circle me-1"></i>Confirm Payment
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </dd>

                        <dt class="col-sm-4">Method:</dt>
                        <dd class="col-sm-8">{{ ucfirst($order->payment_method) }}</dd>

                        <dt class="col-sm-4">Date:</dt>
                        <dd class="col-sm-8">{{ $order->created_at->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Name:</dt>
                        <dd class="col-sm-8">{{ $order->user->name }}</dd>

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $order->user->email }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Shipping Address</h5>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        {{ $order->shipping_address['name'] }}<br>
                        {{ $order->shipping_address['address'] }}<br>
                        {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['postal_code'] }}<br>
                        {{ $order->shipping_address['country'] }}<br>
                        Phone: {{ $order->shipping_address['phone'] }}
                    </address>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Billing Address</h5>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        {{ $order->billing_address['name'] }}<br>
                        {{ $order->billing_address['address'] }}<br>
                        {{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['postal_code'] }}<br>
                        {{ $order->billing_address['country'] }}<br>
                        Phone: {{ $order->billing_address['phone'] }}
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 