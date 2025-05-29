<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_blocked',
        'is_admin',
        'default_address',
        'default_city',
        'default_state',
        'default_postal_code',
        'default_country',
        'default_phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
        'is_admin' => 'boolean',
        'default_address' => 'array'
    ];

    /**
     * Get all carts belonging to the user.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the active cart for the user.
     */
    public function getActiveCartAttribute()
    {
        return $this->carts()->where('status', 'active')->first();
    }

    /**
     * Get all orders belonging to the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all reviews by the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all products in the user's wishlist.
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Check if a product is in the user's wishlist.
     */
    public function hasInWishlist(Product $product)
    {
        return $this->wishlist()->where('product_id', $product->id)->exists();
    }

    /**
     * Get the total amount spent by the user.
     */
    public function getTotalSpentAttribute()
    {
        return $this->orders()->sum('total_amount');
    }

    /**
     * Get the count of orders made by the user.
     */
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * Check if the user is blocked.
     */
    public function isBlocked()
    {
        return $this->is_blocked;
    }

    /**
     * Get the user's latest order.
     */
    public function getLatestOrderAttribute()
    {
        return $this->orders()->latest()->first();
    }

    public function cartItems()
    {
        return $this->hasManyThrough(
            CartItem::class, 
            Cart::class,
            'user_id', // Foreign key on carts table
            'cart_id', // Foreign key on cart_items table
            'id', // Local key on users table
            'id'  // Local key on carts table
        )->whereHas('cart', function($query) {
            $query->where('status', 'active');
        });
    }

    protected static function booted()
    {
        static::created(function ($user) {
            // Set default address when user is created
            $user->update([
                'default_address' => '123 Main Street',
                'default_city' => 'Cebu City',
                'default_state' => 'Cebu',
                'default_postal_code' => '6000',
                'default_country' => 'PH',
                'default_phone' => '+63 123 456 7890'
            ]);
        });

        // Add method to track admin status changes
        static::saving(function ($user) {
            \Log::info('Saving user with admin status:', [
                'user_id' => $user->id,
                'old_is_admin' => $user->getOriginal('is_admin'),
                'new_is_admin' => $user->is_admin,
                'changes' => $user->getDirty()
            ]);
        });
    }
}
