<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PatientRequest;
use App\Models\Patient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-benh-nhan');
        $title = 'Danh sách bệnh nhân';
        $patients = Patient::orderByDesc('id')->paginate(15);
        return view('admin.patient.list', compact('title', 'patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-benh-nhan');
        $title = 'Thêm bệnh nhân';
        return view('admin.patient.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $this->authorize('them-benh-nhan');
        try {
            Patient::create($request->input());
            Session::flash('success', 'Thêm bệnh nhân thành công');
            return redirect()->route('patient.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi tạo' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);
        $medical_history = $patient->medical_certificates()->paginate(15);
        $title = 'Lịch sử khám bệnh - ' . $patient->name;
        return view('admin.patient.show', compact('title', 'patient', 'medical_history'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('chinh-sua-benh-nhan');
        $patient = Patient::findOrFail($id);
        $title = 'Chỉnh sửa bệnh nhân';
        return view('admin.patient.edit', compact('title', 'patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, string $id)
    {
        $this->authorize('chinh-sua-benh-nhan');
        $patient = Patient::findOrFail($id);
        try {
            $patient->update($request->input());
            Session::flash('success', 'Cập nhật bệnh nhân thành công');
            return redirect()->route('patient.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-benh-nhan');
        $patient = Patient::findOrFail($id);
        try {
            $patient->delete();
            return response()->json(['success' => true, 'message' => 'Xóa bệnh nhân thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa bệnh nhân vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa bệnh nhân: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
