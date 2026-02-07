<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Attribute;
use App\Helpers\ImageHelper;
use App\Models\VariantValue;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
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
            'prices' => 'nullable|array',
            'prices.*' => 'nullable|numeric|min:0',
            'color_images' => 'nullable|array',
            'color_images.*' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function() use($request){
            $variant = ProductVariant::create([
                'product_id' => $request->product_id,
                'sku' => $request->sku,
                'price_override' => $request->price_override,
                'status' => $request->status ?? 1,
            ]);

            // Prices
            if($request->prices){
                foreach($request->prices as $value_id => $price){
                    if($price === null || $price === '') continue;

                    $attrValue = AttributeValue::find($value_id);

                    VariantValue::updateOrCreate([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $value_id
                    ],[
                        'attribute_id' => $attrValue->attribute_id,
                        'attribute_value_id' => $value_id
                    ]);

                    DB::table('variant_price_values')->updateOrInsert(
                        ['variant_id'=>$variant->id,'attribute_value_id'=>$value_id],
                        ['price'=>$price]
                    );
                }
            }

            // Color images
            if($request->color_images){
                foreach($request->color_images as $value_id => $file){
                    if(!$file) continue;
                    $attrValue = AttributeValue::find($value_id);

                    $imagePath = ImageHelper::upload($file, 'uploads/variant_colors', 800, 90);

                    VariantValue::updateOrCreate([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $value_id
                    ],[
                        'attribute_id' => $attrValue->attribute_id,
                        'attribute_value_id' => $value_id
                    ]);

                    DB::table('variant_color_images')->updateOrInsert(
                        ['variant_id'=>$variant->id,'attribute_value_id'=>$value_id],
                        ['image_path'=>$imagePath]
                    );
                }
            }
        });

        return response()->json(['status'=>'success','message'=>'Variant created successfully']);
    }




    public function editAttribute($id)
    {
        $variant = ProductVariant::with(['values','color_images'])->findOrFail($id);
        $products = Product::all();
        $attributes = Attribute::with('values')->get();

        $prices = DB::table('variant_price_values')->where('variant_id',$variant->id)
                    ->pluck('price','attribute_value_id')->toArray();
        $colorImages = DB::table('variant_color_images')->where('variant_id',$variant->id)
                    ->pluck('image_path','attribute_value_id')->toArray();

        return view('admin.layouts.pages.product.variant.edit', compact('variant','products','attributes','prices','colorImages'));
    }

    public function updateAttribute(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $request->validate([
            'sku' => 'required|unique:product_variants,sku,'.$variant->id,
            'prices' => 'nullable|array',
            'prices.*' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function() use($request,$variant){

            $variant->update([
                'sku' => $request->sku,
                'product_id' => $request->product_id,
                'price_override' => $request->price_override,
                'status' => $request->status ?? 1,
            ]);

            // Delete old entries
            DB::table('variant_price_values')->where('variant_id',$variant->id)->delete();
            DB::table('variant_color_images')->where('variant_id',$variant->id)->delete();
            VariantValue::where('variant_id',$variant->id)->delete();

            // Prices
            if($request->prices){
                foreach($request->prices as $value_id => $price){
                    if($price === null || $price === '') continue;
                    $attrValue = AttributeValue::find($value_id);

                    VariantValue::create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $attrValue->attribute_id,
                        'attribute_value_id' => $value_id
                    ]);

                    DB::table('variant_price_values')->insert([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $value_id,
                        'price' => $price
                    ]);
                }
            }

            // Color images
            if($request->color_images){
                foreach($request->color_images as $value_id => $file){
                    if(!$file) continue;
                    $attrValue = AttributeValue::find($value_id);

                    $imagePath = ImageHelper::upload($file, 'uploads/variant_colors', 800, 90);

                    VariantValue::updateOrCreate([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $value_id
                    ],[
                        'attribute_id' => $attrValue->attribute_id,
                        'attribute_value_id' => $value_id
                    ]);

                    DB::table('variant_color_images')->insert([
                        'variant_id'=>$variant->id,
                        'attribute_value_id'=>$value_id,
                        'image_path'=>$imagePath
                    ]);
                }
            }

        });

        return response()->json(['status'=>'success','message'=>'Variant updated successfully']);
    }

    public function destroyAttribute($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Variant deleted successfully'
        ]);
    }
}
