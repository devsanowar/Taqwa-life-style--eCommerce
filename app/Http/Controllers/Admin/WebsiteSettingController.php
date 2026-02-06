<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteColorUpdateRequest;
use App\Http\Requests\WebsiteSettingUpdateRequest;
use App\Models\WebsiteColor;

class WebsiteSettingController extends Controller
{
    public function index()
    {
        $websiteSetting = WebsiteSetting::first() ?? new WebsiteSetting;
        return view('admin.layouts.pages.website-settings.index', compact('websiteSetting'));
    }


    public function update(WebsiteSettingUpdateRequest $request)
    {
        $websiteSetting = WebsiteSetting::first();

        if (!$websiteSetting) {
            $websiteSetting = new WebsiteSetting;
        }

        $data = $request->only([
            'website_title',
            'website_phone_number_one',
            'website_phone_number_two',
            'website_email_one',
            'website_email_two',
            'website_address',
            'website_footer_content',
            'website_copyright_text',
            'website_footer_bg_color',
            'website_website_url',
        ]);

        // Upload path
        $uploadPath = 'uploads/website_settings_images/';

        // website_header_logo
        if ($request->hasFile('website_header_logo')) {
            if (!empty($websiteSetting->website_header_logo) && file_exists(public_path($websiteSetting->website_header_logo))) {
                unlink(public_path($websiteSetting->website_header_logo));
            }
            $file = $request->file('website_header_logo');
            $filename = time() . '_header.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath), $filename);
            $data['website_header_logo'] = $uploadPath . $filename;
        } else {
            $data['website_header_logo'] = $websiteSetting->website_header_logo;
        }

        // website_favicon
        if ($request->hasFile('website_favicon')) {
            if (!empty($websiteSetting->website_favicon) && file_exists(public_path($websiteSetting->website_favicon))) {
                unlink(public_path($websiteSetting->website_favicon));
            }
            $file = $request->file('website_favicon');
            $filename = time() . '_favicon.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath), $filename);
            $data['website_favicon'] = $uploadPath . $filename;
        } else {
            $data['website_favicon'] = $websiteSetting->website_favicon;
        }

        // website_footer_logo
        if ($request->hasFile('website_footer_logo')) {
            if (!empty($websiteSetting->website_footer_logo) && file_exists(public_path($websiteSetting->website_footer_logo))) {
                unlink(public_path($websiteSetting->website_footer_logo));
            }
            $file = $request->file('website_footer_logo');
            $filename = time() . '_footer.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath), $filename);
            $data['website_footer_logo'] = $uploadPath . $filename;
        } else {
            $data['website_footer_logo'] = $websiteSetting->website_footer_logo;
        }

        // website_footer_bg_image
        if ($request->hasFile('website_footer_bg_image')) {
            if (!empty($websiteSetting->website_footer_bg_image) && file_exists(public_path($websiteSetting->website_footer_bg_image))) {
                unlink(public_path($websiteSetting->website_footer_bg_image));
            }
            $file = $request->file('website_footer_bg_image');
            $filename = time() . '_footer_bg.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath), $filename);
            $data['website_footer_bg_image'] = $uploadPath . $filename;
        } else {
            $data['website_footer_bg_image'] = $websiteSetting->website_footer_bg_image;
        }

        // Save or update
        if ($websiteSetting->exists) {
            $websiteSetting->update($data);
        } else {
            $websiteSetting->fill($data)->save();
        }

        $responseData = [
            'website_header_logo' => $websiteSetting->website_header_logo ? asset($websiteSetting->website_header_logo) : null,
            'website_favicon' => $websiteSetting->website_favicon ? asset($websiteSetting->website_favicon) : null,
            'website_footer_logo' => $websiteSetting->website_footer_logo ? asset($websiteSetting->website_footer_logo) : null,
            'website_footer_bg_image' => $websiteSetting->website_footer_bg_image ? asset($websiteSetting->website_footer_bg_image) : null,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data successfully updated!',
            'data' => $responseData,
        ]);
    }


    public function websiteColorUpdate(WebsiteColorUpdateRequest $request)
    {

        // Assuming there's only one row in website_colors
        $colors = WebsiteColor::first();

        if (!$colors) {
            // If row does not exist, create it
            $colors = new WebsiteColor();
        }

        // Update all fields
        $colors->font_primary       = $request->font_primary;
        $colors->font_secondary     = $request->font_secondary;

        $colors->gray               = $request->gray;
        $colors->gray_rgb           = $request->gray_rgb;

        $colors->base               = $request->base;
        $colors->base_rgb           = $request->base_rgb;

        $colors->primary            = $request->primary;
        $colors->primary_rgb        = $request->primary_rgb;

        $colors->black              = $request->black;
        $colors->black_rgb          = $request->black_rgb;

        $colors->white              = $request->white;
        $colors->white_rgb          = $request->white_rgb;

        $colors->border_color       = $request->border_color;
        $colors->border_color_rgb   = $request->border_color_rgb;

        $colors->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Website colors updated successfully!',
            'data'    => $colors
        ]);
    }
}
