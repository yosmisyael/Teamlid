@extends('master')
@section('content')
<div class="min-h-screen w-full flex flex-col items-center justify-center p-4 lg:p-8">

    <!-- Logo Title -->
    <a href="index.html" class="text-4xl font-bold text-primary mb-6 inline-flex">
        <img src="logo.svg" alt="logo" class="h-9">
        eamable
    </a>

    <!-- Registration Form Card -->
    <div class="bg-white p-8 sm:p-12 rounded-2xl shadow-2xl w-full max-w-2xl">
        <h2 class="text-3xl font-bold text-primary text-center">Create Your Account</h2>
        <p class="text-gray-500 text-center text-sm mt-2 mb-8">Join Teamable and transform your HR operations</p>

        <form action="/login" method="POST" class="space-y-5">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="full-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <!-- Heroicon: user -->
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="name" id="full-name" class="focus:ring-secondary focus:border-secondary block w-full pl-10 pr-3 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="John Doe">
                </div>
                @error('name')
                <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid name</span> {{ $message }}</p>
                @enderror
            </div>

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
                    <input type="email" name="email" id="email" class="focus:ring-secondary focus:border-secondary block w-full pl-10 pr-3 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="you@company.com">
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
                    <input type="password" name="password" id="password" class="focus:ring-secondary focus:border-secondary block w-full pl-10 pr-10 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="********">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <!-- Heroicon: eye -->
                        <svg class="w-5 h-5 text-gray-400 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.675 7.697-4.97 0-9.186-3.223-10.675-7.69a.75.75 0 010-1.113zM12.001 18C7.859 18 4.172 15.34 2.864 12c1.308-3.34 5-6 9.137-6s7.828 2.66 9.136 6c-1.308 3.34-4.999 6-9.136 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500">Use 8+ characters with a mix of letters, numbers & symbols.</p>
                @error('password')
                <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid password</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <!-- Heroicon: lock-closed -->
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" name="password_confirmation" id="confirm-password" class="focus:ring-secondary focus:border-secondary block w-full pl-10 pr-10 py-3 sm:text-sm border-gray-300 rounded-md" placeholder="********">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <!-- Heroicon: eye -->
                        <svg class="w-5 h-5 text-gray-400 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.675 7.697-4.97 0-9.186-3.223-10.675-7.69a.75.75 0 010-1.113zM12.001 18C7.859 18 4.172 15.34 2.864 12c1.308-3.34 5-6 9.137-6s7.828 2.66 9.136 6c-1.308 3.34-4.999 6-9.136 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @error('password_confirmation')
                <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid password confirmation</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Terms & Conditions -->
            <div class="flex items-start pt-2">
                <div class="flex-shrink-0">
                    <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-secondary focus:ring-secondary border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-700">
                        I agree to the
                        <a href="#" class="font-medium text-secondary hover:text-secondary/80">Terms & Conditions</a>
                        and
                        <a href="#" class="font-medium text-secondary hover:text-secondary/80">Privacy Policy</a>
                    </label>
                </div>
            </div>

            <!-- Sign Up Button -->
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                    Sign Up
                </button>
            </div>
        </form>

        <!-- Log In Link -->
        <p class="mt-8 text-center text-sm text-gray-600">
            Already have an account?
            <a href="/login" class="font-medium text-secondary hover:text-secondary/80">Log in here</a>
        </p>
    </div>

    <!-- Footer Copyright -->
    <p class="mt-8 text-sm text-gray-500 text-center">
        &copy; 2024 Teamable. All rights reserved.
    </p>

</div>
@endsection
