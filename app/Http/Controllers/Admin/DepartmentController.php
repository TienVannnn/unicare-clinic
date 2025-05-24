<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DepartmentExport;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-chuyen-khoa');
        $title = 'Danh sách chuyên khoa';
        $departments = Department::orderByDesc('id')->paginate(15);
        return view('admin.department.list', compact('title', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-chuyen-khoa');
        $title = 'Thêm mới chuyên khoa';
        return view('admin.department.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $this->authorize('them-chuyen-khoa');
        try {
            Department::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status
            ]);
            Session::flash('success', 'Thêm chuyên khoa thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi thêm chuyên khoa ' . $e->getMessage());
        }
        return redirect()->route('department.index');
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
        $this->authorize('chinh-sua-chuyen-khoa');
        $department = Department::findOrFail($id);
        $title = 'Chỉnh sửa chuyên khoa ';
        return view('admin.department.edit', compact('title', 'department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, string $id)
    {
        $this->authorize('chinh-sua-chuyen-khoa');
        try {
            $department = Department::find($id);
            if (!$department) abort(404);
            $department->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status
            ]);
            Session::flash('success', 'Cập nhật chuyên khoa thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa chuyên khoa ' . $e->getMessage());
        }
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-chuyen-khoa');
        $department = Department::find($id);
        if (!$department) abort(404);
        try {
            $department->delete();
            return response()->json(['success' => true, 'message' => 'Xóa chuyên khoa thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa chuyên khoa vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa chuyên khoa: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function export()
    {
        return Excel::download(new DepartmentExport, 'danh_sach_chuyen_khoa.xlsx');
    }
}
