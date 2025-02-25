<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MedicalCertificateController;
use App\Http\Controllers\Admin\MedicalServiceController;
use App\Http\Controllers\Admin\MedicineCategoryController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin/login', [AuthController::class, 'login_form'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('handleLoginAdmin');
Route::get('/admin/forgot-password', [AuthController::class, 'forgot_password'])->name('admin.forgotpassword');
Route::post('/admin/forgot-password', [AuthController::class, 'handle_forgot_password'])->name('admin.handle_forgot_password');
Route::get('/admin/recovery-password', [AuthController::class, 'recovery_password'])->name('admin.form_recovery');
Route::post('/admin/recovery-password', [AuthController::class, 'hanle_recovery_password'])->name('admin.handle_recovery');

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::prefix('/profile')->group(function () {
        Route::get('/', [AuthController::class, 'profile'])->name('admin.profile');
        Route::post('/change-avatar', [AuthController::class, 'change_avatar'])->name('admin.change-avatar');
        Route::get('/edit-account', [AuthController::class, 'edit_account'])->name('admin.edit-account');
        Route::post('/edit-account', [AuthController::class, 'handle_edit_account'])->name('admin.handle_edit-account');
        Route::get('/change-password', [AuthController::class, 'change_password'])->name('admin.change-password');
        Route::post('/change-password', [AuthController::class, 'handle_change_password'])->name('admin.handle_change-password');
    });
    Route::get('/{type}/search', [SearchController::class, 'search'])->name('admin.search');
    Route::resource('/permission', PermissionController::class);
    Route::resource('/role', RoleController::class);
    Route::resource('/manager', AdminController::class);
    Route::resource('/medicine-category', MedicineCategoryController::class);
    Route::resource('/medicine', MedicineController::class);
    Route::resource('/department', DepartmentController::class);
    Route::resource('/clinic', ClinicController::class);
    Route::resource('/patient', PatientController::class);
    Route::resource('/medical-service', MedicalServiceController::class);
    Route::resource('/prescription', PrescriptionController::class);
    Route::post('prescription/{id}/payment', [PrescriptionController::class, 'payment_confirm'])->name('prescription.pay');
    Route::get('prescription/{id}/print', [PrescriptionController::class, 'print'])->name('prescription.print');
    Route::get('/medical-certificate/patient', [PrescriptionController::class, 'getPatient'])
        ->name('medical-certificate.get-patient');

    Route::resource('/medical-certificate', MedicalCertificateController::class);
    Route::post('medical-certificate/{id}/payment', [MedicalCertificateController::class, 'payment_confirm'])->name('medical-certificate.pay');
    Route::post('medical-certificate/{id}/payment-advance', [MedicalCertificateController::class, 'payment_advance'])->name('medical-certificate.pay-advance');
    Route::get('medical-certificate/{id}/print', [MedicalCertificateController::class, 'print'])->name('medical-certificate.print');
    Route::get('medical-certificate/{id}/print_advance', [MedicalCertificateController::class, 'print_advance'])->name('medical-certificate.print-advance');
    Route::get('medical-certificate/{id}/service', [MedicalCertificateController::class, 'service'])->name('medical-certificate.service');
    Route::post('medical-certificate/{id}/service', [MedicalCertificateController::class, 'service_exam'])->name('medical-certificate.service-exam');
    Route::get('medical-certificate/{id}/conclude', [MedicalCertificateController::class, 'conclude'])->name('medical-certificate.conclude');
    Route::post('medical-certificate/{id}/conclude', [MedicalCertificateController::class, 'conclude_handle'])->name('medical-certificate.conclude-handle');
    Route::get('/get-clinics-by-service', [MedicalCertificateController::class, 'getClinicsByService'])->name('get-clinics-by-service');
    Route::get('/get-doctors-by-clinic', [MedicalCertificateController::class, 'getDoctorsByClinic'])->name('get-doctors-by-clinic');
    Route::resource('/news-category', NewsCategoryController::class);
    Route::resource('/news', NewsController::class);
});

Route::get('/', [HomeController::class, 'home'])->name('home');
