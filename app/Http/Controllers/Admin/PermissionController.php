<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-sach-quyen');
        $title = 'Danh sách quyền truy cập';
        $permissions = Permission::orderByDesc('id')->paginate(15);
        return view('admin.permission.list', compact('title', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-quyen');
        $title = 'Thêm mới quyền truy cập';
        return view('admin.permission.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $this->authorize('them-quyen');
        try {
            Permission::create([
                'name_permission' => $request->name_permission,
                'name' => Helper::createSlug($request->name_permission)
            ]);
            Session::flash('success', 'Thêm quyền thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi thêm quyền ' . $e->getMessage());
        }
        return redirect()->route('permission.index');
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
        $permission = Permission::find($id);
        if (!$permission) abort(404);
        $title = 'Chỉnh sửa quyền ';
        return view('admin.permission.edit', compact('title', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, string $id)
    {
        $this->authorize('chinh-sua-quyen');
        try {
            $permission = Permission::find($id);
            if (!$permission) abort(404);
            $permission->update([
                'name_permission' => $request->name_permission,
                'name' => Helper::createSlug($request->name_permission)
            ]);
            Session::flash('success', 'Cập nhật quyền thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa quyền ' . $e->getMessage());
        }
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-quyen');
        $permission = Permission::find($id);
        if (!$permission) abort(404);
        try {
            $permission->delete();
            return response()->json(['success' => true, 'message' => 'Xóa quyền thành công.']);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = ($e->getCode() == 23000)
                ? 'Không thể xóa quyền vì có dữ liệu liên quan.'
                : 'Có lỗi khi xóa quyền: ' . $e->getMessage();
            return  response()->json(['success' => false, 'message' => $message]);
        }
    }
}
