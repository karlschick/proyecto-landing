<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Obtener o crear carrito
     */
    public function getCart(): Cart
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->active()
                ->first();
        } else {
            $sessionId = Session::getId();
            $cart = Cart::where('session_id', $sessionId)
                ->active()
                ->first();
        }

        if (!$cart) {
            $cart = $this->createCart();
        }

        return $cart;
    }

    /**
     * Crear nuevo carrito
     */
    protected function createCart(): Cart
    {
        return Cart::create([
            'user_id' => Auth::id(),
            'session_id' => Session::getId(),
            'expires_at' => now()->addDays(7),
        ]);
    }

    /**
     * Agregar producto al carrito
     */
    public function addItem(Product $product, int $quantity = 1): CartItem
    {
        if (!$product->isInStock()) {
            throw new \Exception('Producto sin stock');
        }

        if ($product->track_quantity && $product->quantity < $quantity) {
            throw new \Exception('Cantidad solicitada no disponible');
        }

        $cart = $this->getCart();

        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            if ($product->track_quantity && $product->quantity < $newQuantity) {
                throw new \Exception('Cantidad solicitada excede el stock disponible');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cartItem = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return $cartItem;
    }

    /**
     * Actualizar cantidad de un item
     */
    public function updateQuantity(CartItem $cartItem, int $quantity): CartItem
    {
        if ($quantity <= 0) {
            $cartItem->delete();
            return $cartItem;
        }

        $product = $cartItem->product;

        if ($product->track_quantity && $product->quantity < $quantity) {
            throw new \Exception('Cantidad solicitada excede el stock disponible');
        }

        $cartItem->update(['quantity' => $quantity]);

        return $cartItem;
    }

    /**
     * Eliminar item del carrito
     */
    public function removeItem(CartItem $cartItem): void
    {
        $cartItem->delete();
    }

    /**
     * Vaciar carrito
     */
    public function clear(): void
    {
        $cart = $this->getCart();
        $cart->clear();
    }

    /**
     * Contar items en carrito
     */
    public function getItemCount(): int
    {
        $cart = $this->getCart();
        return $cart->getTotalItems();
    }

    /**
     * Obtener total del carrito
     */
    public function getTotal(): float
    {
        $cart = $this->getCart();
        return $cart->getTotal();
    }

    /**
     * Verificar si el carrito está vacío
     */
    public function isEmpty(): bool
    {
        $cart = $this->getCart();
        return $cart->isEmpty();
    }

    /**
     * Migrar carrito de sesión a usuario autenticado
     */
    public function migrateCart(): void
    {
        if (!Auth::check()) {
            return;
        }

        $sessionId = Session::getId();
        $sessionCart = Cart::where('session_id', $sessionId)
            ->where('user_id', null)
            ->first();

        if (!$sessionCart || $sessionCart->isEmpty()) {
            return;
        }

        $userCart = Cart::where('user_id', Auth::id())->first();

        if (!$userCart) {
            // Asignar carrito de sesión al usuario
            $sessionCart->update(['user_id' => Auth::id()]);
        } else {
            // Merge carritos
            foreach ($sessionCart->items as $item) {
                $existingItem = $userCart->items()
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('quantity', $item->quantity);
                } else {
                    $item->update(['cart_id' => $userCart->id]);
                }
            }

            $sessionCart->delete();
        }
    }
}
