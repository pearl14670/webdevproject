<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --success-color: #10b981;
            --info-color: #3b82f6;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-color: #111827;
            --light-text: #6b7280;
            --border-color: #e5e7eb;
            --background-color: #f9fafb;
            --card-bg: #ffffff;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        .page-header {
            background-color: var(--card-bg);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-badge.active {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }
        
        .status-badge.blocked {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }
        
        .status-badge.admin {
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }
        
        .cart-item {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item:hover {
            background-color: var(--background-color);
        }
        
        .btn-icon {
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .btn-icon:hover {
            transform: translateY(-1px);
        }
        
        .alert {
            border: none;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-0">User Details</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit User
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle p-4 d-inline-block mb-3">
                                <i class="bi bi-person fs-2"></i>
                            </div>
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                        
                        <div class="d-flex justify-content-center mb-4">
                            @if($user->is_admin)
                                <span class="status-badge admin">Admin</span>
                            @elseif($user->is_blocked)
                                <span class="status-badge blocked">Blocked</span>
                            @else
                                <span class="status-badge active">Active</span>
                            @endif
                        </div>
                        
                        <div class="border-top pt-3">
                            <p class="mb-1">
                                <strong>Registered:</strong>
                                <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                            </p>
                            <p class="mb-1">
                                <strong>Last Updated:</strong>
                                <span class="text-muted">{{ $user->updated_at->format('M d, Y') }}</span>
                            </p>
                        </div>
                        
                        @if(!$user->is_admin || auth()->id() !== $user->id)
                            <div class="border-top pt-3 mt-3">
                                <div class="d-grid gap-2">
                                    @if($user->is_blocked)
                                        <form action="{{ route('admin.users.unblock', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bi bi-unlock me-2"></i>Unblock User
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.block', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Are you sure you want to block this user?')">
                                                <i class="bi bi-lock me-2"></i>Block User
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                            <i class="bi bi-trash me-2"></i>Delete User
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Active Cart</h5>
                        @if($user->carts->where('status', 'active')->first())
                            <form action="{{ route('admin.users.clear-cart', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to clear this user\'s cart?')">
                                    <i class="bi bi-cart-x me-2"></i>Clear Cart
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($activeCart = $user->carts->where('status', 'active')->first())
                            @foreach($activeCart->items as $item)
                                <div class="cart-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                                            <p class="text-muted mb-0">
                                                Quantity: {{ $item->quantity }} × ${{ number_format($item->product->price, 2) }}
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="mb-0">${{ number_format($item->subtotal, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="border-top mt-3 pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Total</h5>
                                    <h5 class="mb-0">${{ number_format($activeCart->total, 2) }}</h5>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted mb-3">
                                    <i class="bi bi-cart fs-1"></i>
                                </div>
                                <h5>No Active Cart</h5>
                                <p class="text-muted mb-0">This user doesn't have any items in their cart.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order History</h5>
                    </div>
                    <div class="card-body">
                        @if($completedCarts = $user->carts->where('status', 'completed'))
                            @foreach($completedCarts as $cart)
                                <div class="cart-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Order #{{ $cart->id }}</h6>
                                            <p class="text-muted mb-0">
                                                {{ $cart->items->count() }} items • {{ $cart->updated_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="mb-0">${{ number_format($cart->total, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted mb-3">
                                    <i class="bi bi-clock-history fs-1"></i>
                                </div>
                                <h5>No Order History</h5>
                                <p class="text-muted mb-0">This user hasn't completed any orders yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 