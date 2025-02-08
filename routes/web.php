<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
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
});
