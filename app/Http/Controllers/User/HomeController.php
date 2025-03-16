<?php

namespace App\Http\Controllers\User;

use App\Events\AppointmentEvent;
use App\Events\ContactEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\BookAppointmentRequest;
use App\Http\Requests\User\ContactRequest;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Contact;
use App\Models\Department;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Trang chủ';
        $departments = Department::orderByDesc('id')->get();
        $doctors = Admin::role('Bác sĩ')->orderByDesc('id')->get();
        $news = News::orderByDesc('id')->get();
        return view('user.home.home', compact('title', 'news', 'departments', 'doctors'));
    }

    public function contact_form()
    {
        $title = 'Liên hệ với chúng tôi';
        return view('user.home.contact', compact('title'));
    }

    public function contact(ContactRequest $request)
    {
        try {
            $data = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'title' => $request->title,
                'message' => $request->message,
                'status' => 0
            ]);
            $count = Contact::where('status', 0)->count();
            event(new ContactEvent($data['title'], $data['name'], $data['id'], $count));
            Session::flash('success', 'Gửi liên hệ thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi liên hệ' . $e->getMessage());
        }
        return redirect()->back();
    }

    public function book_appointment(BookAppointmentRequest $request)
    {
        try {
            $data = Appointment::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'department_id' => $request->department_id,
                'doctor_id' => $request->doctor_id,
                'time' => $request->time,
                'note' => $request->note,
                'is_viewed' => false,
                'status' => 0
            ]);
            $count = Appointment::where('is_viewed', false)->count();
            event(new AppointmentEvent($data['name'], $data['id'], $count));
            return response()->json(['success' => true, 'message' => 'Đặt lịch khám thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi khi đặt lịch khám!']);
        }
    }
}
