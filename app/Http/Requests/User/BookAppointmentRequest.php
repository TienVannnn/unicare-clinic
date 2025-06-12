<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookAppointmentRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^(0|\+84)(3[2-9]|5[2689]|7[0-9]|8[1-9]|9[0-9])[0-9]{7}$/'],
            'dob' => 'required|before:today',
            'gender' => 'in:1,2',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:admins,id',
            'appointment_date' => 'required|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'note' => 'required'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $date = $this->input('appointment_date');
            $time = $this->input('start_time');

            if ($date && $time) {
                $appointment = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
                $now = Carbon::now();

                if ($appointment->isToday() && $appointment->lt($now)) {
                    $validator->errors()->add('start_time', 'Giờ khám phải nằm sau thời điểm hiện tại.');
                }
            }
        });
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'dob.required' => 'Vui lòng chọn ngày sinh',
            'dob.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'department_id.required' => 'Vui lòng chọn phòng ban.',
            'department_id.exists' => 'Phòng ban không tồn tại.',
            'doctor_id.required' => 'Vui lòng chọn bác sĩ.',
            'doctor_id.exists' => 'Bác sĩ không tồn tại.',
            'appointment_date.required' => 'Vui lòng chọn ngày khám.',
            'appointment_date.after' => 'Ngày khám phải từ ngày mai.',
            'start_time.required' => 'Vui lòng chọn giờ khám.',
            'note.required' => 'Vui lòng nhập ghi chú.',
        ];
    }
}
