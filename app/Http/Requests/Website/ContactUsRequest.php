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
            'phone' => ['required',new PhoneNumber()],
        ];
    }
    public function messages(): array
    {
        return [
            'phone.regex' => __('home.The phone number must be a valid Saudi number (e.g., 0501234567).'),
        ];
    }
}
