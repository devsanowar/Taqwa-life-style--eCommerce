<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\FlashSale;
use Illuminate\Http\Request;
use App\Models\FlashSaleItem;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;

class FlashSaleItemController extends Controller
{
    // public function index(FlashSale $flash)
    // {
    //     $items = $flash->items()->with(['product','variant'])->get();
    //     return view('admin.layouts.pages.product.flash_sale_item.index', compact('flash','items'));
    // }

    public function index()
    {
        $flash = FlashSale::first();
        $items = FlashSaleItem::with([
            'flashSale',
            'product.primaryImage',
            'product.category',
            'product.brand',
            'variant'
        ])
        ->orderBy('priority')
        ->get();



        return view('admin.layouts.pages.product.flash_sale_item.index', compact('items','flash'));
    }

    public function create()
    {
        $products = Product::all();
        $flashSale = FlashSale::first();
        $variants = ProductVariant::with('product')->get();
        return view('admin.layouts.pages.product.flash_sale_item.create', compact('products','variants','flashSale'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'discount_type'  => 'required',
            'discount_value' => 'required|numeric|min:0',
        ]);

        if (!$request->product_id && !$request->variant_id) {
            return response()->json(['message'=>'Select product or variant'],422);
        }

        FlashSaleItem::create([
            'flash_sale_id' => $request->flash_sale_id,
            'product_id'    => $request->product_id,
            'variant_id'    => $request->variant_id,
            'discount_type' => $request->discount_type,
            'discount_value'=> $request->discount_value,
            'priority'      => $request->priority ?? 0,
        ]);

        return response()->json(['status'=>'success','message'=>'Item added']);
    }

    public function edit(FlashSale $flash, FlashSaleItem $item)
    {
        $products = Product::all();
        $variants = ProductVariant::with('product')->get();
        return view('admin.layouts.pages.product.flash_sale_item.edit', compact('flash','item','products','variants'));
    }

    public function update(Request $request, FlashSale $flash, FlashSaleItem $item)
    {
        $item->update($request->only([
            'product_id','variant_id','discount_type','discount_value','priority'
        ]));

        return response()->json(['status'=>'success','message'=>'Item updated']);
    }

    public function destroy(FlashSaleItem $item)
    {
        $item->delete();
        return response()->json(['status' => 'deleted']);
    }
}
