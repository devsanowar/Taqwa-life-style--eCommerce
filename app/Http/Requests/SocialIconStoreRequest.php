<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialIconStoreRequest extends FormRequest
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
            'facebook_url'     => 'nullable|url',
            'instagram_url'    => 'nullable|url',
            'linkedin_url'     => 'nullable|url',
            'twitter_url'      => 'nullable|url',
            'google_plus_url'  => 'nullable|url',
            'youtube_url'      => 'nullable|url',
            'tiktok_url'       => 'nullable|url',
        ];
    }
}
