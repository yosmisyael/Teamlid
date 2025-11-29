<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmployeeAuthController extends Controller
{
    public function login(string $company)
    {
        // company validity check
        $companyData = Company::query()->where('slug', '=', $company)->firstOrFail();

        return view('auth.employee-login', [
            'companyName' => $companyData->name,
        ]);
    }

    public function handleLogin(Request $request, string $company)
    {
        $credentials = $request->validate([
            'companyName' => 'required', 'string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('employees')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            $employee = Auth::guard('employees')->user();

            $isEmployeeValid = Employee::query()->where('id', $employee->id)
                ->whereHas('department.company', function ($query) use ($credentials) {
                    $query->where('name', $credentials['companyName']);
                })
                ->exists();

            if (!$isEmployeeValid) {
                Auth::guard('employees')->logout();
                return back()->withErrors([
                    'email' => 'You are not registered in this company.',
                ]);
            }

            return redirect()->route('employee.dashboard', ['company' => $company]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function handleLogout(Request $request, string $company)
    {
        Auth::guard('employees')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home', ['company' => $company]);
    }
}
