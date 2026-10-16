<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [
        'pending' => ['label' => 'Pending', 'color' => 'warning', 'icon' => 'hourglass-split'],
        'confirmed' => ['label' => 'Confirmed', 'color' => 'info', 'icon' => 'check2-circle'],
        'preparing' => ['label' => 'Preparing', 'color' => 'primary', 'icon' => 'fire'],
        'out_for_delivery' => ['label' => 'Out for Delivery', 'color' => 'secondary', 'icon' => 'bicycle'],
        'delivered' => ['label' => 'Delivered', 'color' => 'success', 'icon' => 'bag-check'],
        'cancelled' => ['label' => 'Cancelled', 'color' => 'danger', 'icon' => 'x-circle'],
    ];

    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'phone', 'email', 'address',
        'notes', 'subtotal', 'delivery_fee', 'total', 'payment_method', 'status',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUSES[$this->status]['color'] ?? 'secondary';
    }

    public function getStatusIconAttribute(): string
    {
        return self::STATUSES[$this->status]['icon'] ?? 'circle';
    }

    public static function generateNumber(): string
    {
        do {
            $number = 'ZQ-' . now()->format('ymd') . '-' . random_int(1000, 9999);
        } while (self::where('order_number', $number)->exists());

        return $number;
    }
}
