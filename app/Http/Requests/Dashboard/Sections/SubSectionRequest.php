<?php

namespace App\Http\Requests\Dashboard\Sections;

use Illuminate\Foundation\Http\FormRequest;

class SubSectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'section_id' => 'required|exists:company_sections,id',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'layout' => 'required|in:title_only,title_desc',
            'sort_order' => 'required|numeric|min:0',
        ];
    }
}
