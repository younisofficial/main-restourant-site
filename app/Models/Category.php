<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function foods(): HasMany
    {
        return $this->hasMany(Food::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset($this->image) : asset('images/placeholder.jpg');
    }
}
