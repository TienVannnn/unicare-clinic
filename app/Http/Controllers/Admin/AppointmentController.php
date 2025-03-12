<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh sách lịch hẹn khám';
        $appointments = Appointment::orderByDesc('id')->paginate(15);
        return view('admin.appointment.list', compact('title', 'appointments'));
    }

    public function show(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->is_viewed == 0) $appointment->update(['is_viewed' => 1]);
        $replies = $appointment->appointmentReplies;
        $title = 'Chi tiết lịch hẹn khám';
        return view('admin.appointment.detail_appointment', compact('title', 'appointment', 'replies'));
    }

    public function destroy(string $id)
    {
        //
    }

    public function allDelete(Request $request)
    {
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
}
