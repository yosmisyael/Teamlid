<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController
{
    public function register(): View {
        return view('auth.admin-register');
    }

    public function handleRegister(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],
        ]);

        Admin::query()->create($validated);

        return redirect()->route('admin.login');
    }

    public function login(): View {
        return view('auth.admin-login');
    }

    public function handleLogin(Request $request): RedirectResponse {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email:dns', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $result = Auth::guard('admins')->attempt($validated);

        if (!$result) {
            return back()->withErrors([
                'credentials' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect('/admin/dashboard');
    }

    public function dashboard(): View {
        return view('admin.dashboard');
    }

    public function logout(): RedirectResponse {
        Auth::guard('admins')->logout();
        return redirect()->route('home');
    }
}
