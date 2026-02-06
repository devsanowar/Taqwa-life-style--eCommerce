<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        $parents = Menu::whereNull('parent_id')->get();
        return view('admin.layouts.pages.menu.index', compact('menus', 'parents'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'menu_url'  => 'required|string|max:255',
            'order'     => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        Menu::create([
            'menu_name' => $request->menu_name,
            'menu_url'  => $request->menu_url,
            'parent_id' => $request->parent_id ?: null,
            'order'     => $request->order ?? 0,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.website.menu.index')->with('success', 'Menu created successfully!');
    }


    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->menu_name = $request->menu_name;
        $menu->menu_url = $request->menu_url;
        $menu->parent_id = $request->parent_id;
        $menu->order = $request->order;
        $menu->is_active = $request->is_active ?? 0;
        $menu->save();

        return redirect()->back()->with('success', 'Menu updated successfully!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->back()->with('success', 'Menu deleted successfully!');
    }
}
