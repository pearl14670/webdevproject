@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ __('My Orders') }}</h2>
                </div>

                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-bag-x fs-1 text-muted"></i>
                            <p class="mt-3">{{ __('No orders found.') }}</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                {{ __('Start Shopping') }}
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Order ID') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status_badge }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>${{ $order->formatted_total }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    {{ __('View Details') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 