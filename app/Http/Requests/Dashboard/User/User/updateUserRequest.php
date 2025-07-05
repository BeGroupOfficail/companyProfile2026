<?php

namespace App\Http\Requests\Dashboard\User\User;

use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
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
        $user =  $this->route('user'); ;
        return [
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => ['required', 'regex:/^05[0-9]{8}$/', 'unique:users,phone,' . $user->id],
            'job_role' => 'required|in:admin,instructor,student',
            'status' => 'required|in:active,inactive,blocked',
            'ssn' => 'string|unique:users,ssn',
            'nationality_id' => 'required|exists:nationalities,id',
            'gender' => 'required|in:male,female',
//            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
            'roles.*' => 'exists:roles,name',
        ];
    }

    public function messages(): array{
        return [
            'phone.regex' => __('home.The phone number must be a valid Saudi number (e.g., 0501234567).'),
        ];
    }
}
