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
            'medical_service_id' => 'required|exists:medical_services,id',
            'clinic_id' => 'required|exists:clinics,id',
            'doctor_id' => 'required|exists:admins,id',
            'medical_time' => 'nullable|date|after_or_equal:today|before_or_equal:' . now()->addDays(10)->toDateString(),
            'symptom' => 'required',
            'diagnosis' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Vui lòng chọn bệnh nhân.',
            'patient_id.exists' => 'Bệnh nhân không tồn tại.',

            'medical_service_id.required' => 'Vui lòng chọn dịch vụ khám.',
            'medical_service_id.exists' => 'Dịch vụ khám không hợp lệ.',

            'doctor_id.required' => 'Vui lòng chọn bác sĩ.',
            'doctor_id.exists' => 'Bác sĩ không hợp lệ.',

            'clinic_id.required' => 'Vui lòng chọn phòng khám.',
            'clinic_id.exists' => 'Phòng khám không hợp lệ.',

            'medical_time.date' => 'Thời gian khám phải là ngày hợp lệ.',
            'medical_time.after_or_equal' => 'Thời gian khám không thể là ngày trong quá khứ.',
            'medical_time.before_or_equal' => 'Thời gian khám phải trong vòng 10 ngày kể từ hôm nay.',
            'symptom.required' => 'Triệu chứng không được để trống',
            'diagnosis.required' => 'Chuẩn đoán ban đầu không được để trống',
        ];
    }
}
