<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Attribute;
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

    public function storeVariant(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'required|unique:product_variants,sku',
            'prices' => 'nullable|array',
            'prices.*' => 'nullable|numeric|min:0',
            'color_images' => 'nullable|array',
            'color_images.*' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $variant = ProductVariant::create([
                'product_id' => $request->product_id,
                'sku' => $request->sku,
                'price_override' => $request->price_override,
                'status' => $request->status ?? 1,
            ]);

            // Prices
            if ($request->prices) {
                foreach ($request->prices as $value_id => $price) {
                    if ($price === null || $price === '') continue;

                    $attrValue = AttributeValue::find($value_id);

                    VariantValue::updateOrCreate([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $value_id
                    ], [
                        'attribute_id' => $attrValue->attribute_id,
                        'attribute_value_id' => $value_id
                    ]);

                    DB::table('variant_price_values')->updateOrInsert(
                        ['variant_id' => $variant->id, 'attribute_value_id' => $value_id],
                        ['price' => $price]
                    );
                }
            }

            // Color images
            if ($request->hasFile('color_images')) {

                foreach ($request->file('color_images') as $value_id => $file) {

                    if (!$file) continue;

                    $attrValue = AttributeValue::find($value_id);
                    if (!$attrValue) continue;
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/variant_colors');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);

                    $imagePath = 'uploads/variant_colors/' . $filename;

                    VariantValue::updateOrCreate([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $value_id
                    ], [
                        'attribute_id' => $attrValue->attribute_id,
                    ]);

                    DB::table('variant_color_images')->updateOrInsert(
                        [
                            'variant_id' => $variant->id,
                            'attribute_value_id' => $value_id
                        ],
                        [
                            'image_path' => $imagePath,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        });

        return response()->json(['status' => 'success', 'message' => 'Variant created successfully']);
    }




    public function editVariant($id)
    {
        $variant = ProductVariant::with(['values', 'colorImages'])->findOrFail($id);
        $products = Product::all();
        $attributes = Attribute::with('values')->get();

        $prices = DB::table('variant_price_values')->where('variant_id', $variant->id)
            ->pluck('price', 'attribute_value_id')->toArray();
        $colorImages = DB::table('variant_color_images')->where('variant_id', $variant->id)
            ->pluck('image_path', 'attribute_value_id')->toArray();

        return view('admin.layouts.pages.product.variant.edit', compact('variant', 'products', 'attributes', 'prices', 'colorImages'));
    }

    public function updateVariant(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $request->validate([
            'sku' => 'required|unique:product_variants,sku,' . $variant->id,
            'prices' => 'nullable|array',
            'prices.*' => 'nullable|numeric|min:0',
            'color_images' => 'nullable|array',
            'color_images.*' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $variant) {

            $variant->update([
                'sku' => $request->sku,
                'price_override' => $request->price_override,
                'status' => $request->status ?? 1,
            ]);

            /* =======================
           PRICE UPDATE
        ======================= */

            $existingPrices = DB::table('variant_price_values')
                ->where('variant_id', $variant->id)
                ->pluck('price', 'attribute_value_id')
                ->toArray();

            if ($request->prices) {
                foreach ($request->prices as $value_id => $price) {

                    // remove if unchecked
                    if ($price === null || $price === '') {
                        DB::table('variant_price_values')
                            ->where('variant_id', $variant->id)
                            ->where('attribute_value_id', $value_id)
                            ->delete();

                        VariantValue::where('variant_id', $variant->id)
                            ->where('attribute_value_id', $value_id)
                            ->delete();

                        continue;
                    }

                    $attrValue = AttributeValue::find($value_id);

                    VariantValue::updateOrCreate(
                        [
                            'variant_id' => $variant->id,
                            'attribute_value_id' => $value_id
                        ],
                        ['attribute_id' => $attrValue->attribute_id]
                    );

                    DB::table('variant_price_values')->updateOrInsert(
                        ['variant_id' => $variant->id, 'attribute_value_id' => $value_id],
                        ['price' => $price]
                    );
                }
            }

            /* =======================
   COLOR IMAGE UPDATE
======================= */

            if ($request->hasFile('color_images')) {

                foreach ($request->file('color_images') as $value_id => $file) {

                    if (!$file) continue;

                    // Get old image
                    $old = DB::table('variant_color_images')
                        ->where('variant_id', $variant->id)
                        ->where('attribute_value_id', $value_id)
                        ->first();

                    // Delete old image if exists
                    if ($old && file_exists(public_path($old->image_path))) {
                        unlink(public_path($old->image_path));
                    }

                    // Get attribute value
                    $attrValue = AttributeValue::find($value_id);
                    if (!$attrValue) continue;

                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Set destination path
                    $destinationPath = public_path('uploads/variant_colors');

                    // Create folder if not exists
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    // Move file
                    $file->move($destinationPath, $filename);

                    // DB path
                    $imagePath = 'uploads/variant_colors/' . $filename;

                    // Update pivot table
                    VariantValue::updateOrCreate(
                        [
                            'variant_id' => $variant->id,
                            'attribute_value_id' => $value_id
                        ],
                        [
                            'attribute_id' => $attrValue->attribute_id
                        ]
                    );

                    // Update image table
                    DB::table('variant_color_images')->updateOrInsert(
                        [
                            'variant_id' => $variant->id,
                            'attribute_value_id' => $value_id
                        ],
                        [
                            'image_path' => $imagePath,
                            'updated_at' => now(),
                            'created_at' => now()
                        ]
                    );
                }
            }
        });

        return response()->json(['status' => 'success', 'message' => 'Variant updated successfully']);
    }



    public function destroyVariant($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Variant deleted successfully'
        ]);
    }
}