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
            'clinic' => 'required|exists:clinics,id',
            'department' => 'required|exists:departments,id',
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|min:5|confirmed',
            'phone' => ['nullable', 'unique:admins,phone,' .  $adminId, 'regex:/^(0|\+84)(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9])[0-9]{7}$/'],
            'address' => 'nullable|string',
            'gender' => 'nullable|in:1,2',
            'status' => 'required|in:1,0',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.min' => 'Tên phải có ít nhất :min ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',

            'clinic.required' => 'Vui lòng chọn phòng khám.',
            'clinic.exists' => 'Phòng khám không hợp lệ.',
            'department.required' => 'Vui lòng chọn chuyên khoa.',
            'department.exists' => 'Chuyên khoa không hợp lệ.',

            'role.required' => 'Vui lòng chọn vai trò.',
            'role.exists' => 'Vai trò không hợp lệ.',

            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'avatar.image' => 'Vui lòng chọn ảnh',
            'avatar.mimes' => 'Ảnh không đúng định dạng',
            'avatar.max' => 'Kích thước ảnh vượt quá giới hạn'
        ];
    }
}
