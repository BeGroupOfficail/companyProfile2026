<?php

namespace App\Http\Requests\Dashboard\Seo;

use App\Models\Dashboard\Seo\Seo;
use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $schemaTypes = Seo::SCHEMATPES;

        return[
            'schema_types' => ['nullable','array'],
            'schema_types.*' => ['in:' . implode(',', $schemaTypes)],
            'title_en' => ['nullable', 'string'],
            'title_ar' => ['nullable', 'string'],
            'slug_en' => ['nullable', 'string'],
            'slug_ar' => ['nullable', 'string'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_desc_ar' => ['nullable', 'string'],
            'meta_desc_en' => ['nullable', 'string'],
            'index' => ['nullable', 'boolean'],
        ];
    }
}
