<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
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
            'title'      => 'required|string|max:255',
            'sub_title'  => 'required|string',
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'status'     => 'required|in:0,1',
        ];
    }


    public function messages()
    {
        return [
            'title.required'      => 'Slider title is required.',
            'title.max'           => 'Slider title cannot exceed 255 characters.',

            'sub_title.required'  => 'Slider sub title is required.',

            'image.required'      => 'Slider image is required.',
            'image.image'         => 'Uploaded file must be an image.',
            'image.mimes'         => 'Image must be jpg, jpeg, png, or webp format.',
            'image.max'           => 'Image size must not exceed 2MB.',

            'status.required'     => 'Please select slider status.',
            'status.in'           => 'Invalid status selected.',

            'sort_order.integer'  => 'Sort order must be a number.',
        ];
    }
}
