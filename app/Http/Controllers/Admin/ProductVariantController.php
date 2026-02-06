<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\VariantValue;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;

class ProductVariantController extends Controller
{

    public function index()
    {
        $variants = ProductVariant::with([
            'product',
            'values.attribute'
        ])->latest()->get();

        return view('admin.layouts.pages.product.variant.index', compact('variants'));
    }

    public function create()
    {
        $products = Product::latest()->get();
        $attributes = Attribute::with('values')->get();
        return view('admin.layouts.pages.product.variant.create', compact('products', 'attributes'));
    }

    public function storeAttribute(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'required|unique:product_variants,sku',
            'attributes' => 'required|array',
            'attributes.*' => 'required|array',
            'attributes.*.*' => 'exists:attribute_values,id',
        ]);

        // Save image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('variants','public');
        }

        $variant = ProductVariant::create([
            'product_id' => $request->product_id,
            'sku' => $request->sku,
            'price_override' => $request->price_override,
            'status' => $request->status ?? 1,
            'image_path' => $imagePath,
        ]);

        foreach($request->attributes as $attribute_id => $values){
            foreach($values as $value_id){
                VariantValue::create([
                    'variant_id' => $variant->id,
                    'attribute_id' => $attribute_id,
                    'attribute_value_id' => $value_id,
                ]);
            }
        }

        return response()->json([
            'status'=>'success',
            'message'=>'Variant created successfully'
        ]);
    }


    public function editAttribute($id)
    {
        // Logic to show the edit form for a product variant
    }

    public function updateAttribute(Request $request, $id)
    {
        // Logic to update a product variant
    }

    public function destroyAttribute($id)
    {
        // Logic to delete a product variant
    }
}