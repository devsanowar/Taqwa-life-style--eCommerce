<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function wishlistPage()
    {
        $wishlist = session()->get('wishlist', []);
        return view('website.layouts.pages.wishlist.wishlist', compact('wishlist'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer',
        ]);

        $wishlist = session()->get('wishlist', []);

        $product = Product::with([
            'primaryImage',
            'variants.variantValues.attributeValue.attribute',
        ])->findOrFail($request->product_id);

        $variantId = $request->variant_id ?? null;
        $variant   = null;
        $price     = $product->base_price;

        if ($variantId) {

            $variant = $product->variants()->find($variantId);

            if (! $variant) {
                return response()->json([
                    'message' => 'Invalid variant',
                ], 400);
            }

            if ($variant->price_override) {
                $price = $variant->price_override;
            }
        }

        // Unique Key (Product + Variant)
        $wishlistKey = $variantId
            ? $product->id . '-' . $variantId
            : (string) $product->id;

        //Toggle Remove
        if (isset($wishlist[$wishlistKey])) {

            unset($wishlist[$wishlistKey]);
            session()->put('wishlist', $wishlist);

            return response()->json([
                'status'        => true,
                'added'         => false,
                'message'       => 'Removed from wishlist',
                'wishlistCount' => count($wishlist),
            ]);
        }


        $image = null;

        if ($variant && $variant->image_path) {
            $image = $variant->image_path;
        } elseif ($product->primaryImage) {
            $image = $product->primaryImage->path;
        }

        $wishlist[$wishlistKey] = [
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'name'       => $product->name,
            'slug'       => $product->slug ?? null,
            'price'      => $price,
            'image'      => $image,
            'attributes' => $this->getVariantAttributes($variant),
            'added_at'   => now()->toDateTimeString(),
        ];

        session()->put('wishlist', $wishlist);

        return response()->json([
            'status'        => true,
            'added'         => true,
            'message'       => 'Added to wishlist',
            'wishlistCount' => count($wishlist),
        ]);
    }

private function getVariantAttributes($variant)
{
    if (! $variant) {
        return [];
    }

    $attributes = [];

    foreach ($variant->variantValues as $value) {
        $attributes[$value->attribute->name][] = [
            'id'    => $value->attributeValue->id,
            'value' => $value->attributeValue->value,
        ];
    }

    return $attributes;
}

}
