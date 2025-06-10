<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
        $patientId = $this->route('patient');
        return [
            'name' => 'required|string',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:1,2',
            'phone' =>  ['required', 'regex:/^(0|\+84)(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9])[0-9]{7}$/'],
            'address' => 'required',
            'cccd' => $patientId
                ? [
                    'required',
                    'regex:/^0[0-9]{11}$/',
                    "unique:patients,cccd,$patientId"
                ]
                : [
                    'required',
                    'regex:/^0[0-9]{11}$/',
                    "unique:patients,cccd"
                ],
            'bhyt_number' => $patientId
                ? "nullable|max:20|unique:patients,bhyt_number,$patientId"
                : 'nullable|max:20|unique:patients,bhyt_number',
            'hospital_registered' => 'nullable|max:100',
            'bhyt_expired_date' => 'nullable|date'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên bệnh nhân là bắt buộc.',
            'name.string' => 'Tên bệnh nhân phải là một chuỗi ký tự.',
            'dob.required' => 'Ngày sinh là bắt buộc.',
            'dob.date' => 'Ngày sinh phải là một ngày hợp lệ.',
            'dob.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'cccd.required' => 'Vui lòng nhập số CCCD.',
            'cccd.regex' => 'Số CCCD phải bao gồm đúng 12 chữ số.',
            'cccd.unique' => 'CCCD này đã tồn tại trong hệ thống.',
            'bhyt_number.max' => 'Số BHYT không được vượt quá 20 ký tự.',
            'bhyt_number.unique' => 'Số BHYT này đã tồn tại trong hệ thống.',
            'hospital_registered.max' => 'Tên cơ sở đăng ký KCB ban đầu không được dài quá 100 ký tự.',
            'bhyt_expired_date.date' => 'Ngày hết hạn BHYT không hợp lệ.',
        ];
    }
}
