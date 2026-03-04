<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductReview;
use App\Models\Slider;


class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

        $products = Product::with([
            'category',
            'brand:id,name',
            'primaryImage'
        ])
            ->where('status', 1)
            ->latest()
            ->take(10)
            ->get();

        $featuredProducts = Product::select(['id', 'category_id', 'brand_id', 'name', 'slug', 'base_price', 'discount_type', 'discount_value'])
            ->with([
                'category:id,name',
                'brand:id,name',
                'primaryImage'
            ])
            ->where('status', 1)
            ->where('featured', 1)
            ->latest()
            ->take(10)
            ->get();

        $flashSallingProducts = Product::select(['id', 'category_id', 'brand_id', 'name', 'slug', 'base_price', 'discount_type', 'discount_value'])
            ->with([
                'category:id,name',
                'brand:id,name',
                'primaryImage'
            ])
            ->where('status', 1)
            ->where('flash_sale_enabled', 1)
            ->latest()
            ->take(10)
            ->get();


        // $categories = ProductCategory::where('status', 1)
        //     ->orderBy('sort_order', 'asc')
        //     ->get();

$homeCategories  = ProductCategory::where('status', 1)
    ->whereNotNull('parent_id')
    ->orderBy('sort_order','asc')
    ->get();





        $productReviews = ProductReview::where('status', 1)->latest()->get();

        $posts = Post::with(['category:id,post_category_name'])
            ->where('status', 1)
            ->latest()
            ->take(10)
            ->get();

        return view('website.layouts.pages.home', compact(
            'sliders',
            'homeCategories',
            'featuredProducts',
            'products',
            'flashSallingProducts',
            'productReviews',
            'posts'
        ));
    }
}
