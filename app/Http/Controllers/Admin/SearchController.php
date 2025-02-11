<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    public function search(Request $request, $type)
    {
        $query = $request->input('name');
        $title = '';

        if ($type === 'role') {
            $roles = Role::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm vai trò';
            return view('admin.role.list', compact('roles', 'title'));
        }

        if ($type === 'permission') {
            $permissions = Permission::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm quyền';
            return view('admin.permission.list', compact('permissions', 'title'));
        }

        return abort(404);
    }
}
