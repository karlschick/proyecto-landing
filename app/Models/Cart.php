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

    public function getTotal(): float
    {
        return $this->getSubtotal() + $this->getTax();
    }

    public function isEmpty(): bool
    {
        return $this->items->count() === 0;
    }

    public function clear(): void
    {
        $this->items()->delete();
    }

    /**
     * Calcula el IVA solo sobre productos gravables (excluye libros)
     */
    public function getTaxAmount(): float
    {
        $taxableAmount = 0;

        foreach ($this->items as $item) {
            // Solo suma al monto gravable si NO es un libro
            if (!$item->product->isBook()) {
                $taxableAmount += $item->getSubtotal();
            }
        }

        return $taxableAmount * 0.19; // 19% IVA
    }

    /**
     * Alias para mantener compatibilidad con getTax()
     */
    public function getTax(): float
    {
        return $this->getTaxAmount();
    }

    /**
     * Verifica si el carrito tiene libros
     */
    public function hasBooks(): bool
    {
        foreach ($this->items as $item) {
            if ($item->product->isBook()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verifica si el carrito contiene SOLO productos digitales (ebooks)
     */
    public function hasOnlyDigitalProducts(): bool
    {
        if ($this->items->isEmpty()) {
            return false;
        }

        foreach ($this->items as $item) {
            if (!$item->product->isBook()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Verifica si el carrito tiene productos físicos
     */
    public function hasPhysicalProducts(): bool
    {
        foreach ($this->items as $item) {
            if (!$item->product->isBook()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Obtiene el total con envío incluido
     */
    public function getTotalWithShipping(float $shippingCost = 0): float
    {
        // Si solo tiene productos digitales, no cobrar envío
        if ($this->hasOnlyDigitalProducts()) {
            return $this->getTotal();
        }

        return $this->getTotal() + $shippingCost;
    }
}
