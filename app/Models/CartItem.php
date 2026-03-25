<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relaciones
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Subtotal = precio * cantidad
     */
    public function getSubtotal(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Verifica si el producto es digital (ebook)
     */
    public function isDigital(): bool
    {
        return $this->product->isBook();
    }

    /**
     * Verifica si el producto es físico
     */
    public function isPhysical(): bool
    {
        return !$this->product->isBook();
    }
}
