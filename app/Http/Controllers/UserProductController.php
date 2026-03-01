<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function index() {
    $products = Product::all();
    return view('products.index', compact('products'));
}

}
