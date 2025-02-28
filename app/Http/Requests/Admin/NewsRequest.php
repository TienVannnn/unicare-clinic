<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
        $newsId = $this->route('news');
        return [
            'title' => $newsId
                ? "required|unique:news,title,$newsId"
                : 'required|unique:news,title',
            'thumbnail' => !$newsId ?  'required|image|mimes:png,jpg,jpeg|max:2048' : 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
            'news_categories' => 'required|exists:news_categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để trống.',
            'title.unique' => 'Tiêu đề này đã tồn tại, vui lòng chọn tiêu đề khác.',
            'content.required' => 'Nội dung không được để trống.',
            'content.string' => 'Nội dung phải là một chuỗi ký tự hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ. Chỉ chấp nhận giá trị 0 hoặc 1.',
            'news_categories.required' => 'Danh mục là bắt buộc.',
            'news_categories.exists' => 'Danh mục không hợp lệ.',
            'thumbnail.mimes' => 'Chỉ chấp nhận tệp ảnh có định dạng: png, jpg, jpeg.',
            'thumbnail.max' => 'Kích thước tệp không được vượt quá 2MB.',
            'thumbnail.required' => 'Ảnh không được để trống'
        ];
    }
}
