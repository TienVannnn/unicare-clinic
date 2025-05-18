<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ContactReplyJob;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\AppointmentReply;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-lich-hen-kham');
        $title = 'Danh sách lịch hẹn khám';
        $appointments = Appointment::orderByDesc('id')->paginate(15);
        return view('admin.appointment.list', compact('title', 'appointments'));
    }

    public function show(string $id)
    {
        $this->authorize('xem-chi-tiet-lich-hen-kham');
        $appointment = Appointment::findOrFail($id);
        if ($appointment->is_viewed == 0) $appointment->update(['is_viewed' => 1]);
        $replies = $appointment->appointmentReplies;
        $title = 'Chi tiết lịch hẹn khám';
        $admin = auth()->guard('admin')->user();
        return view('admin.appointment.detail_appointment', compact('title', 'appointment', 'replies', 'admin'));
    }

    public function destroy(string $id)
    {
        $this->authorize('xoa-lich-hen-kham');
        $appointment = Appointment::findOrFail($id);
        try {
            $appointment->delete();
            return response()->json(['success' => true, 'message' => 'Xóa lịch hẹn thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa lịch hẹn vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa lịch hẹn: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function delete($id)
    {
        $this->authorize('xoa-lich-hen-kham');
        $appointment = Appointment::findOrFail($id);
        try {
            $appointment->delete();
            Session::flash('success', 'Xóa lịch hẹn khám thành công');
            return redirect()->route('appointment.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi xóa lịch hẹn khám');
            return redirect()->back();
        }
    }

    public function allDelete(Request $request)
    {
        $this->authorize('xoa-lich-hen-kham');
        try {
            $count = count($request->ids);
            Appointment::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true, 'message' => "Đã xóa thành công $count lịch hẹn khám!"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi xóa!']);
        }
    }


    public function markRead($id)
    {
        $appointment = Appointment::findOrFail($id);
        try {
            if ($appointment->is_viewed == 1) {
                $appointment->update(['is_viewed' => 0]);
                Session::flash('success', 'Đánh dấu là chưa đọc');
            } elseif ($appointment->is_viewed == 0) {
                $appointment->update(['is_viewed' => 1]);
                Session::flash('success', 'Đánh dấu là đã đọc');
            }
        } catch (\Exception) {
            Session::flash('error', 'Có lỗi');
        }
        return redirect()->back();
    }

    public function markReadAll(Request $request)
    {
        try {
            $count = count($request->ids);
            Appointment::whereIn('id', $request->ids)->where('is_viewed', 0)->update(['is_viewed' => 1]);
            return response()->json(['success' => true, 'message' => "$count lịch hẹn được đánh dấu là đã đọc!"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật!']);
        }
    }
    public function markUnreadAll(Request $request)
    {
        try {
            $count = count($request->ids);
            Appointment::whereIn('id', $request->ids)->where('is_viewed', 1)->update(['is_viewed' => 0]);
            return response()->json(['success' => true, 'message' => "$count lịch hẹn được đánh dấu là chưa đọc!"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật!']);
        }
    }

    public function confirm($id)
    {
        $this->authorize('xem-chi-tiet-lich-hen-kham');
        $appointment = Appointment::findOrFail($id);
        try {
            $appointment->update(['status' => 1]);
            Session::flash('success', 'Lịch hẹn khám đã được xác nhận');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi xác nhân');
        }
        return redirect()->back();
    }

    public function cancle($id)
    {
        $this->authorize('xem-chi-tiet-lich-hen-kham');
        $appointment = Appointment::findOrFail($id);
        try {
            $appointment->update(['status' => -1]);
            Session::flash('success', 'Lịch hẹn khám đã được hủy');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi hủy');
        }
        return redirect()->back();
    }

    public function page_reply($id)
    {
        $this->authorize('tra-loi-lich-hen-kham');
        $title = 'Phản hồi lịch hẹn khám';
        $appointment = Appointment::findOrFail($id);
        $admin = auth()->guard('admin')->user();
        if ($admin->hasRole('Bác sĩ')) {
            if ($admin->id == $appointment->doctor_id) {
                return view('admin.appointment.appointment-reply', compact('title', 'appointment'));
            } else abort(403);
        }
        return view('admin.appointment.appointment-reply', compact('title', 'appointment'));
    }

    public function reply(Request $request)
    {
        $this->authorize('tra-loi-lich-hen-kham');
        try {
            $appointment = Appointment::findOrFail($request->id);
            $title = $request->title;
            $content = $request->content;
            AppointmentReply::create([
                'title' => $title,
                'content' => $content,
                'admin_id' => auth()->guard('admin')->id(),
                'appointment_id' => $appointment->id
            ]);
            $appointment->update(['status' => $request->status]);
            Session::flash('success', 'Phản hồi lịch hẹn khám thành công');
            ContactReplyJob::dispatch($title, $request->email, $content)->delay(now()->addSecond(10));
            return redirect()->route('appointment.show', $appointment->id);
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi xảy ra khi phản hồi' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function unreadAppointments()
    {
        $this->authorize('xem-danh-sach-lich-hen-kham');
        $title = 'Danh sách lịch hẹn khám chưa đọc';
        $appointments = Appointment::where('is_viewed', 0)->orderByDesc('id')->paginate(15);
        return view('admin.appointment.unreadList', compact('title', 'appointments'));
    }
}
