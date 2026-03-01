<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use App\Models\VariantOption;
use Illuminate\Http\Request;

class VariantOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = VariantOption::with('variant')->get();
        return view('dashboard.variantoptions.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $variants = Variant::all();
        return view('dashboard.variantoptions.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:variants,id',
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
        ]);

        VariantOption::create([
            'variant_id' => $request->variant_id,
            'name' => [
                'en' => $request->name['en'],
                'ar' => $request->name['ar'],
            ],
        ]);

        return redirect()->route('dashboard.variant-options.index')
            ->with('success','Option created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    VariantOption::findOrFail($id)->delete();
    return response()->json(['success' => true]);
}

}
