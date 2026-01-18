<?php

namespace App\Http\Requests\Dashboard\About;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AboutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return[
            'title_en' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'why_choose_us_en' => 'nullable|string',
            'why_choose_us_ar' => 'nullable|string',
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'image_en' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'banner_en' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'alt_image_en' => ['nullable', 'string', 'max:255'],
            'alt_banner_en' => ['nullable', 'string', 'max:255'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:5000'],
            'alt_banner' => ['nullable', 'string', 'max:255'],
        ];
    }
}
