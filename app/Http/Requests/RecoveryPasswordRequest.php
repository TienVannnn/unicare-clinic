<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoveryPasswordRequest extends FormRequest
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
            'email' => 'required|exists:admins,email|email',
            'token_reset_password' => 'required|exists:admins,token_reset_password',
            'password' => 'required|min:5|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'email.exists' => 'Email không tồn tại trong hệ thống',
            'token_reset_password.required' => 'Mã xác nhận không được để trống',
            'token_reset_password.exists' => 'Mã xác nhận không hợp lệ',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 5 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không hợp lệ',
        ];
    }
}
