@php
    $currentSession = \Illuminate\Support\Facades\Auth::guard('admins')->getUser();
@endphp

<header class="h-20 bg-white drop-shadow-md flex items-center justify-between flex-shrink-0 px-6 rounded-lg">
    <div class="flex items-center">
        <!-- Mobile Menu Button (hidden on md+) -->
        <button class="md:hidden mr-4 text-gray-600">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>
        <h1 class="text-2xl font-bold text-primary">
            @yield('pageTitle')
        </h1>
    </div>

    <div class="flex items-center space-x-5">
        <!-- Notifications -->
        <div class="relative">
            <button class="text-gray-500 hover:text-primary">
                <span class="material-icons">
                    notifications
                </span>
            </button>
            <span
                class="absolute top-0 right-0 -mt-1 -mr-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button class="flex items-center space-x-2">
                <img class="w-10 h-10 rounded-full" src="https://placehold.co/40x40/93D5F1/176688?text={{\Illuminate\Support\Str::substr($currentSession->name, 0, 1)}}"
                     alt="Admin Profile">
                <span class="hidden md:block font-medium text-gray-700">{{ $currentSession->name }}</span>
                <!-- Heroicon: chevron-down -->
                <svg class="w-5 h-5 text-gray-500 hidden md:block" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
            <!-- Dropdown Menu (hidden by default) -->
            <!--
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <a href="login.html" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Log Out</a>
            </div>
            -->
        </div>
    </div>
</header>

