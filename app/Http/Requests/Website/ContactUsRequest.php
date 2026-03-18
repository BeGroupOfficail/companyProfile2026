<?php

namespace App\Http\Requests\Website;

use App\Rules\PhoneNumber;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:150',
            'email' => 'nullable|email',
            'message' => 'required|string|max:150',
            'title' => 'nullable|string|max:150',
            'phone' => ['required','regex:/^\+?[0-9]{7,15}$/'],
            'job_title' => 'nullable|string|max:150',
            'company_name' => 'nullable|string|max:150',
        ];
    }
    public function messages(): array
    {
        return [
            'phone.regex' => __('dash.The phone number is not valid'),
        ];
    }
}
