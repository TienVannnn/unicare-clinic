<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            'medical_certificate_id' => 'required|exists:medical_certificates,id',
            'note' => 'nullable|string',
            'medicines' => 'required|array',
            'medicines.*.medicine' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1',
            'medicines.*.dosage' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'medical_certificate_id.required' => 'Giấy khám bệnh là trường bắt buộc.',
            'medical_certificate_id.exists' => 'Giấy khám bệnh không tồn tại trong hệ thống.',
            'note.string' => 'Ghi chú phải là chuỗi văn bản.',
            'medicines.required' => 'Danh sách thuốc là bắt buộc.',
            'medicines.array' => 'Danh sách thuốc phải là một mảng.',
            'medicines.*.medicine.required' => 'Tên thuốc là bắt buộc.',
            'medicines.*.medicine.exists' => 'Thuốc không tồn tại trong hệ thống.',
            'medicines.*.quantity.required' => 'Số lượng thuốc là bắt buộc.',
            'medicines.*.quantity.integer' => 'Số lượng thuốc phải là một số nguyên.',
            'medicines.*.quantity.min' => 'Số lượng thuốc phải lớn hơn hoặc bằng 1.',
            'medicines.*.dosage.required' => 'Cách dùng là bắt buộc.',
            'medicines.*.dosage.string' => 'Cách dùng phải là chuỗi văn bản.',
            'medicines.*.dosage.max' => 'Cách dùng không được vượt quá 255 ký tự.',
        ];
    }
}
