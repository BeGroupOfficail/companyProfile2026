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
            'title_en' => 'nullable|string|max:100',
            'title_ar' => 'nullable|string|max:100',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'why_choose_us_en' => 'nullable|string',
            'why_choose_us_ar' => 'nullable|string',
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:5000'],
            'alt_banner' => ['nullable', 'string', 'max:255'],
            'slug_en' => ['nullable', 'string'],
            'slug_ar' => ['nullable', 'string'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_desc_ar' => ['nullable', 'string'],
            'meta_desc_en' => ['nullable', 'string'],
            'index' => ['nullable', 'boolean'],
        ];
    }
}
