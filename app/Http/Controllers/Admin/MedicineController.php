<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MedicineExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicineEditRequest;
use App\Http\Requests\Admin\MedicineRequest;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\MedicineCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

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
        $medicineCategories = MedicineCategory::where('status', 1)->orderByDesc('id')->get();
        return view('admin.medicine.create', compact('title', 'medicineCategories'));
    }

    public function checkCode(Request $request)
    {
        $code = $request->query('code');
        $medicine = Medicine::with('medicineCategories')->where('medicine_code', $code)->first();
        if ($medicine) {
            return response()->json([
                'exists' => true,
                'medicine' => [
                    'name' => $medicine->name,
                    'ingredient' => $medicine->ingredient,
                    'dosage_strength' => $medicine->dosage_strength,
                    'unit' => $medicine->unit,
                    'packaging' => $medicine->packaging,
                    'base_unit' => $medicine->base_unit,
                    'quantity_per_unit' => $medicine->quantity_per_unit,
                    'sale_price' => $medicine->sale_price,
                    'categories' => $medicine->medicineCategories->pluck('id')->toArray(),
                ]
            ]);
        }
        return response()->json(['exists' => false]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineRequest $request)
    {
        $this->authorize('them-thuoc');
        DB::beginTransaction();
        try {
            $medicine = Medicine::where('medicine_code', $request->medicine_code)->first();
            if (!$medicine) {
                $medicine = Medicine::create([
                    'name' => $request->input('name'),
                    'medicine_code' => $request->input('medicine_code'),
                    'ingredient' => $request->input('ingredient'),
                    'dosage_strength' => $request->input('dosage_strength'),
                    'unit' => $request->input('unit'),
                    'packaging' => $request->input('packaging'),
                    'base_unit' => $request->input('base_unit'),
                    'quantity_per_unit' => $request->input('quantity_per_unit'),
                    'sale_price' => $request->input('sale_price'),
                    'status' => $request->input('status'),
                ]);
                $medicine->medicineCategories()->sync($request->medicine_categories);
            }
            MedicineBatch::create([
                'medicine_id' => $medicine->id,
                'manufacturer' => $request->input('manufacturer'),
                'production_address' => $request->input('production_address'),
                'manufacture_date' => $request->input('manufacture_date'),
                'expiry_date' => $request->input('expiry_date'),
                'quantity_received' => $request->input('quantity_received'),
                'purchase_price' => $request->input('purchase_price'),
                'total_quantity' => $request->quantity_per_unit * $request->quantity_received,
            ]);
            DB::commit();
            Session::flash('success', 'Thêm thuốc và lô thuốc thành công');
            return redirect()->route('medicine.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi tạo ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        $batchs = $medicine->batches()->paginate(12);
        $title = 'Danh sách lô thuốc ' . $medicine->name;
        return view('admin.medicine.medicine_batch', compact('title', 'medicine', 'batchs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('chinh-sua-thuoc');
        $medicine = Medicine::findOrFail($id);
        $title = 'Chỉnh sửa thuốc';
        $medicineCategories = MedicineCategory::where('status', 1)->orderByDesc('id')->get();
        return view('admin.medicine.edit', compact('title', 'medicine', 'medicineCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineEditRequest $request, string $id)
    {
        $this->authorize('chinh-sua-thuoc');
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->update([
                'name' => $request->input('name'),
                'medicine_code' => $request->input('medicine_code'),
                'ingredient' => $request->input('ingredient'),
                'dosage_strength' => $request->input('dosage_strength'),
                'unit' => $request->input('unit'),
                'packaging' => $request->input('packaging'),
                'base_unit' => $request->input('base_unit'),
                'quantity_per_unit' => $request->input('quantity_per_unit'),
                'sale_price' => $request->input('sale_price'),
                'status' => $request->input('status'),
            ]);
            $medicine->medicineCategories()->sync($request->medicine_categories);
            DB::commit();
            Session::flash('success', 'Thêm thuốc và lô thuốc thành công');
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

    public function exportMedicines()
    {
        return Excel::download(new MedicineExport, 'danh-sach-thuoc.xlsx');
    }
}
