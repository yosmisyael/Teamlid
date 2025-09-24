<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::delete('employees/{employee}/force', [EmployeeController::class, 'forceDelete'])->name('employees.forceDelete');

Route::resource('employees', EmployeeController::class);
