<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        // dd($categories);
        return view('dashboard.categories.index',compact('categories'));
    }
    public function create()
    {
        return view('dashboard.categories.create');

    }

    public function store(CreateRequest $request)
    {
        // $date = $request->validated();
        // $file =$date->file('image');
        // $originalName = $file->getClientOriginalName();
        // $fileName = time() . '_' . $originalName;
        // $imagePath =$file->storeAs('categories', $fileName ,'public');
        // $date['image'] =$imagePath;
        $data = $request->validated();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')
            ->store('categories', 'public');
    }

    Category::create($data);

    return redirect()
        ->route('dashboard.categories.index')
        ->with('success', 'Category created successfully');
    }

    public function show(Category $category)
    {
        return view('dashboard.categories.show',compact('category'));

    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',compact('category'));
    }

    public function update(UpdateCategory $request, Category $category)
    {
        $data = $request->validated();

    if ($request->hasFile('image')) {

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $data['image'] = $request->file('image')
            ->store('blogs', 'public');
    }

    $category->update($data);

    return redirect()
        ->route('dashboard.categories.index')
        ->with('success', 'Category updated successfully.');
    }

    
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('dashboard.categories.index');
    }
}
