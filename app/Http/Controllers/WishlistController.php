<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth.custom');
    // }

    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return view('wishlist', compact('wishlist'));
    }

    public function toggle(Request $request)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
        ->where('product_id', $request->product_id)
        ->where('product_variant_id', $request->product_variant_id ?? null)
        ->first();

    if ($wishlist) {
        $wishlist->delete();
    } else {
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id ?? null
        ]);
    }

    return redirect('wishlist');
}
};
