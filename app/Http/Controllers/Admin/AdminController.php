<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminExport;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManagerRequest;
use App\Jobs\MailAccountJob;
use App\Models\Admin;
use App\Models\Clinic;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
        $roles = Role::with('users')->orderByDesc('id')->get();
        $departments = Department::where('status', 1)->orderByDesc('id')->get();
        $clinics = Clinic::where('status', 1)->with(['doctors.roles'])->get();
        foreach ($clinics as $clinic) {
            $roleCounts = [];
            foreach ($clinic->doctors as $doctor) {
                foreach ($doctor->roles as $role) {
                    if (!isset($roleCounts[$role->name])) {
                        $roleCounts[$role->name] = 0;
                    }
                    $roleCounts[$role->name]++;
                }
            }
            $clinic->role_summary = $roleCounts;
        }
        return view('admin.manager.create', compact('title', 'roles', 'clinics', 'departments'));
    }

    public function getClinicsByDepartment($departmentId)
    {
        $clinics = Clinic::with(['doctors.roles'])->where('status', 1)->where('department_id', $departmentId)->get();
        $clinics->transform(function ($clinic) {
            $roleSummary = [];
            foreach ($clinic->doctors as $doctor) {
                foreach ($doctor->roles as $role) {
                    $roleSummary[$role->name] = ($roleSummary[$role->name] ?? 0) + 1;
                }
            }
            return [
                'id' => $clinic->id,
                'clinic_code' => $clinic->clinic_code,
                'name' => $clinic->name,
                'role_summary' => $roleSummary,
            ];
        });

        return response()->json($clinics);
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
                'slug' => Helper::createSlug($request->name),
                'email' => $request->email,
                'password' => Hash::make($rand),
                'clinic_id' => $request->clinic,
                'department_id' => $request->department,
                'status' => $request->status
            ]);
            $admin->schedule()->create([
                'morning_start' => '08:00',
                'morning_end' => '11:30',
                'afternoon_start' => '13:30',
                'afternoon_end' => '17:00',
                'slot_duration' => 15
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('chinh-sua-nhan-vien');
        $manager = Admin::with('schedule')->findOrFail($id);
        $title = 'Chỉnh sửa người quản lý';
        $rolesChecked = $manager->roless->pluck('id')->toArray();
        $roles = Role::orderByDesc('id')->get();
        $departments = Department::where('status', 1)->orderByDesc('id')->get();
        $clinics = Clinic::where('status', 1)->with(['doctors.roles'])->get();
        foreach ($clinics as $clinic) {
            $roleCounts = [];
            foreach ($clinic->doctors as $doctor) {
                foreach ($doctor->roles as $role) {
                    if (!isset($roleCounts[$role->name])) {
                        $roleCounts[$role->name] = 0;
                    }
                    $roleCounts[$role->name]++;
                }
            }
            $clinic->role_summary = $roleCounts;
        }
        return view('admin.manager.edit', compact('title', 'manager', 'rolesChecked', 'roles', 'clinics', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManagerRequest $request, string $id)
    {
        $this->authorize('chinh-sua-nhan-vien');
        $manager = Admin::findOrFail($id);
        try {
            DB::beginTransaction();
            $manager->fill([
                'name' => $request->name,
                'slug' => Helper::createSlug($request->name),
                'email' => $request->email,
                'clinic_id' => $request->clinic,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'department_id' => $request->department,
                'status' => $request->status
            ]);
            if ($request->password) {
                $manager->password = Hash::make($request->password);
            }
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $filename);

                if ($manager->avatar && file_exists(public_path($manager->avatar))) {
                    unlink(public_path($manager->avatar));
                }
                $manager->avatar = '/uploads/avatars/' . $filename;
            }
            $manager->save();
            $manager->syncRoles($request->role ?? []);
            $manager->schedule()->updateOrCreate(
                ['staff_id' => $manager->id],
                $request->only(['morning_start', 'morning_end', 'afternoon_start', 'afternoon_end', 'slot_duration'])
            );
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
        $manager = Admin::findOrFail($id);
        try {
            if ($manager->avatar) {
                $avatarPath = public_path($manager->avatar);
                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }
            $manager->delete();
            return response()->json(['success' => true, 'message' => 'Xóa nhân viên thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa bác sĩ vì có đơn thuốc liên quan.'
                : 'Có lỗi khi xóa nhân viên: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function export()
    {
        return Excel::download(new AdminExport, 'danh_sach_nhan_vien.xlsx');
    }
}
