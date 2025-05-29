<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'billing_address',
        'payment_method',
        'payment_status',
        'shipping_method',
        'shipping_cost',
        'notes',
        'tracking_number',
        'paid_at'
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected $appends = ['status_color'];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_FAILED = 'failed';
    const PAYMENT_STATUS_REFUNDED = 'refunded';

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_SHIPPED => 'primary',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_CANCELLED => 'danger',
            default => 'secondary',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function isPaid()
    {
        return $this->payment_status === self::PAYMENT_STATUS_PAID;
    }

    public function markAsPaid()
    {
        $this->update([
            'payment_status' => self::PAYMENT_STATUS_PAID,
            'paid_at' => now(),
        ]);
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 2);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_CANCELLED => 'danger',
            default => 'secondary',
        };
    }
} 