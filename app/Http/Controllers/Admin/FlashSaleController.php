<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\FlashSale;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;

class FlashSaleController extends Controller
{
    public function index()
    {
        $sales = FlashSale::withCount('items')->latest()->get();
        return view('admin.layouts.pages.product.flash_sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::select('id', 'name')->get();
        $variants = ProductVariant::select('id', 'sku')->get();
        return view('admin.layouts.pages.product.flash_sales.create', compact('products', 'variants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at'
        ]);

        FlashSale::create($request->only([
            'title',
            'start_at',
            'end_at',
            'auto_start',
            'auto_expire'
        ]));

        return response()->json(['status' => 'success', 'message' => 'Flash sale created']);
    }


    public function edit($id)
    {
        $flash = FlashSale::findOrFail($id);
        return view('admin.layouts.pages.product.flash_sales.edit', compact('flash'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'start_at' => 'required|date',
            'end_at'   => 'required|date|after:start_at',
        ]);

        $flash = FlashSale::findOrFail($id);

        $flash->update([
            'title'       => $request->title,
            'start_at'    => $request->start_at,
            'end_at'      => $request->end_at,
            'auto_start' => $request->auto_start,
            'auto_expire' => $request->auto_expire,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Flash sale updated successfully!'
        ]);
    }


    public function destroy($id)
    {
        FlashSale::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Flash sale deleted']);
    }
}