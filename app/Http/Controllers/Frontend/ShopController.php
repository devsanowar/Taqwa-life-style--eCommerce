<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shopPage(Request $request)
{
    $productsQuery = Product::query()
        ->with(['category', 'brand:id,name', 'primaryImage', 'images'])
        ->where('status', 1);

    // price filters (আপনার existing)
    if ($request->filled('min_price')) {
        $productsQuery->where('base_price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $productsQuery->where('base_price', '<=', $request->max_price);
    }

    // category filter (NEW)
    if ($request->filled('category')) {
        $category = ProductCategory::query()
            ->where('status', 1)
            ->where('slug', $request->category)
            ->firstOrFail();

        $catIds = $category->descendantsAndSelfIds();

        $productsQuery->whereIn('category_id', $catIds);
    }

    $products = $productsQuery
        ->latest()
        ->paginate(16)
        ->withQueryString();

    $categories = ProductCategory::whereNull('parent_id')
        ->where('status', 1)
        ->with(['children.children', 'products'])
        ->get();

    $recentProducts = Product::query()
        ->where('status', 1)
        ->with(['primaryImage', 'images'])
        ->latest()
        ->take(4)
        ->get();

    if ($request->ajax()) {
        return response()->json([
            'products' => view('website.layouts.pages.shop.partials.product_grid', compact('products'))->render(),
            'pagination' => view('website.layouts.pages.shop.partials.pagination', ['paginator' => $products])->render(),
        ]);
    }

    return view('website.layouts.pages.shop.shop', compact('products', 'categories', 'recentProducts'));
}


}
