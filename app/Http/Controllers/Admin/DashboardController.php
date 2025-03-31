<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalCertificate;
use App\Models\Patient;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Trang quản trị';
        $request->validate([
            'from_date' => ['nullable', 'date', 'before_or_equal:today'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
        ], [
            'from_date.before_or_equal' => 'Từ ngày không được vượt quá ngày hiện tại.',
            'to_date.after_or_equal' => 'Đến ngày phải lớn hơn hoặc bằng Từ ngày.',
        ]);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $filter_mode = $request->filter_mode;

        if ($filter_mode) {
            $now = Carbon::now();
            switch ($filter_mode) {
                case 'today':
                    $from_date = $to_date = $now->toDateString();
                    break;
                case 'this_week':
                    $from_date = $now->startOfWeek()->toDateString();
                    $to_date = $now->endOfWeek()->toDateString();
                    break;
                case 'this_month':
                    $from_date = $now->startOfMonth()->toDateString();
                    $to_date = $now->endOfMonth()->toDateString();
                    break;
                case 'this_year':
                    $from_date = $now->startOfYear()->toDateString();
                    $to_date = $now->endOfYear()->toDateString();
                    break;
            }
        }

        $patients = Patient::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('created_at', [$from_date, $to_date]);
        })->count();

        $appointments = Appointment::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('created_at', [$from_date, $to_date]);
        })->count();

        $totalRevenue = Prescription::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('created_at', [$from_date, $to_date]);
        })->sum('total_payment');

        $medical_certificates = MedicalCertificate::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('created_at', [$from_date, $to_date]);
        })->count();
        return view('admin.dashboard.dashboard', compact('title', 'patients', 'appointments', 'medical_certificates', 'totalRevenue'));
    }
}
