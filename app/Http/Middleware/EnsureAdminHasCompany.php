<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminHasCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var \App\Models\Admin $admin
         */
        $admin = Auth::guard('admins')->user();
        $route = $request->route()->getName();

        $hasCompany = $admin->hasCompany();

        if (!$hasCompany && $route !== 'admin.onboarding') {
            return redirect()->route('admin.onboarding');
        }

        if ($admin->hasCompany() && $request->route()->getName() === 'admin.onboarding') {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
