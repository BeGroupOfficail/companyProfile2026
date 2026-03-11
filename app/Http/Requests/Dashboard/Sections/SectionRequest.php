<?php

namespace App\Http\Requests\Dashboard\Sections;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'key' => 'required|string|max:100|unique:company_sections,key,' . ($this->section->id ?? 'NULL'),
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'is_active' => 'required|boolean',
            'sort_order' => 'required|numeric|min:0',
        ];
        return $rules;
    }
}
