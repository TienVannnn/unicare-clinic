<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AskQuestionRequest extends FormRequest
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
            'department' => 'required|exists:departments,id',
            'title' => 'required|max:100|string',
            'question' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'department.required' => 'Vui lòng chọn chuyên khoa.',
            'department.exists' => 'Chuyên khoa không hợp lệ.',
            'title.required' => 'Vui lòng nhập tiêu đề câu hỏi.',
            'title.max' => 'Tiêu đề không được vượt quá 100 ký tự.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'question.required' => 'Vui lòng nhập nội dung câu hỏi.',
            'question.string' => 'Nội dung câu hỏi phải là chuỗi ký tự.'
        ];
    }
}
