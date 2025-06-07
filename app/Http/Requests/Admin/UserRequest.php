<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');
        return [
            'name' => 'required|string|min:2',
            'email' => $userId
                ? "required|email|unique:users,email,$userId"
                : 'required|email|unique:users,email',
            'password' => 'nullable|min:5|confirmed',
            'phone' => ['nullable', 'unique:users,phone,' .  $userId, 'regex:/^(0|\+84)(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9])[0-9]{7}$/'],
            'address' => 'nullable|string',
            'verify_email' => 'required|in:1,0',
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

            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'avatar.image' => 'Vui lòng chọn ảnh',
            'avatar.mimes' => 'Ảnh không đúng định dạng',
            'avatar.max' => 'Kích thước ảnh vượt quá giới hạn',

            'verify_email.in' => 'Xác thực email không hợp lệ',
            'phone.unique' => 'Số điện thoại đã được dùng',
            'phone.regex' => 'Số điện thoại không hợp lệ'
        ];
    }
}
