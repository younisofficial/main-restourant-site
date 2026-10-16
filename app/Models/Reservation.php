<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    public const STATUSES = [
        'pending' => ['label' => 'Pending', 'color' => 'warning'],
        'approved' => ['label' => 'Approved', 'color' => 'success'],
        'cancelled' => ['label' => 'Cancelled', 'color' => 'danger'],
    ];

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'reservation_date',
        'reservation_time', 'guests', 'message', 'status',
    ];

    protected function casts(): array
    {
        return ['reservation_date' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUSES[$this->status]['color'] ?? 'secondary';
    }
}
