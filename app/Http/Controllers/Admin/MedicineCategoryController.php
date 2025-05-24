<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MedicineCategoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicineCategoryRequest;
use App\Models\MedicineCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MedicineCategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-loai-thuoc');
        $title = 'Danh sách loại thuốc';
        $categories = MedicineCategory::with('medicines')->orderByDesc('id')->paginate(15);
        return view('admin.medicine-category.list', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-loai-thuoc');
        $title = 'Thêm mới loại thuốc';
        return view('admin.medicine-category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineCategoryRequest $request)
    {
        $this->authorize('them-loai-thuoc');
        try {
            MedicineCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status
            ]);
            Session::flash('success', 'Tạo loại thuốc thành công');
            return redirect()->route('medicine-category.index');
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
        $this->authorize('chinh-sua-loai-thuoc');
        $category = MedicineCategory::findOrFail($id);
        $title = 'Chỉnh sửa loại thuốc';
        return view('admin.medicine-category.edit', compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineCategoryRequest $request, string $id)
    {
        $this->authorize('chinh-sua-loai-thuoc');
        $category = MedicineCategory::find($id);
        if (!$category) abort(404);
        try {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status
            ]);
            Session::flash('success', 'Cập nhật loại thuốc thành công');
            return redirect()->route('medicine-category.index');
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
        $this->authorize('xoa-loai-thuoc');
        $category = MedicineCategory::find($id);
        if (!$category) abort(404);
        try {
            $category->delete();
            return response()->json(['success' => true, 'message' => 'Xóa loại thuốc thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa loại thuốc vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa loại thuốc: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function exportMedicineCategories()
    {
        return Excel::download(new MedicineCategoryExport, 'loai-thuoc.xlsx');
    }
}
