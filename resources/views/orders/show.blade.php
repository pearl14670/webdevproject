@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-4">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('Back to Orders') }}
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ __('Order Details') }} #{{ $order->id }}</h2>
                        <span class="badge bg-{{ $order->status_badge }} fs-6">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>{{ __('Order Information') }}</h5>
                            <p class="mb-1"><strong>{{ __('Order Date:') }}</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                            <p class="mb-1"><strong>{{ __('Payment Method:') }}</strong> {{ ucfirst($order->payment_method) }}</p>
                            <p class="mb-1"><strong>{{ __('Payment Status:') }}</strong> {{ ucfirst($order->payment_status) }}</p>
                            @if($order->tracking_number)
                                <p class="mb-1"><strong>{{ __('Tracking Number:') }}</strong> {{ $order->tracking_number }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>{{ __('Shipping Address') }}</h5>
                            @if($order->shipping_address)
                                <address>
                                    {{ $order->shipping_address['name'] ?? '' }}<br>
                                    {{ $order->shipping_address['address'] ?? '' }}<br>
                                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}<br>
                                    {{ $order->shipping_address['country'] ?? '' }}
                                </address>
                            @endif
                        </div>
                    </div>

                    <h5 class="mb-3">{{ __('Order Items') }}</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th class="text-end">{{ __('Total') }}</th>
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
                                                    <h6 class="mb-0">{{ $item->product->name ?? 'Product Unavailable' }}</h6>
                                                    @if($item->product)
                                                        <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ $item->formatted_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">${{ $item->formatted_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('Total:') }}</strong></td>
                                    <td class="text-end"><strong>${{ $order->formatted_total }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 