<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Contact;
use App\Models\Department;
use App\Models\Faq;
use App\Models\MedicalCertificate;
use App\Models\MedicalService;
use App\Models\Medicine;
use App\Models\MedicineBatch;
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
        $perPage = 15;

        switch ($type) {
            case 'role':
                return $this->searchRoles($query, $title, $perPage);
            case 'permission':
                return $this->searchPermissions($query, $title, $perPage);
            case 'manager':
                return $this->searchManagers($query, $title, $perPage);
            case 'category':
                return $this->searchCategories($query, $title, $perPage);
            case 'medicine':
                return $this->searchMedicines($query, $title, $perPage);
            case 'medicine-batch':
                return $this->searchMedicineBatch($query, $title, $perPage);
            case 'department':
                return $this->searchDepartments($query, $title, $perPage);
            case 'clinic':
                return $this->searchClinics($query, $title, $perPage);
            case 'patient':
                return $this->searchPatients($query, $title, $perPage);
            case 'medical_service':
                return $this->searchMedicalServices($query, $title, $perPage);
            case 'prescription':
                return $this->searchPrescriptions($query, $title, $perPage);
            case 'medical_certificate':
                return $this->searchMedicalCertificates($query, $title, $perPage);
            case 'news_category':
                return $this->searchNewsCategory($query, $title, $perPage);
            case 'news':
                return $this->searchNews($query, $title, $perPage);
            case 'contact':
                return $this->searchContacts($query, $title, $perPage);
            case 'appointment':
                return $this->searchAppointments($query, $title, $perPage);
            case 'faq':
                return $this->searchFaqs($query, $title, $perPage);
            default:
                return abort(404);
        }
        return abort(404);
    }

    private function searchRoles($query, &$title, $perPage)
    {
        $roles = Role::when($query, function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
        })->orderByDesc('id')->paginate($perPage)->appends(request()->query());

        $title = 'Tìm kiếm vai trò';
        return view('admin.role.list', compact('roles', 'title'));
    }

    private function searchPermissions($query, &$title, $perPage)
    {
        $permissions = Permission::when($query, function ($q) use ($query) {
            $q->where('name_permission', 'like', '%' . $query . '%');
        })->orderByDesc('id')->paginate($perPage)->appends(request()->query());

        $title = 'Tìm kiếm quyền';
        return view('admin.permission.list', compact('permissions', 'title'));
    }

    private function searchManagers($query, &$title, $perPage)
    {
        $managers = Admin::when($query, function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->orWhereHas('roless', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orWhereHas('clinic', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                });
        })->orderByDesc('id')->paginate($perPage)->appends(request()->query());
        $title = 'Tìm kiếm nhân viên';
        return view('admin.manager.list', compact('managers', 'title'));
    }

    private function searchCategories($query, &$title, $perPage)
    {
        $categories = MedicineCategory::query();
        if (request()->filled('q')) {
            $categories->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }
        if (request()->filled('status')) {
            $categories->where('status', request('status'));
        }
        $categories = $categories->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm loại thuốc';
        return view('admin.medicine-category.list', compact('categories', 'title'));
    }

    private function searchMedicines($query, &$title, $perPage)
    {
        $medicines = Medicine::query();
        if (request()->filled('q')) {
            $medicines->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('medicine_code', 'like', '%' . $query . '%')
                    ->orWhere('unit', 'like', '%' . $query . '%')
                    ->orWhere('packaging', 'like', '%' . $query . '%')
                    ->orWhere('base_unit', 'like', '%' . $query . '%')
                    ->orWhere('sale_price', 'like', '%' . $query . '%')
                    ->orWhereHas('medicineCategories', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
        if (request()->filled('status')) {
            $medicines->where('status', request('status'));
        }
        $medicines = $medicines->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm thuốc';
        return view('admin.medicine.list', compact('medicines', 'title'));
    }

    private function searchMedicineBatch($query, &$title, $perPage)
    {
        $batchs = MedicineBatch::query();
        if (request()->filled('q')) {
            $batchs->where(function ($q) use ($query) {
                $q->where('manufacturer', 'like', '%' . $query . '%')
                    ->orWhere('production_address', 'like', '%' . $query . '%')
                    ->orWhere('manufacture_date', 'like', '%' . $query . '%')
                    ->orWhere('expiry_date', 'like', '%' . $query . '%')
                    ->orWhere('quantity_received', 'like', '%' . $query . '%')
                    ->orWhere('purchase_price', 'like', '%' . $query . '%')
                    ->orWhere('total_quantity', 'like', '%' . $query . '%')
                    ->orWhereHas('medicine', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
        $batchs = $batchs->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm lô thuốc';
        return view('admin.medicine-batch.list', compact('batchs', 'title'));
    }

    private function searchDepartments($query, &$title, $perPage)
    {
        $departments = Department::query();
        if (request()->filled('q')) {
            $departments->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }
        if (request()->filled('status')) {
            $departments->where('status', request('status'));
        }
        $departments = $departments->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm chuyên khoa';
        return view('admin.department.list', compact('departments', 'title'));
    }

    private function searchClinics($query, &$title, $perPage)
    {
        $clinics = Clinic::query();
        if (request()->filled('q')) {
            $clinics->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('clinic_code', 'like', '%' . $query . '%')
                    ->orWhereHas('doctors', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('department', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
        if (request()->filled('status')) {
            $clinics->where('status', request('status'));
        }
        $clinics = $clinics->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm phòng khám';
        return view('admin.clinic.list', compact('clinics', 'title'));
    }

    private function searchPatients($query, &$title, $perPage)
    {
        $patients = Patient::query();
        if (request()->filled('q')) {
            $patients->where(function ($q) use ($query) {
                $q->where('patient_code', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->orWhere('phone', 'like', '%' . $query . '%')
                    ->orWhere('address', 'like', '%' . $query . '%');
            });
        }
        if (request()->filled('dob')) {
            $patients->whereDate('dob', request('dob'));
        }
        if (request()->filled('gender')) {
            $patients->where('gender', request('gender'));
        }
        $patients = $patients->orderByDesc('id')->paginate(15)->appends(request()->query());;
        $title = 'Tìm kiếm bệnh nhân';
        return view('admin.patient.list', compact('patients', 'title'));
    }

    private function searchMedicalCertificates($query, &$title, $perPage)
    {
        $certificates = MedicalCertificate::query();
        if (request()->filled('q')) {
            $certificates->where(function ($q) use ($query) {
                $q->where('medical_certificate_code', 'like', '%' . $query . '%')
                    ->orWhereHas('patient', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%')
                            ->orWhere('phone', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('doctor', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('clinic', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
        if (request()->filled('medical_time')) {
            $certificates->whereDate('medical_time', request('medical_time'));
        }
        if (request()->filled('medical_status')) {
            $certificates->where('medical_status', request('medical_status'));
        }
        if (request()->filled('payment_status')) {
            $certificates->where('payment_status', request('payment_status'));
        }
        $medical_certificates = $certificates->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm giấy khám bệnh';
        return view('admin.medical-certificate.list', compact('medical_certificates', 'title'));
    }

    private function searchMedicalServices($query, &$title, $perPage)
    {
        $medical_services = MedicalService::query();
        if (request()->filled('q')) {
            $medical_services->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('medical_service_code', 'like', '%' . $query . '%')
                    ->orWhereHas('clinics', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
        if (request()->filled('status')) {
            $medical_services->where('status', request('status'));
        }
        $medical_services = $medical_services->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm dịch vụ khám';
        return view('admin.medical_service.list', compact('medical_services', 'title'));
    }

    private function searchPrescriptions($query, &$title, $perPage)
    {
        $prescriptions = Prescription::query();
        if (request()->filled('q')) {
            $prescriptions->where(function ($q) use ($query) {
                $q->where('prescription_code', 'like', '%' . $query . '%')
                    ->orWhereHas('doctor', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('medical_certificate', function ($q) use ($query) {
                        $q->where('medical_certificate_code', 'like', '%' . $query . '%')
                            ->orWhereHas('patient', function ($subQuery) use ($query) {
                                $subQuery->where('name', 'like', '%' . $query . '%');
                            });
                    });
            });
        }
        if (request()->filled('status')) {
            $prescriptions->where('status', request('status'));
        }
        $prescriptions = $prescriptions->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm đơn thuốc';
        return view('admin.prescription.list', compact('prescriptions', 'title'));
    }

    private function searchNewsCategory($query, &$title, $perPage)
    {
        $categories = NewsCategory::query();
        if (request()->filled('q')) {
            $categories->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            });
        }
        if (request()->filled('status')) {
            $categories->where('status', request('status'));
        }
        $categories = $categories->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm danh mục tin tức';
        return view('admin.news-category.list', compact('categories', 'title'));
    }

    private function searchNews($query, &$title, $perPage)
    {
        $news = News::query();
        if (request()->filled('q')) {
            $news->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhereHas('poster', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('newsCategories', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
        if (request()->filled('status')) {
            $news->where('status', request('status'));
        }
        if (request()->filled('filter_mode')) {
            switch (request('filter_mode')) {
                case 'today':
                    $news->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $news->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $news->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;
                case 'this_year':
                    $news->whereYear('created_at', now()->year);
                    break;
            }
        }
        $news = $news->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm tin tức';
        return view('admin.news.list', compact('news', 'title'));
    }

    private function searchContacts($query, &$title, $perPage)
    {
        $contacts = Contact::query();
        if (request()->filled('q')) {
            $contacts->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            });
        }

        if (request()->filled('date')) {
            $contacts->whereDate('created_at', request('date'));
        }

        if (request()->filled('status')) {
            $contacts->where('status', request('status'));
        }

        if (request()->filled('filter_mode')) {
            switch (request('filter_mode')) {
                case 'today':
                    $contacts->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $contacts->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $contacts->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;
                case 'this_year':
                    $contacts->whereYear('created_at', now()->year);
                    break;
            }
        }

        $contacts = $contacts->orderByDesc('id')->paginate($perPage)->appends(request()->query());

        $title = 'Tìm kiếm liên hệ';
        return view('admin.contact.list', compact('contacts', 'title'));
    }


    private function searchAppointments($query, &$title, $perPage)
    {
        $appointments = Appointment::query();
        if (request()->filled('q')) {
            $appointments->where(function ($q) use ($query) {
                $q->where('phone', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%')
                    ->orWhereHas('department', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('doctor', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    })
                ;
            });
        }

        if (request()->filled('date')) {
            $appointments->whereDate('created_at', request('date'));
        }

        if (request()->filled('status')) {
            $appointments->where('status', request('status'));
        }


        if (request()->filled('is_viewed')) {
            $appointments->where('is_viewed', request('is_viewed'));
        }


        if (request()->filled('filter_mode')) {
            switch (request('filter_mode')) {
                case 'today':
                    $appointments->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $appointments->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $appointments->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;
                case 'this_year':
                    $appointments->whereYear('created_at', now()->year);
                    break;
            }
        }

        $appointments = $appointments->orderByDesc('id')->paginate($perPage)->appends(request()->query());
        $title = 'Tìm kiếm lịch hẹn khám';
        return view('admin.appointment.list', compact('appointments', 'title'));
    }

    private function searchFaqs($query, &$title, $perPage)
    {
        $faqs = Faq::query();
        if (request()->filled('q')) {
            $faqs->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                        $q->orWhere('email', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('department', function ($q) use ($query) {
                        $q->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
        if (request()->filled('status')) {
            if (request('status') == 1) {
                $faqs->whereNotNull('answer');
            } elseif (request('status') == 0) {
                $faqs->whereNull('answer');
            }
        }

        if (request()->filled('date')) {
            $faqs->whereDate('created_at', request('date'));
        }
        $faqs = $faqs->orderByDesc('id')->paginate(15)->appends(request()->query());
        $title = 'Tìm kiếm loại thuốc';
        return view('admin.faq.list', compact('faqs', 'title'));
    }
}
