<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
        $menuId = $this->route('parent');
        return [
            'title' => $menuId
                ? "required|unique:menu_items,title,$menuId"
                : 'required|unique:menu_items,title',
            'url' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tên mục không được bỏ trống',
            'title.unique' => 'Tên mục đã tồn tại',
            'url.required' => 'Đường dẫn liên kết không được bỏ trống'
        ];
    }
}
