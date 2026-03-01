<?php
namespace App\Http\Controllers;


use App\Models\Order;
use Illuminate\Http\Request;

use App\Models\OrderProduct;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with(['product','variant'])
            ->get();

        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string'
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())
            ->with(['product','variant'])
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * (
                $item->variant
                    ? $item->variant->price
                    : $item->product->price
            );
        });

        // ✅ إنشاء Order
        $order = Order::create([
            'user_id'      => auth()->id(),
            'total_amount' => $total,
            'status'       => 'pending',
            'address'      => $request->address,
            'ordered_at'   => now(),
        ]);

        // ✅ إنشاء Order Products
        foreach ($cartItems as $item) {
            OrderProduct::create([
                'order_id'           => $order->id,
                'product_id'         => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'quantity'           => $item->quantity,
                'total_price'        => $item->quantity * (
                    $item->variant
                        ? $item->variant->price
                        : $item->product->price
                ),
            ]);
        }

        // ✅ تفريغ الكارت
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Order placed successfully 🎉');
    }
}
