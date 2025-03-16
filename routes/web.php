<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\ContactController;
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
use App\Http\Controllers\User\AuthController as AuthUserController;
use App\Http\Controllers\User\DoctorController;
use App\Http\Controllers\User\NewsController as UserNewsController;
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

    Route::get('/contact/unread', [ContactController::class, 'unreadAppointments'])->name('contact.unread');
    Route::resource('/contact', ContactController::class);
    Route::post('/contact/reply', [ContactController::class, 'reply'])->name('admin.handle-reply-contact');
    Route::post('/contact/bulk-delete', [ContactController::class, 'allDelete'])->name('contact.bulkDelete');
    Route::post('/contact/mark-read-all', [ContactController::class, 'markReadAll'])->name('contact.markReadAll');
    Route::post('/contact/mark-unread-all', [ContactController::class, 'markUnreadAll'])
        ->name('contact.markUnreadAll');
    Route::get('/contact/{id}/mark-read', [ContactController::class, 'markRead'])->name('contact.markRead');
    Route::delete('/contact/{id}/delete', [ContactController::class, 'delete'])->name('admin.contact-delete');
    Route::get('/contact/{id}/reply', [ContactController::class, 'page_reply'])->name('admin.reply-contact');

    Route::get('/appointment/unread', [AppointmentController::class, 'unreadAppointments'])->name('appointment.unread');
    Route::resource('/appointment', AppointmentController::class);
    Route::post('/appointment/bulk-delete', [AppointmentController::class, 'allDelete'])->name('appointment.bulkDelete');
    Route::post('/appointment/mark-read-all', [AppointmentController::class, 'markReadAll'])->name('appointment.markReadAll');
    Route::post('/appointment/mark-unread-all', [AppointmentController::class, 'markUnreadAll'])
        ->name('appointment.markUnreadAll');
    Route::get('/appointment/{id}/mark-read', [AppointmentController::class, 'markRead'])->name('appointment.markRead');
    Route::delete('/appointment/{id}/delete', [AppointmentController::class, 'delete'])->name('admin.appointment-delete');
    Route::get('/appointment/{id}/reply', [AppointmentController::class, 'page_reply'])->name('admin.reply-appointment');
    Route::post('/appointment/reply', [AppointmentController::class, 'reply'])->name('admin.handle-reply-appointment');
    Route::get('/appointment/{id}/confirm', [AppointmentController::class, 'confirm'])->name('admin.confirm-appointment');
    Route::get('/appointment/{id}/cancle', [AppointmentController::class, 'cancle'])->name('admin.cancle-appointment');
});

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::prefix('/auth')->group(function () {
    Route::get('/google/login', [AuthUserController::class, 'redirectToGoogle'])->name('user.google-login');
    Route::get('/login/google-callback', [AuthUserController::class, 'handleGoogleCallback'])->name('user.google-callback');
    Route::get('/login', [AuthUserController::class, 'login_page'])->name('user.login');
    Route::post('/login', [AuthUserController::class, 'login'])->name('user.login');
    Route::get('/register', [AuthUserController::class, 'register_page'])->name('user.register');
    Route::post('/register', [AuthUserController::class, 'register'])->name('user.register');
    Route::get('/forgot-password', [AuthUserController::class, 'page_forgot_password'])->name('user.forgot');
    Route::post('/forgot-password', [AuthUserController::class, 'forgot_password'])->name('user.forgot');
    Route::get('/recovery-password', [AuthUserController::class, 'page_recovery_password'])->name('user.recovery');
    Route::post('/recovery-password', [AuthUserController::class, 'recovery_password'])->name('user.recovery');
});
Route::prefix('/profile')->middleware('auth.user')->group(function () {
    Route::get('/overview', [AuthUserController::class, 'overview'])->name('user.overview');
    Route::get('/account-edit', [AuthUserController::class, 'page_account_edit'])->name('user.account-edit');
    Route::post('/account-edit', [AuthUserController::class, 'account_edit'])->name('user.account-edit');
    Route::get('/change-password', [AuthUserController::class, 'page_change_password'])->name('user.change-password');
    Route::post('/change-password', [AuthUserController::class, 'change_password'])->name('user.change-password');
    Route::get('/logout', [AuthUserController::class, 'logout'])->name('user.logout');
    Route::post('/change-avatar', [AuthUserController::class, 'change_avatar'])->name('user.change-avatar');
});

Route::get('/doctors', [DoctorController::class, 'doctors'])->name('user.doctors');
Route::get('/contact', [HomeController::class, 'contact_form'])->name('user.contact');
Route::post('/contact', [HomeController::class, 'contact'])->name('user.contact');
Route::post('/book-appointment', [HomeController::class, 'book_appointment'])->name('user.book-appointment');
Route::get('/{slugCategory}/{slug}', [UserNewsController::class, 'news_detail'])->name('user.news-detail');
Route::get('/{slugCategory}', [UserNewsController::class, 'news'])->name('user.news');
