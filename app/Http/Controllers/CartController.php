<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Devuelve el número de productos en el carrito del usuario autenticado (AJAX)
     */
    public function cartCount(Request $request)
    {
        $cart = \App\Models\Cart::where('user_id', \Auth::id())->where('status', 'active')->first();
        $count = $cart ? $cart->items()->count() : 0;
        return response()->json(['count' => $count]);
    }

    public function index(): View
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active'],
            ['total' => 0]
        );
        
        return view('cart.index', compact('cart'));
    }

    /**
     * Agrega un producto al carrito con validación de stock y manejo de concurrencia.
     */
    public function addItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            \DB::transaction(function () use ($validated, $request) {
                $product = Product::lockForUpdate()->findOrFail($validated['product_id']);
                if ($product->stock < $validated['quantity']) {
                    throw new \Exception('No hay suficiente stock disponible.');
                }
                $cart = Cart::firstOrCreate(
                    ['user_id' => \Auth::id(), 'status' => 'active'],
                    ['total' => 0]
                );
                $cartItem = $cart->items()->where('product_id', $product->id)->first();
                if ($cartItem) {
                    $newQuantity = $cartItem->quantity + $validated['quantity'];
                    if ($newQuantity > $product->stock) {
                        throw new \Exception('No hay suficiente stock disponible.');
                    }
                    $cartItem->update(['quantity' => $newQuantity]);
                } else {
                    $cart->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $validated['quantity'],
                        'price' => $product->price
                    ]);
                }
            });
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }

        $cart = Cart::where('user_id', \Auth::id())->where('status', 'active')->first();
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            $count = $cart ? $cart->items()->count() : 0;
            return response()->json([
                'success' => true,
                'message' => 'Producto agregado al carrito exitosamente.',
                'count' => $count
            ]);
        }
        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito exitosamente.');
    }

    public function updateItem(Request $request, $itemId): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        $cartItem = $cart->items()->findOrFail($itemId);
        
        if ($cartItem->product->stock < $validated['quantity']) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Carrito actualizado exitosamente.');
    }

    /**
     * Elimina un producto del carrito y elimina el carrito si queda vacío.
     */
    public function removeItem($itemId): RedirectResponse
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        $cart->items()->findOrFail($itemId)->delete();
        if ($cart->items()->count() === 0) {
            $cart->delete();
        }
        return back()->with('success', 'Producto eliminado del carrito exitosamente.');
    }

    /**
     * Vacía el carrito y lo elimina si queda sin productos.
     */
    public function clear(): RedirectResponse
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        $cart->items()->delete();
        $cart->updateTotal();
        if ($cart->items()->count() === 0) {
            $cart->delete();
        }
        return back()->with('success', 'Carrito vaciado exitosamente.');
    }
}