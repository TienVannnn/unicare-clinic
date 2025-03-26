<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class GetPatientRequest extends FormRequest
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
            'patient_code' => 'required|exists:patients,patient_code'
        ];
    }

    public function messages()
    {
        return [
            'patient_code.required' => 'Mã bệnh nhân không được bỏ trống',
            'patient_code.exists' => 'Mã bệnh nhân không tồn tại'
        ];
    }
}
