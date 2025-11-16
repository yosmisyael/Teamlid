<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryController;
use \App\Http\Controllers\AdminController;
use \App\Livewire\CompanyOnboarding;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.welcome');
});

// admin authentications
Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
Route::post('/register', [AdminController::class, 'handleRegister']);
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login', [AdminController::class, 'handleLogin']);

// admin resources
Route::middleware(['admin.auth', 'company.setup'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/onboarding', CompanyOnboarding::class)->name('admin.onboarding');
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.employees.index');
    });
    Route::prefix('payrolls')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.payrolls');
    });
    Route::prefix('attendances')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.attendances');
    });
    Route::prefix('departments')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.departments');
    });
    Route::prefix('positions')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.positions');
    });
});
