<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{

    public function index()
    {
        $reviews = ProductReview::with(['product'])->latest()->get();
        return view('admin.layouts.pages.product.review.index', compact('reviews'));
    }

    public function create()
    {
        $products = Product::where('status', 1)->latest()->get();
        return view('admin.layouts.pages.product.review.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|boolean',
        ]);

        ProductReview::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Review added successfully!'
        ]);
    }

    public function edit($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $products = Product::where('status', 1)->latest()->get();
        return view('admin.layouts.pages.product.review.edit', compact('productReview', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|boolean',
        ]);

        $productReview = ProductReview::findOrFail($id);
        $productReview->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Review updated successfully!',
            'actionUrl' => route('admin.product.review.index')
        ]);
    }

    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $productReview->delete();
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}