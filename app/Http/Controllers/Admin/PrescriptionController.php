<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrescriptionRequest;
use App\Models\Admin;
use App\Models\MedicalCertificate;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrescriptionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-don-thuoc');
        $title = 'Danh sách đơn thuốc';
        $prescriptions = Prescription::with('medical_certificate', 'doctor')->orderByDesc('id')->paginate(15);
        return view('admin.prescription.list', compact('prescriptions', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-don-thuoc');
        $title = 'Thêm đơn thuốc';
        $doctors = Admin::role('Bác sĩ')->get();
        $medicines = Medicine::orderByDesc('id')->get();
        $medical_certificates = MedicalCertificate::orderByDesc('id')->get();
        return view('admin.prescription.create', compact('doctors', 'medicines', 'title', 'medical_certificates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionRequest $request)
    {
        $this->authorize('them-don-thuoc');
        try {
            $totalPayment = 0;
            $prescription = Prescription::create([
                'medical_certificate_id' => $request->medical_certificate_id,
                'doctor_id' => auth()->guard('admin')->id(),
                'note' => $request->note,
                'status' => 0,
                'total_payment' => 0,
            ]);

            if (!empty($request->medicines)) {
                foreach ($request->medicines as $medicine) {
                    $med = Medicine::find($medicine['medicine']);
                    if ($med) {
                        $subtotal = $med->price * $medicine['quantity'];
                        $totalPayment += $subtotal;
                        $prescription->medicines()->attach($medicine['medicine'], [
                            'quantity' => $medicine['quantity'],
                            'dosage' => $medicine['dosage'],
                            'price' => $med->price,
                            'subtotal' => $subtotal,
                        ]);
                    }
                }
            }

            $prescription->update(['total_payment' => $totalPayment]);

            Session::flash('success', 'Đơn thuốc đã được lưu thành công');
            return response()->json([
                'success' => true,
                'message' => 'Đơn thuốc đã được lưu thành công.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra.',
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Chi tiết đơn thuốc';
        $prescription = Prescription::with('doctor', 'medicines', 'medical_certificate')->findOrFail($id);
        return view('admin.prescription.show', compact('prescription', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('chinh-sua-don-thuoc');
        $title = 'Chỉnh sửa đơn thuốc';
        $prescription = Prescription::with('doctor', 'medicines', 'medical_certificate')->findOrFail($id);
        $medical_certificates = MedicalCertificate::orderByDesc('id')->get();
        $doctors = Admin::role('Bác sĩ')->get();
        $medicines = Medicine::orderByDesc('id')->get();
        return view('admin.prescription.edit', compact('prescription', 'doctors', 'medicines', 'title', 'medical_certificates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionRequest $request, string $id)
    {
        $this->authorize('chinh-sua-don-thuoc');
        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->update([
                'medical_certificate_id' => $request->medical_certificate_id,
                'doctor_id' => auth()->guard('admin')->id(),
                'note' => $request->note
            ]);
            $prescription->medicines()->detach();
            $totalPayment = 0;
            if (!empty($request->medicines)) {
                foreach ($request->medicines as $medicine) {
                    $med = Medicine::find($medicine['medicine']);
                    if ($med) {
                        $subtotal = $med->price * $medicine['quantity'];
                        $totalPayment += $subtotal;
                        $prescription->medicines()->attach($medicine['medicine'], [
                            'quantity' => $medicine['quantity'],
                            'dosage' => $medicine['dosage'],
                            'price' => $med->price,
                            'subtotal' => $subtotal,
                        ]);
                    }
                }
            }
            $prescription->update(['total_payment' => $totalPayment]);

            Session::flash('success', 'Cập nhật đơn thuốc thành công');
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật đơn thuốc thành công.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật đơn thuốc.',
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-don-thuoc');
        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->delete();
            return response()->json(['success' => true, 'message' => 'Xóa đơn thuốc thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi khi xóa đơn thuốc']);
        }
    }

    public function payment_confirm($id)
    {
        $this->authorize('xac-nhan-thanh-toan');
        $prescription = Prescription::findOrFail($id);
        if ($prescription->status == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn thuốc này đã được thanh toán trước đó.'
            ]);
        }
        if ($prescription->total_payment <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể thanh toán tổng tiền không hợp lệ.'
            ]);
        }
        try {
            $prescription->update(['status' => 1]);
            return response()->json([
                'success' => true,
                'message' => 'Đơn thuốc đã thanh toán thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thanh toán đơn thuốc.'
            ]);
        }
    }

    public function print($id)
    {
        $prescription = Prescription::findOrFail($id);
        $pdf = Pdf::loadView('admin.prescription.print', compact('prescription'));
        return $pdf->stream('don-thuoc.pdf');
    }

    public function getPatient(Request $request)
    {
        try {
            $medicalCertificate = MedicalCertificate::with('patient')->find($request->id);

            if (!$medicalCertificate || !$medicalCertificate->patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy bệnh nhân'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'patient' => $medicalCertificate->patient
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ], 500);
        }
    }
}
