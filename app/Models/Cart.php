<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now());
    }

    // Helpers
    public function getTotalItems(): int
    {
        return $this->items->sum('quantity');
    }

    public function getSubtotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public function getTax(float $rate = 0.19): float
    {
        return $this->getSubtotal() * $rate;
    }

    public function getTotal(float $taxRate = 0.19): float
    {
        return $this->getSubtotal() + $this->getTax($taxRate);
    }

    public function isEmpty(): bool
    {
        return $this->items->count() === 0;
    }

    public function clear(): void
    {
        $this->items()->delete();
    }
}
