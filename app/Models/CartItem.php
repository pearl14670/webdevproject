<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    /**
     * Get the cart that owns the item.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product associated with the item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2);
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2);
    }

    public function incrementQuantity($amount = 1)
    {
        $this->update([
            'quantity' => $this->quantity + $amount
        ]);
    }

    public function decrementQuantity($amount = 1)
    {
        $newQuantity = $this->quantity - $amount;
        
        if ($newQuantity <= 0) {
            $this->delete();
            return;
        }

        $this->update([
            'quantity' => $newQuantity
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (!$item->price) {
                $item->price = $item->product->price;
            }
        });
    }
} 