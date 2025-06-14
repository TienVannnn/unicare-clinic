<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MedicalCertificateRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'clinic_id' => 'required|exists:clinics,id',
            'symptom' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'Bệnh nhân không được bỏ trống',
            'patient_id.exists' => 'Bệnh nhân không tồn tại',
            'clinic_id.required' => 'Phòng khám không được bỏ trống',
            'clinic_id.exists' => 'Phòng khám không tồn tại',
            'symptom.required' => 'Vui lòng nhập triệu chứng.',
            'symptom.string' => 'Triệu chứng phải là chuỗi văn bản.',
            'symptom.max' => 'Triệu chứng không được vượt quá 255 ký tự.',
        ];
    }
}
