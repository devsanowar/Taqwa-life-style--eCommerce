<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteSettingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'website_title'           => 'required|string|max:255',
            'website_phone_number_one' => 'nullable|string|max:20',
            'website_phone_number_two' => 'nullable|string|max:20',
            'website_email_one'       => 'nullable|email|max:255',
            'website_email_two'       => 'nullable|email|max:255',
            'website_address'         => 'nullable|string|max:500',
            'website_footer_content'  => 'nullable|string',
            'website_copyright_text'  => 'nullable|string|max:255',
            'website_footer_bg_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6})$/'], // HEX color validation
            'website_website_url'     => 'nullable|url|max:255',

            'website_header_logo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_favicon'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
            'website_footer_logo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_footer_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',

        ];
    }
}
