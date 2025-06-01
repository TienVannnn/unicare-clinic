<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalCertificate;
use App\Models\MedicalService;
use App\Models\Patient;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $totalPrescriptionRevenue = Prescription::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('created_at', [$from_date, $to_date]);
        })->sum('total_payment');

        $totalMedicalRevenue = MedicalCertificate::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('created_at', [$from_date, $to_date]);
        })->sum('total_price');

        $totalRevenue = $totalPrescriptionRevenue + $totalMedicalRevenue;

        $medical_certificates = MedicalCertificate::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('created_at', [$from_date, $to_date]);
        })->count();

        $currentYear = Carbon::now()->year;
        $benhNhanTheoThang = Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $doanhThuThuoc = DB::table('prescriptions')
            ->selectRaw('MONTH(created_at) as month, SUM(total_payment) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month');

        $doanhThuGiayKham = DB::table('medical_certificates')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month');

        $doanhThuTheoThang = DB::table(DB::raw("({$doanhThuThuoc->toSql()} UNION ALL {$doanhThuGiayKham->toSql()}) as combined"))
            ->mergeBindings($doanhThuThuoc)
            ->mergeBindings($doanhThuGiayKham)
            ->selectRaw('month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $dichVuPhobien = MedicalService::select('medical_services.name', DB::raw('COUNT(medical_certificate_service.medical_service_id) as count'))
            ->leftJoin('medical_certificate_service', 'medical_services.id', '=', 'medical_certificate_service.medical_service_id')
            ->groupBy('medical_services.name')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'medical_services.name');

        $benhNhanMoi = Patient::whereDate('created_at', '>=', Carbon::now()->subMonth())->count();
        $benhNhanCu = Patient::whereDate('created_at', '<', Carbon::now()->subMonth())->count();

        $labels = collect(range(1, 12))->map(fn($m) => "Tháng $m");
        $benhNhanData = $labels->map(fn($_, $i) => $benhNhanTheoThang->firstWhere('month', $i + 1)->count ?? 0);
        $doanhThuData = $labels->map(fn($_, $i) => $doanhThuTheoThang->firstWhere('month', $i + 1)->total ?? 0);

        return view('admin.dashboard.dashboard', compact(
            'title',
            'patients',
            'appointments',
            'medical_certificates',
            'totalRevenue',
            'labels',
            'benhNhanData',
            'doanhThuData',
            'dichVuPhobien',
            'benhNhanMoi',
            'benhNhanCu'
        ));
    }
}
