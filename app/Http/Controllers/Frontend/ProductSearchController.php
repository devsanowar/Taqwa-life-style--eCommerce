<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Product::query()->where('status', 1);

        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->latest()->get();

        return view('frontend.products.search', compact('products'));
    }


    public function searchSuggest(Request $request)
    {
        $products = Product::with('primaryImage')
            ->where('name', 'like', '%' . $request->keyword . '%')
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'final_price' => $product->final_price,
                    'primary_image_path' => $product->primaryImage->path ?? null,
                ];
            });

        return response()->json($products);
    }
}