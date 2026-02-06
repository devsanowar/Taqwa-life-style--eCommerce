<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialIcon;
use Illuminate\Http\Request;

class SocialIconController extends Controller
{
    public function index(){
        $socialIcon = SocialIcon::first();
        return view('admin.layouts.pages.social-icon.index', compact('socialIcon'));
    }

    public function update(Request $request){
        $request->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'google_plus_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
        ]);

        $socialIcon = SocialIcon::firstOrNew(['id' => 1]);

       $socialIcon->updateOrCreate([
            'facebook_url' => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
            'twitter_url' => $request->twitter_url,
            'google_plus_url' => $request->google_plus_url,
            'youtube_url' => $request->google_plus_url,
            'tiktok_url' => $request->google_plus_url,
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Social icon updated successfully.'
        ]);
    }
}
