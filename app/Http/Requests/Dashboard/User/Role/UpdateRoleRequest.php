<?php

namespace App\Http\Requests\Dashboard\User\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $role = $this->route('role');
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($role->id),
                'max:255',
            ],

            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }
}
