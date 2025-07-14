<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Auth::user()->isAdmin()
            ? Order::with(['user', 'items.product'])->latest()->paginate(10)
            : Auth::user()->orders()->with(['items.product'])->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function history(): View
    {
        $orders = Auth::user()->orders()->with(['items.product'])->latest()->paginate(10);
        return view('orders.history', compact('orders'));
    }

    public function show(Order $order): View
    {
        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function create(): View
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'El carrito está vacío.');
        }

        $paymentMethods = [
            'card' => 'Tarjeta',
            'cash' => 'Efectivo',
            'wompi' => 'Wompi',
        ];

        return view('orders.create', compact('cart', 'paymentMethods'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'El carrito está vacío.');
        }

        $rules = [
            'delivery_method' => 'required|in:delivery,pickup',
            'phone' => 'required|string',
            'payment_method' => 'required|in:card,cash,wompi'
        ];
        // Si es efectivo, permitir comprobante
        if ($request->input('payment_method') === 'cash') {
            $rules['payment_proof'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096';
        }

        if ($request->input('delivery_method') === 'delivery') {
            $rules = array_merge($rules, [
                'address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
            ]);
        }

        $validated = $request->validate($rules);
        // Guardar comprobante si lo hay
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        try {
            DB::beginTransaction();

            // Verificar stock antes de crear la orden
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stock insuficiente para {$item->product->name}");
                }
            }

            $orderData = [
                'user_id' => Auth::id(),
                'total' => $cart->total,
                'status' => 'pending',
                'shipping_phone' => $validated['phone'],
                'payment_method' => $validated['payment_method'],
                'delivery_method' => $validated['delivery_method']
            ];

            if ($validated['delivery_method'] === 'delivery') {
                $orderData = array_merge($orderData, [
                    'shipping_address' => $validated['address'],
                    'shipping_city' => $validated['city'],
                    'shipping_state' => $validated['state']
                ]);
            }

            // Agregar comprobante si existe
        if ($paymentProofPath) {
            $orderData['payment_proof'] = $paymentProofPath;
        }
        $order = Order::create($orderData);

            // Crear items de la orden y actualizar stock
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Marcar el carrito como procesado
            $cart->update(['status' => 'processed']);

            DB::commit();

            // Notificar al usuario
            \Auth::user()->notify(new \App\Notifications\OrderCreatedNotification($order));

            // Si el método de pago es Wompi, redirigir al widget embebido
            if ($validated['payment_method'] === 'wompi') {
                return redirect()->route('wompi.widget', $order);
            }

            // Redirigir a la vista de pedidos
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pedido realizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Estado del pedido actualizado exitosamente.');
    }
}