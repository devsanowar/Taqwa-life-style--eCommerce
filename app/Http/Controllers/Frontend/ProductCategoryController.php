<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    public function index(Request $request)
    {
        $productsQuery = Product::query()
            ->where('status', 1)
            ->with(['category', 'brand:id,name', 'primaryImage', 'images']);

        if ($request->filled('category')) {
            $slug = $request->category;

            $productsQuery->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $products = $productsQuery->latest()->paginate(3)->withQueryString();

        $categories = ProductCategory::whereNull('parent_id')
            ->where('status', 1)
            ->with(['children.children', 'products'])
            ->get();

        return view('website.layouts.pages.category-products.category_products', compact('products', 'categories'));
    }

    public function category(Request $request, $slug)
    {
        $products = Product::query()
            ->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->where('status', 1)
            ->with(['category', 'brand:id,name', 'primaryImage', 'images'])
            ->latest()
            ->paginate(3)
            ->withQueryString();

        // AJAX response for sidebar click + pagination click
        if ($request->ajax()) {
            return response()->json([
                'products'      => view('website.layouts.pages.category-products.partials.product_grid', compact('products'))->render(),
                'pagination'    => view('website.layouts.pages.category-products.partials.pagination', ['paginator' => $products])->render(),
                'canonical_url' => route('products.index', ['category' => $slug]), // for pushState
            ]);
        }

        return redirect()->route('products.index', ['category' => $slug]);
    }

}
