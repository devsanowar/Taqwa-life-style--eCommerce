<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->get();
        return view('admin.layouts.pages.product.attribute.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.layouts.pages.product.attribute.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:attributes,code',
            'type' => 'required|in:select,text',
        ]);

        Attribute::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute created successfully!'
        ]);
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin.layouts.pages.product.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:attributes,code,' . $id,
            'type' => 'required|in:select,text',
        ]);

        $attribute->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute deleted successfully!'
        ]);
    }
}
