<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::with('parent')->get();
        return view('admin.layouts.pages.posts.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = PostCategory::whereNull('parent_id')->get();
        return view('admin.layouts.pages.posts.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_category_name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:post_categories,id',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        PostCategory::create([
            'post_category_name' => $request->post_category_name,
            'post_category_slug' => Str::slug($request->post_category_name),
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully added!',
        ]);
    }

    public function edit($id)
    {
        $category = PostCategory::findOrFail($id);

        $categories = PostCategory::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        return view('admin.layouts.pages.posts.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_category_name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:post_categories,id',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $category = PostCategory::findOrFail($id);

        $category->update([
            'post_category_name' => $request->post_category_name,
            'post_category_slug' => Str::slug($request->post_category_name),
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.post.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = PostCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Post Category deleted successfully!');
    }


}
