<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
        $departmentId = $this->route('department');
        return [
            'name' => $departmentId ?  "required|min:2|string|unique:departments,name,$departmentId"
                : 'required|min:2|string|unique:departments,name',
            'description' => 'nullable|string',
            'status' => 'required|in:1,0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên chuyên môn không được bỏ trống',
            'name.min' => 'Trường này ít nhất có 2 ký tự',
            'name.string' => 'Định dạng không hợp lệ',
            'name.unique' => 'Tên chuyên môn đã tồn tại',
            'description.string' => 'Định dạng không hợp lệ',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
}
