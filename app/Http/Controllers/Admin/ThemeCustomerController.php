<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeCustomizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ThemeCustomerController extends Controller
{
    public function index(){
        $themeCustomize = ThemeCustomizer::first();
        return view('admin.layouts.pages.theme-customize.index', compact('themeCustomize'));
    }

    public function update(Request $request)
    {
        $theme = ThemeCustomizer::first() ?? new ThemeCustomizer();

        $theme->theme_style   = $request->theme_style;

        $theme->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Theme updated successfully',
            'data' => $theme
        ]);
    }

}
