<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with([
            'primaryImage',
            'images',
            'variants.variantValues.attributeValue.attribute'
        ])->findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        $variantId = $request->variant_id;
        $variant   = null;
        $price     = $product->base_price;

        if ($variantId) {
            $variant = $product->variants()->find($variantId);

            if (!$variant) {
                return response()->json(['message' => 'Invalid variant'], 400);
            }

            if ($variant->price_override) {
                $price = $variant->price_override;
            }
        }

        $finalPrice = $product->calculateDiscount($price);

        $productImage = null;

        if ($variant && $variant->image_path) {
            $productImage = $variant->image_path;
        } elseif ($product->primaryImage) {
            $productImage = $product->primaryImage->path;
        } elseif ($product->images->count() > 0) {
            $productImage = $product->images->first()->path;
        }

        $cartKey = $variantId ? $product->id . '-' . $variantId : $product->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $request->order_qty ?? 1;
        } else {

            $cart[$cartKey] = [
                "product_id" => $product->id,
                "variant_id" => $variantId,
                "name"       => $product->name,
                "image"      => $productImage,
                "price"      => $finalPrice,
                "qty"        => $request->order_qty ?? 1,
                "attributes" => $this->getVariantAttributes($variant),
            ];
        }

        session()->put('cart', $cart);

        $itemCount = collect($cart)->sum('qty');
        $subtotal  = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return response()->json([
            'message' => 'Added to cart successfully!',
            'itemCount' => $itemCount,
            'subtotal' => number_format($subtotal, 2),
            'mini_cart_html' => view('website.layouts.partials.mini_cart', compact('cart'))->render()
        ]);
    }


    private function getVariantAttributes($variant)
    {
        if (!$variant) return [];

        $attributes = [];

        foreach ($variant->variantValues as $value) {
            $attributes[$value->attribute->name] =
                $value->attributeValue->value;
        }

        return $attributes;
    }


    public function cartPage()
    {
        $cart = session()->get('cart', []);
        return view('website.layouts.pages.cart.cart_page', compact('cart'));
    }





    public function updateQty(Request $request)
    {
        $cart = session()->get('cart', []);
        $key  = $request->cart_key;

        if (isset($cart[$key])) {

            $cart[$key]['qty'] = max(1, (int)$request->qty);

            session()->put('cart', $cart);
        }

        $itemCount = collect($cart)->sum('qty');
        $subtotal  = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return response()->json([
            'itemCount' => $itemCount,
            'subtotal'  => number_format($subtotal, 2),
            'mini_cart_html' => view('website.layouts.partials.mini_cart', compact('cart'))->render()
        ]);
    }


    public function removeItem(Request $request)
    {
        $cart = session()->get('cart', []);
        $key  = $request->cart_key;

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        $itemCount = collect($cart)->sum('qty');
        $subtotal  = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return response()->json([
            'itemCount' => $itemCount,
            'subtotal'  => number_format($subtotal, 2),
            'mini_cart_html' => view('website.layouts.partials.mini_cart', compact('cart'))->render()
        ]);
    }
}
