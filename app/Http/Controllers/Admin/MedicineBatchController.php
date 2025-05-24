<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MedicineBatchExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicineBatchRequest;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MedicineBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batchs = MedicineBatch::with('medicine')->orderByDesc('expiry_date')->paginate(12);
        $title = 'Danh sách lô thuốc';
        return view('admin.medicine-batch.list', compact('title', 'batchs'));
    }

    public function medicine_batch(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        $batchs = $medicine->batches()->paginate(12);
        $title = 'Danh sách lô thuốc ' . $medicine->name;
        return view('admin.medicine-batch.list', compact('title', 'medicine', 'batchs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $batch = MedicineBatch::with('medicine')->findOrFail($id);
        $medicines = Medicine::where('status', 1)->orderByDesc('id')->get();
        $title = 'Chỉnh sửa lô thuốc ' . $batch->batch_number;
        return view('admin.medicine-batch.edit', compact('title', 'batch', 'medicines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineBatchRequest $request, string $id)
    {
        $batch = MedicineBatch::findOrFail($id);
        try {
            $batch->update($request->input());
            Session::flash('success', 'Chỉnh sửa lô thuốc thành công');
            return redirect()->route('medicine-batch.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa lô thuốc');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-thuoc');
        $batch = MedicineBatch::findOrFail($id);
        try {
            $batch->delete();
            return response()->json(['success' => true, 'message' => 'Xóa lô thuốc thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            return  response()->json(['success' => false, 'message' => 'Có lỗi khi xóa lô thuốc']);
        }
    }

    public function exportMedicineBatches()
    {
        return Excel::download(new MedicineBatchExport, 'lo-thuoc.xlsx');
    }
}
