<?php

use App\Http\Controllers\AdminController;
use App\Livewire\CompanyOnboarding;
use App\Livewire\DepartmentManagement;
use App\Livewire\JobManagement;
use App\Livewire\PositionManagement;
use App\Livewire\EmployeeManagement;
use App\Livewire\AttendanceManagement;
use App\Livewire\BankManagement;
use App\Livewire\SalaryManagement;
use App\Livewire\PayrollManagement;
use App\Livewire\DashboardManagement;
use App\Http\Controllers\PayrollPdfController;
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
    Route::get('/dashboard', DashboardManagement::class)->name('admin.dashboard');
    Route::get('/onboarding', CompanyOnboarding::class)->name('admin.onboarding');
    Route::get('/positions', PositionManagement::class)->name('admin.positions');
    Route::get('/jobs', JobManagement::class)->name('admin.jobs');
    Route::get('/departments', DepartmentManagement::class)->name('admin.departments');
    Route::get('/employees', EmployeeManagement::class)->name('admin.employees');
    Route::get('/attendances', AttendanceManagement::class)->name('admin.attendances');
    Route::get('/banks', BankManagement::class)->name('admin.banks');
    Route::get('/salaries', SalaryManagement::class)->name('admin.salaries');
    Route::get('/payrolls', PayrollManagement::class)->name('admin.payrolls');


    Route::get('/payrolls/{id}/download', [PayrollPdfController::class, 'download'])
        ->name('payroll.download');

    Route::delete('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
