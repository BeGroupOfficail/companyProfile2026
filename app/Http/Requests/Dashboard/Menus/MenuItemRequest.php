<?php

namespace App\Http\Requests\Dashboard\Menus;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuItemRequest extends FormRequest
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
            'parent_id' => 'nullable',
            'menu_id' => 'required|exists:menus,id',
            'types' => 'required|string|max:50',
            'type_value_id' => 'nullable|integer',
            'order' => 'required|integer',
            'link' => 'nullable|string|max:100',

            'status' => [
                'required',
                Rule::in(['published', 'inactive'])
            ],
        ];
        return $rules;
    }
}
