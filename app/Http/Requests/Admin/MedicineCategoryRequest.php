<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MedicineCategoryRequest extends FormRequest
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
        $categoryId = $this->route('medicine_category');
        return [
            'name' => $categoryId
                ? "required|unique:medicine_categories,name,$categoryId"
                : 'required|unique:medicine_categories,name',
            'description' => 'nullable|string',
            'status' => 'in:1,0|required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên loại thuốc không được bỏ trống',
            'name.unique' => 'Tên loại thuốc đã tồn tại',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
}
