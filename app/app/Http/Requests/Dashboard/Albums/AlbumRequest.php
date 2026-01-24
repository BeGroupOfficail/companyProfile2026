<?php

namespace App\Http\Requests\Dashboard\Albums;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlbumRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title_en' => 'required|string|max:100',
            'title_ar' => 'required|string|max:100',
            'text_en' => 'required|string|max:255',
            'text_ar' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'type_value_id' => 'nullable|integer',
            'album_type' => [
                'required',
                Rule::in(['images', 'videos'])
            ],
            'status' => [
                'required',
                Rule::in(['published', 'inactive'])
            ],
        ];

        // For update (when album exists)
        if ($this->album) {
            $rules['title'] = 'sometimes|string|max:255';
            $rules['types'] = 'sometimes|string|max:50';
            $rules['lang'] = 'sometimes|string|max:10';
        }

        return $rules;
    }
}
