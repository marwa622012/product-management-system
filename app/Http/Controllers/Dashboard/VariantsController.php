<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use App\Models\VariantOption;
use Illuminate\Http\Request;

class VariantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        
        // $variants = Variant::with('VariantOptions')->get();
        $variants = Variant::with('variantOptions')
    ->has('variantOptions')
    ->get();

        
        return view('dashboard.variants.index',compact('variants'));
    }

    public function create()
    {
        return view('dasboard.variant.create');
    }
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|array',
        'name.en' => 'required|string',
        'name.ar' => 'required|string',

        'options' => 'nullable|array',
        'options.*.en' => 'required|string',
        'options.*.ar' => 'required|string',
    ]);

    $variant = Variant::create([
        'name' => $request->name
    ]);
if (isset($request->options)) {
    foreach ($request->options as $option) {
        VariantOption::create([
            'variant_id' => $variant->id,
            'name' => [
                'en' => $option['en'],
                'ar' => $option['ar'],
            ]
        ]);
    }
}

    return redirect()
        ->route('dashboard.variants.index')
        ->with('success', 'Variant added successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $variant = Variant::with('VariantOptions')->findOrFail($id);
        return view('dashboard.variants.show',compact('variant'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $variant = Variant::findOrFail($id);
    return view('dashboard.variants.edit', compact('variant'));

    }
//     public function update(Request $request, string $id)
// {
    
//     $variant = Variant::findOrFail($id);

//     $request->validate([
//         'name.en' => 'sometimes|required|string',
//         'name.ar' => 'sometimes|required|string',

//         'options' => 'nullable|array',
//         'options.*.id' => 'required|exists:variant_options,id',
//         'options.*.en' => 'required|string',
//         'options.*.ar' => 'required|string',

//         'new_options' => 'nullable|array',
//         'new_options.*.en' => 'required|string',
//         'new_options.*.ar' => 'required|string',
//     ]);

//     if ($request->filled('name')) {
//     $variant->update([
//         'name' => $request->name
//     ]);
// }


//     if ($request->filled('options')) {
//         foreach ($request->options as $option) {
//             $variant->variantOptions()
//                 ->where('id', $option['id'])
//                 ->update([
//                     'name' => [
//                         'name_en' => $option['en'],
//                         'name_ar' => $option['ar'],
//                     ]
//                 ]);
//         }
//     }

//     $existingIds = collect($request->options ?? [])
//         ->pluck('id')
//         ->filter()
//         ->toArray();

//     $variant->variantOptions()
//         ->whereNotIn('id', $existingIds)
//         ->delete();

//     // 4️⃣ Create new options
//     if ($request->filled('new_options')) {
//         foreach ($request->new_options as $option) {
//             $variant->variantOptions()->create([
//                 'name' => [
//                     'en' => $option['en'],
//                     'ar' => $option['ar'],
//                 ]
//             ]);
//         }

//     }

//     return redirect()
//         ->route('dashboard.variants.index')
//         ->with('success', 'Variant updated successfully!');
// }
public function update(Request $request, string $id)
{
    $variant = Variant::findOrFail($id);

    // 1️⃣ Validation
    $request->validate([
        'name.en' => 'sometimes|required|string',
        'name.ar' => 'sometimes|required|string',

        'options' => 'nullable|array',
        'options.*.id' => 'sometimes|exists:variant_options,id',
        'options.*.name_en' => 'required|string',
        'options.*.name_ar' => 'required|string',

        'new_options' => 'nullable|array',
        'new_options.*.en' => 'required|string',
        'new_options.*.ar' => 'required|string',
    ]);

    // 2️⃣ Update Variant name if موجود
    if ($request->filled('name')) {
        $variant->update([
            'name' => $request->name
        ]);
    }

    // 3️⃣ Update existing options
    if ($request->filled('options')) {
        foreach ($request->options as $optionData) {
            if (!isset($optionData['id'])) continue;

            $option = $variant->variantOptions()
                ->where('id', $optionData['id'])
                ->first();

            if ($option) {
                $option->name = [
                    'en' => $optionData['name_en'],
                    'ar' => $optionData['name_ar'],
                ];
                $option->save();
            }
        }
    }

    // 4️⃣ Delete options اللي اتحذفت من الصفحة
    $sentOptionIds = collect($request->options ?? [])
        ->pluck('id')
        ->filter()
        ->toArray();

    $variant->variantOptions()
        ->whereNotIn('id', $sentOptionIds)
        ->delete();

    // 5️⃣ Create new options
    if ($request->filled('new_options')) {
        foreach ($request->new_options as $option) {
            $variant->variantOptions()->create([
                'name' => [
                    'en' => $option['en'],
                    'ar' => $option['ar'],
                ]
            ]);
        }
    }

    // 6️⃣ Redirect with success
    return redirect()
        ->route('dashboard.variants.index')
        ->with('success', 'Variant & options updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = Variant::findOrFail($id);
        $variant->delete();

    return redirect()->route('dashboard.variants.index')
        ->with('success', 'Variant deleted successfully!');
    }
}
