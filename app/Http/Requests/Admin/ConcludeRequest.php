<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ConcludeRequest extends FormRequest
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
            'clinic_id' => 'nullable|exists:clinics,id',
            'symptom' => 'required',
            'diagnosis' => 'required',
            'conclude' => 'required',
            'result_file' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            're_examination_date' => 'nullable|after_or_equal:today'
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Vui lòng chọn bệnh nhân.',
            'patient_id.exists' => 'Bệnh nhân không hợp lệ.',
            'clinic_id.required' => 'Vui lòng chọn phòng khám.',
            'clinic_id.exists' => 'Phòng khám không hợp lệ.',
            'symptom.required' => 'Vui lòng nhập triệu chứng.',
            'diagnosis.required' => 'Vui lòng nhập chuẩn đoán.',
            'conclude.required' => 'Vui lòng nhập kết luận.',
            'result_file.mimes' => 'Chỉ chấp nhận tệp ảnh có định dạng: png, jpg, jpeg.',
            'result_file.max' => 'Kích thước tệp không được vượt quá 2MB.',
            're_examination_date.after_or_equal' => 'Ngày tái khám phải từ hôm nay trở đi.',
        ];
    }
}
