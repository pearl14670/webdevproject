<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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
        
        .category-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            background-color: var(--card-bg);
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .category-image {
            height: 200px;
            overflow: hidden;
            position: relative;
            background-color: #f3f4f6;
        }
        
        .category-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .category-info {
            padding: 1.5rem;
        }
        
        .btn-group .btn {
            padding: 0.375rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .category-card {
                margin-bottom: 1rem;
            }
            
            .category-image {
                height: 160px;
            }
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animated-card {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">{{ __('Categories') }}</h2>
                @can('create', App\Models\Category::class)
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>{{ __('Create Category') }}
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            @foreach($categories as $index => $category)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="category-card animated-card delay-{{ ($index % 3) + 1 }}">
                        @if($category->image)
                            <div class="category-image">
                                <img src="{{ Storage::url($category->image) }}" 
                                     alt="{{ $category->name }}">
                            </div>
                        @endif
                        <div class="category-info">
                            <h3 class="h5 mb-2">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-muted mb-3">{{ Str::limit($category->description, 100) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">
                                    <i class="bi bi-box-seam me-1"></i>
                                    {{ $category->products_count ?? 0 }} Products
                                </span>
                                <div class="btn-group">
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>{{ __('View') }}
                                    </a>
                                    @can('update', $category)
                                        <a href="{{ route('categories.edit', $category) }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="bi bi-pencil me-1"></i>{{ __('Edit') }}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 