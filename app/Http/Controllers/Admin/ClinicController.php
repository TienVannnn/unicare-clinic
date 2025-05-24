<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClinicExport;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClinicRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Clinic;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClinicController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-quyen');
        $title = 'Danh sách phòng khám';
        $clinics = Clinic::orderByDesc('id')->with('department')->paginate(15);
        return view('admin.clinic.list', compact('title', 'clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-quyen');
        $title = 'Thêm mới phòng khám';
        $departments = Department::where('status', 1)->orderByDesc('id')->get();
        return view('admin.clinic.create', compact('title', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicRequest $request)
    {
        $this->authorize('them-quyen');
        try {
            Clinic::create([
                'name' => $request->name,
                'department_id' => $request->department,
                'status' => $request->status
            ]);
            Session::flash('success', 'Thêm phòng khám thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi thêm phòng khám ' . $e->getMessage());
        }
        return redirect()->route('clinic.index');
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
        $this->authorize('chinh-sua-quyen');
        $clinic = Clinic::findOrFail($id);
        $title = 'Chỉnh sửa phòng khám ';
        $departments = Department::where('status', 1)->orderByDesc('id')->get();
        return view('admin.clinic.edit', compact('title', 'clinic', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClinicRequest $request, string $id)
    {
        $this->authorize('chinh-sua-quyen');
        try {
            $clinic = Clinic::find($id);
            if (!$clinic) abort(404);
            $clinic->update([
                'name' => $request->name,
                'department_id' => $request->department,
                'status' => $request->status
            ]);
            Session::flash('success', 'Cập nhật phòng khám thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa phòng khám ' . $e->getMessage());
        }
        return redirect()->route('clinic.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-quyen');
        $clinic = Clinic::find($id);
        if (!$clinic) abort(404);

        try {
            $clinic->delete();
            return response()->json(['success' => true, 'message' => 'Xóa phòng khám thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa phòng khám vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa phòng khám: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function export()
    {
        return Excel::download(new ClinicExport, 'danh_sach_phong_kham.xlsx');
    }
}
