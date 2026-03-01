<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantsController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with(['product','variantOptions'])->get();
        // dd($variants);
        return view('dashboard.productvariants.index', compact('variants'));
    }

    public function create()
    {
        
         $products = Product::all();
            $variants = ProductVariant::with(['product','variantOptions'])->get();


    return view(
        'dashboard.productvariants.create',
        compact('products', 'variants')
    );
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'sku' => 'required|unique:product_variants,sku',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'is_active' => 'required|boolean',
            'variant_options' => 'nullable|array',
        ]);
        

        $variant = ProductVariant::create([
            'sku' => $request->sku,
            'name' => $request->name,
            'description' => $request->description,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => $request->is_active,
            'image' => $request->image ?? null,
        ]);

        if ($request->variant_options) {
            $variant->variantOptions()->sync($request->variant_options);
            
        }

        return redirect()->route('dashboard.productvariants.index')
            ->with('success', 'Product Variant added successfully!');
    }

    public function edit($id)
    {
        $variant = ProductVariant::with('variantOptions')->findOrFail($id);
        $products = Product::all();
        $options = VariantOption::all();
        return view('dashboard.productvariants.edit', compact('variant','products','options'));
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $request->validate([
            'sku' => 'required|unique:product_variants,sku,'.$id,
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'is_active' => 'required|boolean',
            'variant_options' => 'nullable|array',
        ]);

        $variant->update([
            'sku' => $request->sku,
            'name' => $request->name,
            'description' => $request->description,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => $request->is_active,
            'image' => $request->image ?? $variant->image,
        ]);

        if ($request->variant_options) {
            $variant->variantOptions()->sync($request->variant_options);
        }

        return redirect()->route('dashboard.productvariants.index')
            ->with('success', 'Product Variant updated successfully!');
    }

    
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return redirect()->route('dashboard.productvariants.index')
        ->with('success', 'Product Variant deleted successfully!');
    }
}
