<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('product_variants')->get();

        return view('dashboard.products.index', compact('products'));

    }

    
    public function create()
    {       
        $categories = Category::where('is_active', 1)->get();
        $variants = Variant::with('variantOptions')->get();
        return view('dashboard.products.create',data: compact('categories','variants'));

    }
public function store(Request $request)
{

$request->validate([
     'type' => 'required|in:simple,variable',

    'variations' => 'required_if:type,variable|array|min:1',
    'variations.*.sku' => 'required|string',
    'variations.*.price' => 'required|numeric|min:0',
    'variations.*.stock' => 'required|integer|min:0',
    'variations.*.name.en' => 'required|string',
    'variations.*.name.ar' => 'nullable|string',


    'name' => 'required|array',
    'name.ar' => 'required|string|max:255',
    'name.en' => 'required|string|max:255',

    'category_id' => 'required|exists:categories,id',
    'is_active' => 'required|boolean',
    'image' => 'nullable|image',
    'sku' => 'nullable|string|unique:products,sku',
]);

    
    $path = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;

$product = Product::create([
    'type' => $request->type,
    'name' => $request->name,
    'category_id' => $request->category_id,
    'description'=> $request->description,
    'is_active' => $request->is_active,
    'image' => $path,
    'sku' => $request->sku,
    'price' => $request->price,
    'stock' => $request->stock,
]);

if ($request->type === 'variable') {
    foreach ($request->variations as $variation) {
        // 1️⃣ إنشاء الـ ProductVariant
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'sku'        => $variation['sku'],
            'name'       => $variation['name'],
            'price'      => $variation['price'],
            'stock'      => $variation['stock'],
            'is_active'  => 1,
        ]);

        if (isset($variation['variant_values'])) {
            $variantOptionIds = array_map(fn($v) => $v['variant_option_id'], $variation['variant_values']);
            $variant->variantOptions()->sync($variantOptionIds);
        }
    }
}


    return redirect()
        ->route('dashboard.products.index')
        ->with('success', 'Product created successfully');
}

    public function show(Product $product)
    {
        return view('dashboard.products.show',compact('product'));
    }
    public function edit(Product $product)
    { 
        $categories = Category::all();
        return view('dashboard.products.edit',compact('product','categories'));

    }
    public function update(ProductUpdateRequest $request,Product $product )
    {
        
if ($request->hasFile('image')) {
    $data['image'] = $request->file('image')->store('products', 'public');
}

if(isset($data['description'])){
    $data['description'] = json_encode($data['description']);
}

$product->update($data);
if ($product->type === 'variable' && $request->has('variations')) {
    foreach ($request->variations as $variation) {
        $productVariant = ProductVariant::find($variation['id']);

        if ($productVariant) {
            $productVariant->update([
                'sku' => $variation['sku'],
                'name' => $variation['name'],
                'price' => $variation['price'],
                'stock' => $variation['stock'],
                'is_active' => $variation['is_active'] ?? 1,
            ]);

            $productVariant->variantOptions()->sync($variation['variant_option_ids'] ?? []);
        }
    }
}

return redirect()
        ->route('dashboard.products.index')
        ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.products.index');

    }
}
