<?php


namespace App\Http\Requests\Dashboard\BlogCategories;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRequest extends FormRequest
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
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'slug_en' => ['nullable', 'string'],
            'slug_ar' => ['nullable', 'string'],
            'short_desc_en' => ['nullable', 'string'],
            'short_desc_ar' => ['nullable', 'string'],
            'long_desc_en' => ['nullable', 'string'],
            'long_desc_ar' => ['nullable', 'string'],
            'status' => ['nullable', 'in:published,inactive'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_desc_ar' => ['nullable', 'string'],
            'meta_desc_en' => ['nullable', 'string'],
            'index' => ['nullable', 'boolean'],
            'home' => ['nullable', 'boolean'],
            'menu' => ['nullable', 'boolean'],
        ];
    }
}
