<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SearchController;
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

Route::get('/', function () {
    return view('welcome');
});

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
});
