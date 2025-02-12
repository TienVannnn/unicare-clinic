<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\MedicineCategory;
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

        if ($type === 'manager') {
            $managers = Admin::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm nhân viên';
            return view('admin.manager.list', compact('managers', 'title'));
        }

        if ($type === 'category') {
            $categories = MedicineCategory::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm loại thuốc';
            return view('admin.medicine-category.list', compact('categories', 'title'));
        }

        return abort(404);
    }
}
