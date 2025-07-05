<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'f_name' => ['required','string','max:255'],
            'l_name' => ['required','string','max:255'],
            'email'=>['required','email','unique:users,email,'.auth()->id()],
            'phone' => ['required', 'regex:/^05[0-9]{8}$/', 'unique:users,phone,'.auth()->id()],
            'ssn' => ['required','string'],
            'image' => ['nullable','file'],
        ];
    }

    public function messages(): array{
        return [
            'phone.regex' => __('home.The phone number must be a valid Saudi number (e.g., 0501234567).'),
        ];
    }
}
