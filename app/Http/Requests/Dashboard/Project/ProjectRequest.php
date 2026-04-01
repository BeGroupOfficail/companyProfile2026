<?php


namespace App\Http\Requests\Dashboard\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        $rules = [
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'service_id' => ['nullable','exists:services,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,gif,bmp,webp', 'max:3096'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:project_images,id'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'slug_en' => ['nullable', 'string'],
            'slug_ar' => ['nullable', 'string'],
            'short_desc_en' => ['nullable', 'string'],
            'short_desc_ar' => ['nullable', 'string'],
            'long_desc_en' => ['nullable', 'string'],
            'long_desc_ar' => ['nullable', 'string'],
            'status' => ['nullable', 'in:published,inactive'],
            'home' => ['nullable', 'boolean'],
            'menu' => ['nullable', 'boolean'],
            'type_en' => ['nullable', 'string'],
            'type_ar' => ['nullable', 'string'],
            'location_en'=> ['nullable', 'string'],
            'location_ar'=> ['nullable', 'string'],
            'area_en'=> ['nullable', 'string'],
            'area_ar'=> ['nullable', 'string'],
            'client_en'=> ['nullable', 'string'],
            'client_ar'=> ['nullable', 'string'],
            'badges_en'=> ['nullable', 'string'],
            'badges_ar'=> ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'scope_ar'=> ['nullable', 'string'],
            'scope_en'=> ['nullable', 'string'],
        ];

        if ($this->isMethod('post')) {
            $rules['images'][] = 'required';
            $rules['images'][] = 'min:1';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->isMethod('put') || $this->isMethod('patch')) {
                $project = $this->route('project');
                
                if ($project) {
                    $deleteIds = $this->input('delete_images', []);
                    $newImagesCount = count($this->file('images', []));

                    // Count how many existing images will remain (excluding the ones marked for deletion)
                    $remainingImagesCount = $project->images()
                        ->whereNotIn('id', $deleteIds)
                        ->count();

                    $totalImages = $remainingImagesCount + $newImagesCount;

                    if ($totalImages < 1) {
                         $validator->errors()->add('images', __('dash.The project must have at least one image'));
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'images.*.max' => __('dash.Each image must not exceed 3MB'),
            'images.*.image' => __('dash.Each file must be a valid image'),
        ];
    }
}
