<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicalServiceRequest;
use App\Models\Clinic;
use App\Models\MedicalService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MedicalServiceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-dich-vu-kham');
        $title = 'Danh sách dịch vụ khám';
        $medical_services = MedicalService::orderByDesc('id')->with('clinics')->paginate(15);
        return view('admin.medical_service.list', compact('title', 'medical_services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-dich-vu-kham');
        $title = 'Thêm dịch vụ khám';
        $clinics = Clinic::where('status', 1)->orderByDesc('id')->get();
        return view('admin.medical_service.create', compact('title', 'clinics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalServiceRequest $request)
    {
        $this->authorize('them-dich-vu-kham');
        try {
            $medical_service = MedicalService::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status
            ]);
            $medical_service->clinics()->attach($request->clinic_ids);
            Session::flash('success', 'Tạo dịch vụ khám thành công');
            return redirect()->route('medical-service.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('chinh-sua-dich-vu-kham');
        $medical_service = MedicalService::findOrFail($id);
        $title = 'Chỉnh sửa dịch vụ khám';
        $clinics = Clinic::where('status', 1)->orderByDesc('id')->get();
        $clinicsChecked = $medical_service->clinics->pluck('id')->toArray();
        return view('admin.medical_service.edit', compact('title', 'medical_service', 'clinics', 'clinicsChecked'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalServiceRequest $request, string $id)
    {
        $this->authorize('chinh-sua-dich-vu-kham');
        $medical_service = MedicalService::findOrFail($id);
        try {
            $medical_service->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status
            ]);
            $medical_service->clinics()->sync($request->clinic_ids);
            Session::flash('success', 'Cập nhật dịch vụ khám thành công');
            return redirect()->route('medical-service.index');
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
        $this->authorize('xoa-dich-vu-kham');
        $medical_service = MedicalService::findOrFail($id);
        try {
            $medical_service->delete();
            return response()->json(['success' => true, 'message' => 'Xóa dịch vụ khám thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa dịch vụ khám vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa dịch vụ khám: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
