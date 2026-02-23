<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/product_categories'), $imageName);
        }

        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'image' => $imageName,
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

        if ($request->hasFile('image')) {

            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }


            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $imagePath = 'uploads/product_categories/' . $imageName;
            $image->move(public_path('uploads/product_categories'), $imageName);

            $category->image = $imagePath;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
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
