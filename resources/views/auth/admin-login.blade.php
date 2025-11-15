@extends('master')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center p-4 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12 max-w-6xl w-full">

        <!-- Left Column: Content -->
        <div class="p-4 lg:p-8">
            <a href="/" class="text-4xl font-bold text-primary mb-6 inline-flex">
                <img src="logo.svg" alt="logo" class="h-9">
                eamable
            </a>

            <h1 class="text-4xl lg:text-5xl font-extrabold text-primary tracking-tight mb-4">
                Streamline Your Workforce Management
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Access your comprehensive HCM platform to manage teams, track performance, and optimize your human resources with ease.
            </p>

            <!-- Feature List -->
            <ul class="space-y-4 mb-10">
                <li class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-secondary/20 rounded-full flex items-center justify-center">
                        <!-- Heroicon: users -->
                        <svg class="w-5 h-5 text-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM1.5 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75H4.5a3 3 0 01-3-3zM11.25 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75h-1.5a3 3 0 01-3-3zM21 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75h-1.5a3 3 0 01-3-3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary">Team Management</h3>
                        <p class="text-gray-500 text-sm">Organize and oversee your entire workforce</p>
                    </div>
                </li>
                <li class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-secondary/20 rounded-full flex items-center justify-center">
                        <!-- Heroicon: chart-bar -->
                        <svg class="w-5 h-5 text-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 3a.75.75 0 00-.75.75v16.5c0 .414.336.75.75.75h18a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75H3zM9 17.25a.75.75 0 000-1.5H7.5a.75.75 0 000 1.5H9zM12.75 15.75a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-.75H13.5a.75.75 0 01-.75-.75zM9 12.75a.75.75 0 000-1.5H7.5a.75.75 0 000 1.5H9zM12.75 11.25a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-.75H13.5a.75.75 0 01-.75-.75zM16.5 12.75a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5zM9 8.25a.75.75 0 000-1.5H7.5a.75.75 0 000 1.5H9zM12.75 6.75a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V7.5H13.5a.75.75 0 01-.75-.75zM16.5 8.25a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5h1.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary">Performance Analytics</h3>
                        <p class="text-gray-500 text-sm">Track metrics and drive productivity</p>
                    </div>
                </li>
                <li class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-secondary/20 rounded-full flex items-center justify-center">
                        <!-- Heroicon: clock -->
                        <svg class="w-5 h-5 text-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary">Time & Attendance</h3>
                        <p class="text-gray-500 text-sm">Automated tracking and reporting</p>
                    </div>
                </li>
            </ul>

            <!-- Stats -->
            <div class="flex items-center gap-8">
                <div>
                    <span class="text-3xl font-bold text-primary">10K+</span>
                    <p class="text-sm text-gray-500 mt-1">Active Users</p>
                </div>
                <div>
                    <span class="text-3xl font-bold text-primary">500+</span>
                    <p class="text-sm text-gray-500 mt-1">Companies</p>
                </div>
                <div>
                    <span class="text-3xl font-bold text-primary">99.9%</span>
                    <p class="text-sm text-gray-500 mt-1">Uptime</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Login Form Card -->
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white p-8 sm:p-12 rounded-2xl shadow-2xl">
                <h2 class="text-2xl font-bold text-primary text-center">Welcome Back</h2>
                <p class="text-gray-500 text-center text-sm mt-1 mb-6">Log in to access your Teamable account</p>

                <form action="/login" method="POST" class="space-y-5">
                    @csrf
                    <!-- Work Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Work Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <!-- Heroicon: envelope -->
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                                    <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ @old('email') }}" class="focus:ring-secondary focus:border-secondary block w-full pl-10 pr-3 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="you@company.com">
                        </div>
                        @error('email')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid email</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <!-- Heroicon: lock-closed -->
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" class="focus:ring-secondary focus:border-secondary block w-full pl-10 pr-10 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="Enter your password">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <!-- Heroicon: eye -->
                                <svg class="w-5 h-5 text-gray-400 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.675 7.697-4.97 0-9.186-3.223-10.675-7.69a.75.75 0 010-1.113zM12.001 18C7.859 18 4.172 15.34 2.864 12c1.308-3.34 5-6 9.137-6s7.828 2.66 9.136 6c-1.308 3.34-4.999 6-9.136 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-secondary focus:ring-secondary border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-secondary hover:text-secondary/80">Forgot Password?</a>
                        </div>
                    </div>

                    @error('credentials')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid Credentials</span> {{ $message }}</p>
                    @enderror

                    <!-- Log In Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Log In
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <!-- Social Logins -->
                <div class="grid grid-cols-2 gap-4">
                    <a href="#" class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <!-- Simple Google-like SVG -->
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.216,0-9.626-3.359-11.303-8H6.393c1.62,6.591,7.79,12,14.607,12C21.729,40,22.868,40,24,40z" />
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303C33.654,32.657,29.22,36,24,36c-2.715,0-5.211-0.909-7.243-2.438l-6.19,5.238C14.14,42.023,18.834,44,24,44c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                        </svg>
                        Google
                    </a>
                    <a href="#" class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <!-- Simple Microsoft-like SVG -->
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#F25022" d="M1 1h10v10H1V1z"/>
                            <path fill="#00A4EF" d="M1 12h10v10H1V12z"/>
                            <path fill="#7FBA00" d="M12 1h10v10H12V1z"/>
                            <path fill="#FFB900" d="M12 12h10v10H12V12z"/>
                        </svg>
                        Microsoft
                    </a>
                </div>

                <!-- Sign Up Link -->
                <p class="mt-8 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="/register" class="font-medium text-secondary hover:text-secondary/80">Sign up now</a>
                </p>
            </div>

            <div class="mt-6 flex items-center justify-center text-gray-600 text-sm">
                <!-- Heroicon: lock-closed -->
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                </svg>
                <span>Secured with 256-bit SSL encryption</span>
            </div>
        </div>

    </div>
</div>
@endsection
