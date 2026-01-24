<?php

namespace App\Http\Requests\Dashboard\User\User;

use App\Models\User;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user =  $this->route('user');
        $is_auth_user=auth()->id() == $user->id;
        return [
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => ['required', new PhoneNumber(), 'unique:users,phone,' . $user->id],
            'job_role' => $is_auth_user ? 'nullable|in:' . implode(',',User::JOBRoles) : 'required|in:' . implode(',',User::JOBRoles),
            'status' => $is_auth_user ?'nullable|in:active,inactive,blocked':'required|in:active,inactive,blocked',
             'ssn' => 'nullable|unique:users,ssn',
             'nationality_id' => 'nullable|exists:nationalities,id',
            'gender' => 'required|in:male,female',
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => $is_auth_user ? 'nullable|boolean' : 'required|boolean',
            'roles.*' => 'exists:roles,name',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
        ];
    }

    public function messages(): array{
        return [
            'phone.regex' => __('home.The phone number must be a valid Saudi number (e.g., 0501234567).'),
        ];
    }
}
