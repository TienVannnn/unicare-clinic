<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
        $adminId = $this->route('manager');
        return [
            'name' => 'required|string|min:2',
            'email' => $adminId
                ? "required|email|unique:admins,email,$adminId"
                : 'required|email|unique:admins,email',
            'password' => 'nullable|min:5|confirmed'
        ];
    }
}
