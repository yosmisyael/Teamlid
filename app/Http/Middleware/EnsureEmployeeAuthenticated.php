<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployeeAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAuthenticated = auth()->guard('employees')->check();

        if (!$isAuthenticated) {
            $path = $request->path();

            $segments = explode('/', $path);

            $companySlug = $segments[1] ?? null;

            return redirect()->route('employee.login', ['company' => $companySlug]);
        }

        return $next($request);
    }
}
