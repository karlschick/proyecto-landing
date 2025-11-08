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

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
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

    // Helpers
    public function getSubtotal(): float
    {
        return $this->price * $this->quantity;
    }

    public function increaseQuantity(int $amount = 1): void
    {
        $this->increment('quantity', $amount);
    }

    public function decreaseQuantity(int $amount = 1): void
    {
        $newQuantity = $this->quantity - $amount;

        if ($newQuantity <= 0) {
            $this->delete();
        } else {
            $this->decrement('quantity', $amount);
        }
    }
}
