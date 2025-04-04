<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Contact;
use App\Models\Department;
use App\Models\MedicalCertificate;
use App\Models\MedicalService;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Patient;
use App\Models\Permission;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    public function search(Request $request, $type)
    {
        $query = $request->input('q');
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
            $patients = Patient::query();
            $filters = request()->only(['q', 'dob', 'gender']);
            if (!empty($filters['q'])) {
                $patients->where(function ($query) use ($filters) {
                    $query->where('name', 'like', "%" . $filters['q'] . "%")
                        ->orWhere('patient_code', 'like', "%" . $filters['q'] . "%")
                        ->orWhere('phone', 'like', "%" . $filters['q'] . "%")
                        ->orWhere('address', 'like', "%" . $filters['q'] . "%");
                });
            }
            if (!empty($filters['dob'])) {
                $patients->whereDate('dob', $filters['dob']);
            }
            if (isset($filters['gender']) && $filters['gender'] !== '') {
                $patients->where('gender', $filters['gender']);
            }
            $patients = $patients->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm bệnh nhân';
            return view('admin.patient.list', compact('patients', 'title'));
        }

        if ($type === 'medical_service') {
            $medical_services = MedicalService::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm dịch vụ khám';
            return view('admin.medical_service.list', compact('medical_services', 'title'));
        }

        if ($type === 'prescription') {
            $prescriptions = Prescription::where('prescription_code', 'like', "%$query%")->with('medical_certificate', 'doctor')->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm đơn thuốc';
            return view('admin.prescription.list', compact('prescriptions', 'title'));
        }

        if ($type === 'medical_certificate') {
            $medical_certificates = MedicalCertificate::where('medical_certificate_code', 'like', "%$query%")->with('patient', 'doctor')->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm giấy khám bệnh';
            return view('admin.medical-certificate.list', compact('medical_certificates', 'title'));
        }
        if ($type === 'news-category') {
            $categories = NewsCategory::where('name', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm danh mục tin tức';
            return view('admin.news-category.list', compact('categories', 'title'));
        }
        if ($type === 'news') {
            $news = News::where('title', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm tin tức';
            return view('admin.news.list', compact('news', 'title'));
        }

        if ($type === 'contact') {
            $contacts = Contact::where('title', 'like', "%$query%")->orderByDesc('id')->paginate(15);
            $title = 'Tìm kiếm tin nhắn liên hệ';
            return view('admin.contact.list', compact('contacts', 'title'));
        }

        if ($type === 'appointment') {
            $appointments = Appointment::where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%")
                    ->orWhere('phone', 'like', "%$query%");
            })
                ->orWhereHas('department', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                })
                ->orWhereHas('doctor', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                })
                ->orderByDesc('id')
                ->paginate(15);
            $title = 'Tìm kiếm lịch hẹn khám';
            return view('admin.appointment.list', compact('appointments', 'title'));
        }


        return abort(404);
    }
}
