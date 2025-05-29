<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Dashboard</title>
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
        
        .users-table {
            background-color: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        
        .table th {
            font-weight: 600;
            color: var(--text-color);
            background-color: var(--background-color);
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        .user-row {
            transition: all 0.2s ease;
        }
        
        .user-row:hover {
            background-color: var(--background-color);
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
        
        .btn-icon {
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .btn-icon:hover {
            transform: translateY(-1px);
        }
        
        .search-box {
            max-width: 300px;
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
        
        @media (max-width: 768px) {
            .table-responsive {
                margin: 0 -1rem;
                padding: 0 1rem;
                width: calc(100% + 2rem);
            }
            
            .btn-group {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">User Management</h2>
                <div class="search-box">
                    <form action="{{ route('admin.users.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
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

        <div class="users-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Status</th>
                            <th>Cart Items</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="user-row">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="status-badge admin">Admin</span>
                                    @elseif($user->is_blocked)
                                        <span class="status-badge blocked">Blocked</span>
                                    @else
                                        <span class="status-badge active">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->carts->where('status', 'active')->first())
                                        <span class="badge bg-primary">
                                            {{ $user->carts->where('status', 'active')->first()->items->count() }} items
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">No items</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if(!$user->is_admin || auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.clear-cart', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Are you sure you want to clear this user\'s cart?')">
                                                    <i class="bi bi-cart-x"></i>
                                                </button>
                                            </form>
                                            
                                            @if($user->is_blocked)
                                                <form action="{{ route('admin.users.unblock', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-unlock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.users.block', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to block this user?')">
                                                        <i class="bi bi-lock"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 