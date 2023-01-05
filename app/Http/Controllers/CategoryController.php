<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('categories', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $categories = $category->children()->get();
//        return view('categories', compact('categories'));
        return CategoryResource::make($categories);

    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::create($request->all());
        return redirect()->route('categories.index');
    }
//
//    public function update(Request $request, Category $category)
//    {
//        $this->validate($request, [
//            'name' => 'required|max:255',
//            'parent_id' => 'nullable|exists:categories,id',
//        ]);
//
//        $category->update($request->all());
//        return redirect()->route('categories.index');
//    }
//
//    public function destroy(Category $category)
//    {
//        $category->delete();
//        return redirect()->route('categories.index');
//    }
}
