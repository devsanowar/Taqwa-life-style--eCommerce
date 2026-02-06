<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteColorUpdateRequest extends FormRequest
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
            'font_primary'   => 'required|string|max:255',
            'font_secondary' => 'required|string|max:255',

            'gray'           => 'required|string|max:7', // HEX
            'gray_rgb'       => 'required|string|max:20', // RGB

            'base'           => 'required|string|max:7',
            'base_rgb'       => 'required|string|max:20',

            'primary'        => 'required|string|max:7',
            'primary_rgb'    => 'required|string|max:20',

            'black'          => 'required|string|max:7',
            'black_rgb'      => 'required|string|max:20',

            'white'          => 'required|string|max:7',
            'white_rgb'      => 'required|string|max:20',

            'border_color'   => 'required|string|max:7',
            'border_color_rgb' => 'required|string|max:20',

        ];
    }
}
