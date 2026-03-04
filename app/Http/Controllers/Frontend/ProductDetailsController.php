<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductDetailsController extends Controller
{
    public function productDetails($slug)
    {

        $productDetail = Product::with([
            'category',
            'brand',
            'images',
            'primaryImage',
        ])->where('slug', $slug)->where('status', 1)->firstOrFail();



        $relatedProducts = Product::with('images', 'primaryImage')
            ->where('category_id', $productDetail->category_id)
            ->where('id', '!=', $productDetail->id)
            ->where('status', 1)
            ->take(4)
            ->get();

        $categories = ProductCategory::whereNull('parent_id')
            ->where('status', 1)
            ->with(['children.children', 'products']) // load children recursively
            ->get();

        return view('website.layouts.pages.product_details', compact('productDetail', 'relatedProducts', 'categories'));
    }
}
