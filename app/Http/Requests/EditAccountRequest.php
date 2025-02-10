<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAccountRequest extends FormRequest
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
            'name' => 'required|min:2',
            'phone' => ['nullable', 'unique:admins,phone,' .  auth()->guard('admin')->id(), 'regex:/^(0|\+84)(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9])[0-9]{7}$/'],
            'address' => 'nullable|string',
            'gender' => 'nullable|in:1,2'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được để trống.',
            'name.min' => 'Họ tên phải có ít nhất 2 ký tự.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'gender.in' => 'Giới tính không hợp lệ.',
        ];
    }
}
