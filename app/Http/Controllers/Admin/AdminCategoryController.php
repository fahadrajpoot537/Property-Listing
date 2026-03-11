<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('propertyTypes')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['success' => true, 'message' => 'Category created successfully']);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }

    public function destroy(Category $category)
    {
        if ($category->propertyTypes()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Category cannot be deleted because it has property types.'], 422);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
    }
}
