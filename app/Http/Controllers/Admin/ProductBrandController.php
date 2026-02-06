<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductBrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = ProductBrand::latest()->paginate(20)->onEachSide(1);

        if ($request->ajax()) {
            return view('admin.layouts.pages.product.brand.partials.brands_table', compact('brands'))->render();
        }

        return view('admin.layouts.pages.product.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_brands,name',
            'status' => 'required'
        ]);

        $brand = ProductBrand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Brand added successfully',
            'brand' => $brand,
        ]);
    }


    public function edit($id)
    {
        return response()->json(ProductBrand::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $brand = ProductBrand::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:product_brands,name,' . $id
        ]);

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);

        return response()->json(['status' => 'success', 'message' => 'Product Brand updated', 'brand' => $brand]);
    }

    public function destroy($id)
    {
        ProductBrand::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Product Brand deleted']);
    }
}
