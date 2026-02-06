<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('parent')->latest()->get();
        return view('admin.layouts.pages.product.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.layouts.pages.product.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image',
            'status' => 'required'
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = ImageHelper::upload($request->file('image'), 'uploads/product_categories', 800, 90);
        }

        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'image' => $image
        ]);

        return response()->json(['status' => 'success', 'message' => 'Category Created']);
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        $categories = ProductCategory::where('id', '!=', $id)->get();
        return view('admin.layouts.pages.product.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:product_categories,id'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Updated',
            'actionUrl' => route('admin.product.category.index')
        ]);
    }

    public function destroy($id)
    {
        ProductCategory::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Category Deleted']);
    }
}