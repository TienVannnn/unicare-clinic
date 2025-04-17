<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MedicalServiceRequest extends FormRequest
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
        $medical_serviceId = $this->route('medical_service');
        return [
            'name' => $medical_serviceId ?  "required|min:2|string|unique:medical_services,name,$medical_serviceId"
                : 'required|min:2|string|unique:medical_services,name',
            'description' => 'nullable|string',
            'price' => 'required',
            'clinic_ids' => 'required|array',
            'clinic_ids.*' => 'exists:clinics,id',
            'status' => 'required|in:1,0'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên dịch vụ là bắt buộc.',
            'name.min' => 'Tên dịch vụ phải có ít nhất 2 ký tự.',
            'name.string' => 'Tên dịch vụ phải là một chuỗi.',
            'name.unique' => 'Tên dịch vụ đã tồn tại, vui lòng chọn tên khác.',

            'description.string' => 'Mô tả dịch vụ phải là một chuỗi.',

            'price.required' => 'Giá dịch vụ là bắt buộc.',

            'clinic.required' => 'Phòng khám là bắt buộc.',
            'clinic.exists' => 'Phòng khám không hợp lệ.',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
}
