<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\Category;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Review;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CartItemPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\Admin\ProductPolicy as AdminProductPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        CartItem::class => CartItemPolicy::class,
        Order::class => OrderPolicy::class,
        Review::class => ReviewPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Register admin policies
        Gate::define('admin.viewAny-product', [AdminProductPolicy::class, 'viewAny']);
        Gate::define('admin.view-product', [AdminProductPolicy::class, 'view']);
        Gate::define('admin.create-product', [AdminProductPolicy::class, 'create']);
        Gate::define('admin.update-product', [AdminProductPolicy::class, 'update']);
        Gate::define('admin.delete-product', [AdminProductPolicy::class, 'delete']);
    }
}
