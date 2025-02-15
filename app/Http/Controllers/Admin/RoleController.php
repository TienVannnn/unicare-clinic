<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-vai-tro');
        $title = 'Danh sách vai trò';
        $roles = Role::orderByDesc('id')->paginate(15);
        return view('admin.role.list', compact('title', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-vai-tro');
        $title = 'Thêm vai trò';
        $permissions = Permission::orderByDesc('id')->get();
        return view('admin.role.create', compact('title', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('them-vai-tro');
        try {
            DB::beginTransaction();
            $role = Role::create(['name' => $request->name]);
            if ($request->has('permission_id')) {
                $permissions = Permission::whereIn('id', $request->input('permission_id'))->get();
                $role->syncPermissions($permissions);
            }
            DB::commit();
            Session::flash('success', 'Thêm vai trò thành cống');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi thêm vai trò ' . $e->getMessage());
        }
        return redirect()->route('role.index');
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
        $this->authorize('chinh-sua-vai-tro');
        $role = Role::find($id);
        if (!$role) abort(404);
        $permissions = Permission::orderByDesc('id')->get();
        $permissionChecked = $role->permissions;
        $title = 'Chỉnh sửa vai trò';
        return view('admin.role.edit', compact('title', 'role', 'permissions', 'permissionChecked'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $this->authorize('chinh-sua-vai-tro');
        try {
            $role = Role::find($id);
            if (!$role) abort(404);
            $role->update(['name' => $request->name]);
            $permissions = Permission::whereIn('id', $request->input('permission_id', []))->get();
            $role->syncPermissions($permissions);
            Session::flash('success', 'Cập nhật vai trò thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi cập nhật vai trò ' . $e->getMessage());
        }
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-vai-tro');
        $role = Role::find($id);
        if (!$role) abort(404);
        try {
            $role->delete();
            return response()->json(['success' => true, 'message' => 'Xóa vai trò thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa vai trò vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa vai trò: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
