<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicineRequest;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MedicineController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-thuoc');
        $title = 'Danh sách thuốc';
        $medicines = Medicine::orderByDesc('id')->with('medicineCategories')->paginate(15);
        return view('admin.medicine.list', compact('title', 'medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-thuoc');
        $title = 'Thêm thuốc';
        $medicineCategories = MedicineCategory::orderByDesc('id')->get();
        return view('admin.medicine.create', compact('title', 'medicineCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineRequest $request)
    {
        $this->authorize('them-thuoc');
        try {
            $medicine = Medicine::create($request->except('medicine_categories'));
            $medicine->medicineCategories()->sync($request->medicine_categories);
            Session::flash('success', 'Tạo thuốc thành công');
            return redirect()->route('medicine.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi tạo');
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
        $this->authorize('chinh-sua-thuoc');
        $medicine = Medicine::findOrFail($id);
        $title = 'Chỉnh sửa thuốc';
        $medicineCategories = MedicineCategory::orderByDesc('id')->get();
        return view('admin.medicine.edit', compact('title', 'medicine', 'medicineCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineRequest $request, string $id)
    {
        $this->authorize('chinh-sua-thuoc');
        $medicine = Medicine::findOrFail($id);
        try {
            $medicine->update($request->except('medicine_categories'));
            $medicine->medicineCategories()->sync($request->medicine_categories);
            Session::flash('success', 'Cập nhật thuốc thành công');
            return redirect()->route('medicine.index');
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
        $this->authorize('xoa-thuoc');
        $medicine = Medicine::findOrFail($id);
        try {
            $medicine->delete();
            return response()->json(['success' => true, 'message' => 'Xóa thuốc thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa thuốc vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa thuốc: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
