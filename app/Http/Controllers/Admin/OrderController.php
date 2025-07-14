<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $validSorts = ['id', 'name', 'total', 'status', 'created_at'];
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        if (!in_array($sort, $validSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }
        $orders = Order::orderBy($sort, $direction)->paginate(10)->appends($request->except('page'));
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        // Validación y creación básica
        $order = Order::create($request->all());
        return redirect()->route('admin.orders.index')->with('success', 'Orden creada correctamente.');
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('admin.orders.index')->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Orden eliminada correctamente.');
    }

    // Nuevo método para actualizar el estado de la orden
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string', // Ajusta la validación si es necesario
        ]);

        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Estado de la orden actualizado correctamente.');
    }
}
