<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManagerRequest;
use App\Jobs\MailAccountJob;
use App\Models\Admin;
use App\Models\Clinic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-nhan-vien');
        $title = 'Danh sách nhân viên';
        $managers = Admin::orderByDesc('id')->with('clinic')->paginate(15);
        return view('admin.manager.list', compact('title', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-nhan-vien');
        $title = 'Thêm mới nhân viên';
        $roles = Role::orderByDesc('id')->get();
        $clinics = Clinic::orderByDesc('id')->get();
        return view('admin.manager.create', compact('title', 'roles', 'clinics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManagerRequest $request)
    {
        $this->authorize('them-nhan-vien');
        try {
            DB::beginTransaction();
            $rand = rand(100000, 999999);
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($rand),
                'clinic_id' => $request->clinic
            ]);

            if ($request->has('role')) {
                $admin->assignRole($request->role);
            }
            DB::commit();
            Session::flash('success', 'Tạo nhân viên thành công');
            MailAccountJob::dispatch($admin, $rand)->delay(now()->addSecond(10));
            return redirect()->route('manager.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi tạo: ' . $e->getMessage());
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
        $this->authorize('chinh-sua-nhan-vien');
        $manager = Admin::find($id);
        if (!$manager) {
            abort('404');
        }
        $title = 'Chỉnh sửa người quản lý';
        $rolesChecked = $manager->roless->pluck('id')->toArray();
        $roles = Role::orderByDesc('id')->get();
        $clinics = Clinic::orderByDesc('id')->get();
        return view('admin.manager.edit', compact('title', 'manager', 'rolesChecked', 'roles', 'clinics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManagerRequest $request, string $id)
    {
        $this->authorize('chinh-sua-nhan-vien');
        $manager = Admin::find($id);
        if (!$manager) {
            abort('404');
        }
        try {
            DB::beginTransaction();
            $manager->fill([
                'name' => $request->name,
                'email' => $request->email,
                'clinic_id' => $request->clinic,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender
            ]);
            if ($request->password) {
                $manager->password = Hash::make($request->password);
            }
            $manager->save();
            $manager->syncRoles($request->role ?? []);
            DB::commit();
            Session::flash('success', 'Cập nhật nhân viên thành công');
            return redirect()->route('manager.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi chỉnh sửa: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-nhan-vien');
        $manager = Admin::find($id);
        if (!$manager) {
            abort('404');
        }
        try {
            $manager->delete();
            return response()->json(['success' => true, 'message' => 'Xóa nhân viên thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa nhân viên vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa nhân viên: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
