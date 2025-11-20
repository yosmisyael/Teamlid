<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryController;
use \App\Http\Controllers\AdminController;
use \App\Livewire\CompanyOnboarding;
use \App\Livewire\DepartmentManagement;
use \App\Livewire\JobManagement;
use \App\Livewire\PositionManagement;
use \App\Livewire\EmployeeManagement;
use \App\Livewire\AttendanceManagement;
use \App\Livewire\BankManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.welcome');
})->name('home');

// admin authentications
Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
Route::post('/register', [AdminController::class, 'handleRegister']);
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'handleLogin']);

// admin resources
Route::middleware(['admin.auth', 'company.setup'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/onboarding', CompanyOnboarding::class)->name('admin.onboarding');
    Route::get('/positions', PositionManagement::class)->name('admin.positions');
    Route::get('/jobs', JobManagement::class)->name('admin.jobs');
    Route::get('/departments', DepartmentManagement::class)->name('admin.departments');
    Route::get('/employees', EmployeeManagement::class)->name('admin.employees');
    Route::get('/attendances', AttendanceManagement::class)->name('admin.attendances');
    Route::get('/banks', BankManagement::class)->name('admin.banks');

    Route::prefix('payrolls')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.payrolls');
    });
    Route::delete('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
