<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsCategoryRequest extends FormRequest
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
        $categoryId = $this->route('news_category');
        return [
            'name' => $categoryId
                ? "required|unique:news_categories,name,$categoryId"
                : 'required|unique:news_categories,name',
            'status' => 'required|in:1,0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên loại tin tức không được bỏ trống',
            'name.unique' => 'Tên loại tin tức đã tồn tại',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
}
