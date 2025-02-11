<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $permissionId = $this->route('permission');
        return [
            'name_permission' => $permissionId ? "required|min:2|unique:permissions,name_permission,$permissionId" : 'required|min:2|unique:permissions,name_permission'
        ];
    }

    public function messages()
    {
        return [
            'name_permission.required' => 'Tên quyền không được bỏ trống',
            'name_permission.unique' => 'Tên quyền này đã tồn tại'
        ];
    }
}
