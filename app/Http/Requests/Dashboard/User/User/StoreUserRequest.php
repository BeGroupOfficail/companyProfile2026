<?php

namespace App\Http\Requests\Dashboard\User\User;

use App\Models\User;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'unique:users,phone',new PhoneNumber()],
            'job_role' => 'required|in:' . implode(',',User::JOBRoles),
            'status' => 'required|in:active,inactive,blocked',
            'ssn' => 'nullable|string|unique:users,ssn',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'gender' => 'required|in:male,female',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
            'roles.*' => 'exists:roles,name',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => __('home.The phone number must be a valid Saudi number (e.g., 0501234567).'),
        ];
    }
}
