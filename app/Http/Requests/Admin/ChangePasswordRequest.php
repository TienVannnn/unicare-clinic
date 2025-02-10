<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_pass' => 'required',
            'password' => 'required|confirmed|min:4'
        ];
    }

    public function messages()
    {
        return [
            'old_pass.required' => 'Trường này không được bỏ trống',
            'password.required' => 'Trường này không được bỏ trống',
            'password.confirmed' => 'Xác nhận mật khẩu không hợp lệ',
            'password.min' => 'Mật khẩu phải có tối thiểu 4 ký tự'
        ];
    }
}
