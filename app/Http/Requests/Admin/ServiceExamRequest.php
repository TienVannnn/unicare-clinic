<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceExamRequest extends FormRequest
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
            'symptom' => 'required|string|max:255',
            'diagnosis' => 'required|string|max:255',
            'services' => 'required|array|min:1',
            'services.*.medical_service_id' => 'required|exists:medical_services,id',
            'services.*.clinic_id' => 'required|exists:clinics,id',
            'services.*.doctor_id' => 'required|exists:admins,id',
            'services.*.medical_time' => 'required',
            'services.*.note' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Vui lòng chọn bệnh nhân.',
            'patient_id.exists' => 'Bệnh nhân không hợp lệ.',

            'symptom.required' => 'Vui lòng nhập triệu chứng.',
            'symptom.string' => 'Triệu chứng phải là chuỗi văn bản.',
            'symptom.max' => 'Triệu chứng không được vượt quá 255 ký tự.',

            'diagnosis.required' => 'Vui lòng nhập chẩn đoán.',
            'diagnosis.string' => 'Chẩn đoán phải là chuỗi văn bản.',
            'diagnosis.max' => 'Chẩn đoán không được vượt quá 255 ký tự.',

            'services.required' => 'Vui lòng thêm ít nhất một dịch vụ khám.',
            'services.array' => 'Dữ liệu dịch vụ không hợp lệ.',
            'services.min' => 'Cần ít nhất một dịch vụ khám.',

            'services.*.medical_service_id.required' => 'Vui lòng chọn loại dịch vụ.',
            'services.*.medical_service_id.exists' => 'Dịch vụ được chọn không hợp lệ.',

            'services.*.clinic_id.required' => 'Vui lòng chọn phòng khám.',
            'services.*.clinic_id.exists' => 'Phòng khám không hợp lệ.',

            'services.*.doctor_id.required' => 'Vui lòng chọn bác sĩ thực hiện.',
            'services.*.doctor_id.exists' => 'Bác sĩ không hợp lệ.',

            'services.*.medical_time.required' => 'Vui lòng chọn thời gian khám.',

            'services.*.note.string' => 'Ghi chú phải là chuỗi văn bản.',
        ];
    }
}
