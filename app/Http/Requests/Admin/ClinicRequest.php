<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClinicRequest extends FormRequest
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
        $clinicId = $this->route('clinic');
        return [
            'name' => $clinicId ?  "required|min:2|string|unique:clinics,name,$clinicId"
                : 'required|min:2|string|unique:clinics,name',
            'department' => 'required|exists:departments,id',
            'status' => 'required|in:1,0'
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Tên phòng khám không được bỏ trống',
            'name.min' => 'Tên phòng khám tối thiểu 2 ký tự',
            'name.string' => 'Định dạng không hợp lệ',
            'name.unique' => 'Tên phòng khám đã tồn tại',
            'department.required' => 'Chuyên khoa không được bỏ trống',
            'department.exists' => 'Chuyên khoa không tồn tại',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
}
