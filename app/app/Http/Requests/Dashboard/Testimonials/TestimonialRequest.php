<?php


namespace App\Http\Requests\Dashboard\Testimonials;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
            'title_en' => ['nullable', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'author_name' => ['nullable', 'string', 'max:255'],
            'author_title' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'text_en' => ['nullable', 'string'],
            'text_ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:published,inactive'],
            'rate' => ['nullable', 'integer '],
        ];
    }
}
