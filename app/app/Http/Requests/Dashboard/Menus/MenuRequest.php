<?php

namespace App\Http\Requests\Dashboard\Menus;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100',
            'status' => [
                'required',
                Rule::in(['published', 'inactive'])
            ],
        ];
        return $rules;
    }
}
