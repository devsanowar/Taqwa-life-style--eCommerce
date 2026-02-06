<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
use App\Models\ProductBrand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with(['category', 'brand', 'primaryImage'])->latest()->paginate(10);
        return view('admin.layouts.pages.product.index', compact('products'));
    }

    public function create() {
        $categories = ProductCategory::where('status',1)->get();
        $brands = ProductBrand::where('status',1)->get();
        return view('admin.layouts.pages.product.create', compact('categories','brands'));
    }

    public function store(Request $request) {
        $request->validate([
            'category_id'=>'required|exists:product_categories,id',
            'name'=>'required|unique:products,name',
            'base_price'=>'required|numeric',
            'images.*'=>'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create([
            'category_id'=>$request->category_id,
            'brand_id'=>$request->brand_id,
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'short_description'=>$request->short_description,
            'long_description'=>$request->long_description,
            'base_price'=>$request->base_price,
            'discount_type'=>$request->discount_type,
            'discount_value'=>$request->discount_value,
            'featured'=>$request->featured ? 1 : 0,
            'status'=>$request->status,
            'flash_sale_enabled'=>$request->flash_sale_enabled ? 1 : 0
        ]);

        // Handle images
        if($request->hasFile('images')) {
            foreach($request->file('images') as $key => $img){
                $path = ImageHelper::upload($img, 'uploads/product_images', 800, 90);
                $product->images()->create([
                    'path' => $path,
                    'is_primary' => $key == 0 ? 1 : 0,
                    'sort_order' => $key
                ]);
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Product Created Successfully'
        ]);

    }

    public function edit($id) {
        $product = Product::with('images')->findOrFail($id);
        $categories = ProductCategory::where('status',1)->get();
        $brands = ProductBrand::where('status',1)->get();
        return view('admin.layouts.pages.product.edit', compact('product','categories','brands'));
    }



    public function update(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);


        $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|unique:products,name,' . $id,
            'base_price' => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'removed_images' => 'nullable|string',
        ]);


        $product->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'base_price' => $request->base_price,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'featured' => $request->filled('featured') ? 1 : 0,
            'status' => $request->status,
            'flash_sale_enabled' => $request->filled('flash_sale_enabled') ? 1 : 0,
        ]);


        if ($request->filled('removed_images')) {
            $ids = explode(',', $request->removed_images);

            foreach ($ids as $imgId) {
                $img = ProductImage::find($imgId);
                if ($img) {
                    ImageHelper::delete($img->path);
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            $start = $product->images()->count();

            foreach ($request->file('images') as $key => $img) {
                $path = ImageHelper::upload($img, 'uploads/product_images', 800, 90);

                $product->images()->create([
                    'path' => $path,
                    'is_primary' => ($start + $key) == 0 ? 1 : 0,
                    'sort_order' => $start + $key,
                ]);
            }
        }


        if($request->filled('primary_image')){
            $product->images()->update(['is_primary' => 0]);
            $primary = $product->images()->find($request->primary_image);
            if($primary) $primary->update(['is_primary' => 1]);
        } else {
            $first = $product->images()->first();
            if($first) $first->update(['is_primary' => 1]);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'product' => $product->load('images')
        ]);
    }



    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $img) {
            ImageHelper::delete($img->path);
            $img->delete();
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ]);
    }

}
