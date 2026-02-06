<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use Illuminate\Support\Facades\File;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'author')->latest()->get();
        return view('admin.layouts.pages.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = PostCategory::all();
        return view('admin.layouts.pages.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:post_categories,id',
            'description' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = ImageHelper::upload($request->file('thumbnail'), 'uploads/post_images', 800, 90);
        }

        // Create Post
        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'excerpt' => $request->excerpt,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'status' => $request->status ?? 1,
            'user_id' => auth()->id(),
        ]);

        // SEO (optional)
        $post->seo()->create([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully!'
        ]);
    }




    public function edit($id)
    {
        $post = Post::with('seo')->findOrFail($id); // eager load seo
        $categories = PostCategory::all();
        return view('admin.layouts.pages.posts.edit', compact('post', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:post_categories,id',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->excerpt = $request->excerpt;
        $post->description = $request->description;
        $post->status = $request->status;


        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && file_exists(public_path($post->thumbnail))) {
                unlink(public_path($post->thumbnail));
            }

            $image = $request->file('thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/post_images'), $filename);

            $post->thumbnail = 'uploads/post_images/' . $filename;
        }

        $post->save();


        $post->seo()->updateOrCreate(
            [],
            [
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
            ]
        );

        return redirect()
            ->route('admin.post.index')
            ->with('success', 'Post updated successfully.');
    }




    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Old image delete
        if ($post->thumbnail && file_exists(public_path($post->thumbnail))) {
            unlink(public_path($post->thumbnail));
        }

        if ($post->seo) {
            $post->seo()->delete();
        }

        $post->delete();

        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully!');
    }
}