<?php

namespace App\Http\Requests\Website;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:150',
            'email' => 'required|email',
            'message' => 'required|string|max:255',
            'title' => 'required|string|max:150',
            'phone' => ['required', 'regex:/^05[0-9]{8}$/'],
        ];
    }
    public function messages(): array
    {
        return [
            'phone.regex' => __('home.The phone number must be a valid Saudi number (e.g., 0501234567).'),
        ];
    }
}
