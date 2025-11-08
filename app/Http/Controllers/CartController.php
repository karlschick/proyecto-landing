<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $cart->load('items.product');

        return view('landing.cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        try {
            $this->cartService->addItem($product, $request->quantity);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto agregado al carrito',
                    'cart_count' => $this->cartService->getItemCount(),
                ]);
            }

            return redirect()
                ->back()
                ->with('success', 'Producto agregado al carrito exitosamente.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 400);
            }

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:999',
        ]);

        try {
            $this->cartService->updateQuantity($cartItem, $request->quantity);

            if ($request->expectsJson()) {
                $cart = $this->cartService->getCart();
                return response()->json([
                    'success' => true,
                    'message' => 'Cantidad actualizada',
                    'cart_count' => $this->cartService->getItemCount(),
                    'item_subtotal' => $cartItem->getSubtotal(),
                    'cart_subtotal' => $cart->getSubtotal(),
                    'cart_total' => $cart->getTotal(),
                ]);
            }

            return redirect()
                ->back()
                ->with('success', 'Cantidad actualizada.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 400);
            }

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function remove(CartItem $cartItem)
    {
        try {
            $this->cartService->removeItem($cartItem);

            return redirect()
                ->back()
                ->with('success', 'Producto eliminado del carrito.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function clear()
    {
        $this->cartService->clear();

        return redirect()
            ->back()
            ->with('success', 'Carrito vaciado.');
    }

    public function count()
    {
        return response()->json([
            'count' => $this->cartService->getItemCount(),
        ]);
    }
}
