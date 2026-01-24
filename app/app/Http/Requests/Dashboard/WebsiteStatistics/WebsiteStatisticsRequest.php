<?php


namespace App\Http\Requests\Dashboard\WebsiteStatistics;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteStatisticsRequest extends FormRequest
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
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'count' => ['required', 'integer'],
            'status' => ['required', 'in:published,inactive'],
        ];
    }
}
