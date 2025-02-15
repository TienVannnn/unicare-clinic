<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\Patient;
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

        if ($type === 'medicine') {
            $medicines = Medicine::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm thuốc';
            return view('admin.medicine.list', compact('medicines', 'title'));
        }

        if ($type === 'department') {
            $departments = Department::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm chuyên khoa';
            return view('admin.department.list', compact('departments', 'title'));
        }

        if ($type === 'clinic') {
            $clinics = Clinic::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm phòng khám';
            return view('admin.clinic.list', compact('clinics', 'title'));
        }
        if ($type === 'patient') {
            $patients = Patient::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm bệnh nhân';
            return view('admin.patient.list', compact('patients', 'title'));
        }

        return abort(404);
    }
}
