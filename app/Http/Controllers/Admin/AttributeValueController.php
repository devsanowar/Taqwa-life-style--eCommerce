<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;

class AttributeValueController extends Controller
{
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->latest()->get();
        return view('admin.layouts.pages.product.attribute_values.index', compact('attributeValues'));
    }

    public function create()
    {
        $attributes = Attribute::all();
        return view('admin.layouts.pages.product.attribute_values.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->value);

        // Ensure uniqueness per attribute
        if(AttributeValue::where('attribute_id', $request->attribute_id)->where('slug', $slug)->exists()){
            return response()->json([
                'status'=>'error',
                'message'=>'This value already exists for selected attribute!'
            ]);
        }

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'slug' => $slug,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return response()->json([
            'status'=>'success',
            'message'=>'Attribute value created successfully!'
        ]);
    }

    public function edit($id)
    {
        $attributes = Attribute::all();
        $attributeValue = AttributeValue::findOrFail($id);
        return view('admin.layouts.pages.product.attribute_values.edit', compact('attributeValue','attributes'));
    }

    public function update(Request $request, $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);

        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->value);

        if(AttributeValue::where('attribute_id', $request->attribute_id)->where('slug', $slug)->where('id','!=',$id)->exists()){
            return response()->json([
                'status'=>'error',
                'message'=>'This value already exists for selected attribute!'
            ]);
        }

        $attributeValue->update([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'slug' => $slug,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return response()->json([
            'status'=>'success',
            'message'=>'Attribute value updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();

        return response()->json([
            'status'=>'success',
            'message'=>'Attribute value deleted successfully!'
        ]);
    }
}