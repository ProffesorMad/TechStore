<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $items = $request->items;

        if (!$items || count($items) === 0) {
            return response()->json(['message' => 'Carrito vacío'], 400);
        }

        $total = collect($items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'status' => 'pending'
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return response()->json([
            'message' => 'Pedido creado correctamente',
            'order_id' => $order->id
        ]);
    }

    public function index()
    {
        return Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function show($id)
    {
        return Order::with('items.product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }

    // ADMIN
    public function adminIndex()
    {
        return Order::with('items.product', 'user')
            ->latest()
            ->get();
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Estado actualizado']);
    }
}
