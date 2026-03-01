<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('ordered_at', 'desc')
                       ->get();

        return view('orders.index', compact('orders'));
    }

   public function show(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    $order->load('ordered_items.product', 'ordered_items.productVariant');

    return view('orders.show', compact('order'));
}

}
