<?php

namespace App\Http\Requests\User;

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
        $user  = auth()->id();
        return [
            'name' => 'required',
            'phone' => ['required', 'unique:users,phone,' .  $user, 'regex:/^(0|\+84)(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9])[0-9]{7}$/'],
            'address' => 'nullable|string',
            'patient_code' => 'nullable|exists:patients,patient_code'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.unique' => 'Số điện thoại này đã tồn tại',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'patient_code.exists' => 'Mã bệnh nhân không tồn tại'
        ];
    }
}
