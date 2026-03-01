<?php

namespace App\Http\Controllers;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with(['product'])
            ->get();

        return view('cart', compact('cartItems'));
    }

   public function add(Request $request)
{
    if (!$request->product_id) {
        return back()->with('error', 'Product ID is required.');
    }

    $product = Product::findOrFail($request->product_id);

    $variant = null;
    if ($request->product_variant_id) {
        $variant = ProductVariant::findOrFail($request->product_variant_id);
    }

    $price = $variant ? $variant->price : $product->price;

    $cartItem = CartItem::where('user_id', Auth::id())
        ->where('product_id', $product->id)
        ->where('product_variant_id', $variant?->id)
        ->first();

    if ($cartItem) {
        $cartItem->increment('quantity');
    } else {
        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'price' => $price,
            'quantity' => 1
        ]);
    }

    return redirect()->route('cart.index');
}

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return back();
    }
    
}
