<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MedicineBatchRequest extends FormRequest
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
            'medicine' => 'required|exists:medicines,id',
            'manufacturer' => 'required|string',
            'production_address' => 'required|string',
            'manufacture_date' => 'required|before_or_equal:today',
            'expiry_date' => 'required|after:today',
            'quantity_received' => 'required|integer|min:1',
            'purchase_price' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'medicine.required' => 'Vui lòng chọn thuốc.',
            'medicine.exists' => 'Thuốc được chọn không tồn tại trong hệ thống.',

            'manufacturer.required' => 'Vui lòng nhập tên nhà sản xuất.',
            'manufacturer.string' => 'Tên nhà sản xuất phải là chuỗi ký tự.',

            'production_address.required' => 'Vui lòng nhập địa chỉ sản xuất.',
            'production_address.string' => 'Địa chỉ sản xuất phải là chuỗi ký tự.',

            'manufacture_date.required' => 'Vui lòng nhập ngày sản xuất.',
            'manufacture_date.before_or_equal' => 'Ngày sản xuất phải trước hoặc bằng ngày hiện tại.',

            'expiry_date.required' => 'Vui lòng nhập ngày hết hạn.',
            'expiry_date.after' => 'Ngày hết hạn phải sau ngày hiện tại.',

            'quantity_received.required' => 'Vui lòng nhập số lượng đã nhận.',
            'quantity_received.integer' => 'Số lượng phải là số nguyên.',
            'quantity_received.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',

            'purchase_price.required' => 'Vui lòng nhập giá mua.',
            'purchase_price.integer' => 'Giá mua phải là số nguyên.',
            'purchase_price.min' => 'Giá mua phải lớn hơn hoặc bằng 1.',
        ];
    }
}
