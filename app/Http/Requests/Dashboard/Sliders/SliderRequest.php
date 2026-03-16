<?php

namespace App\Http\Requests\Dashboard\Sliders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['nullable','string','max:255'],
            'text' => ['nullable','string','max:255'],
            'link' => [
                'nullable',
                'string',
                'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'max:255'
            ],
            'image' => ['nullable','image','mimes:jpeg,png,gif,bmp,webp','max:5000'],
            'alt_image' => ['nullable','string','max:255'],
            'status' => ['nullable', 'in:published,inactive'],
            'order' => ['required', 'integer','min:0'],
            'lang' => [
                'required',
                'string',
                'in:'.implode(',', array_keys(config('languages'))),
            ],
        ];
    }
}
