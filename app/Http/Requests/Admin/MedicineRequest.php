<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
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
        $medicineId = $this->route('medicine');
        return [
            'name' => $medicineId
                ? "required|unique:medicines,name,$medicineId"
                : 'required|unique:medicines,name',
            'description' => 'required|string',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:0',
            'medicine_categories' => 'required|exists:medicine_categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên thuốc.',
            'name.unique' => 'Tên thuốc này đã tồn tại.',
            'description.required' => 'Vui lòng nhập mô tả thuốc.',
            'description.string' => 'Mô tả phải là một chuỗi ký tự.',
            'unit.required' => 'Vui lòng nhập đơn vị tính.',
            'unit.string' => 'Đơn vị phải là một chuỗi ký tự.',
            'price.required' => 'Vui lòng nhập giá thuốc.',
            'price.numeric' => 'Giá phải là một số.',
            'price.min' => 'Giá phải lớn hơn 0.',
            'quantity.required' => 'Vui lòng nhập số lượng thuốc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng không thể âm.',
            'medicine_categories.required' => 'Vui lòng chọn ít nhất một loại thuốc.',
            'medicine_categories.exists' => 'Loại thuốc không hợp lệ.',
        ];
    }
}
