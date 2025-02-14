<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClinicRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Clinic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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
        $clinics = Clinic::orderByDesc('id')->paginate(15);
        return view('admin.clinic.list', compact('title', 'clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-quyen');
        $title = 'Thêm mới phòng khám';
        return view('admin.clinic.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicRequest $request)
    {
        $this->authorize('them-quyen');
        try {
            Clinic::create([
                'name' => $request->name
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
        $clinic = Clinic::find($id);
        if (!$clinic) abort(404);
        $title = 'Chỉnh sửa phòng khám ';
        return view('admin.clinic.edit', compact('title', 'clinic'));
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
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi xóa phòng khám ' . $e->getMessage());
        }
        return redirect()->back();
    }
}
