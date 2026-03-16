<?php

namespace App\Http\Requests\Dashboard\Seo;

use Illuminate\Foundation\Http\FormRequest;

class CompanySeoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content_type' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'author_en' => 'nullable|string|max:255',
            'author_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'canonical_en' => 'nullable|string',
            'canonical_ar' => 'nullable|string',
            'robots' => 'nullable|string|max:255',
            
            'open_graph' => 'nullable|array',
            'open_graph.*' => 'nullable|string',
            
            'twitter_card' => 'nullable|array',
            'twitter_card.*' => 'nullable|string',
            
            'hreflang_keys' => 'nullable|array',
            'hreflang_keys.*' => 'nullable|string|max:255',
            'hreflang_values' => 'nullable|array',
            'hreflang_values.*' => 'nullable|string|max:255',
            
            'schema' => 'nullable|string',
        ];
    }
}
