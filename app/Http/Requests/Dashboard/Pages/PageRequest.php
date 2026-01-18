<?php

namespace App\Http\Requests\Dashboard\Pages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => ['required','string','max:255'],
            'name_ar' => ['required','string','max:255'],
            'slug_en' => 'nullable|string',
            'slug_ar' => 'nullable|string',
            'short_desc_en' => ['nullable','string'],
            'short_desc_ar' => ['nullable','string'],
            'long_text_en' => ['nullable','string'],
            'long_text_ar' => ['nullable','string'],
            'status' => ['nullable', 'in:published,inactive'],
            'home' => ['nullable', 'boolean'],
            'menu' => ['nullable', 'boolean'],
        ];
    }
}
