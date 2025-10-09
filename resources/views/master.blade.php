<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Employee Management App')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('style')
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    {{--  header  --}}
    <header class="bg-white shadow-lg">
        <!-- Top Bar -->
        <div class="border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-lg shadow-lg">
                            <span class="material-icons text-white text-2xl">business</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Employee Management System</h1>
                            <p class="text-xs text-gray-500">Department of Informatics and Computer Engineering</p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-gray-50 rounded-lg">
                            <span class="material-icons text-blue-500 text-sm">account_circle</span>
                            <span class="text-sm font-medium text-gray-700">3124500039 - Misyael Yosevian Wiarda</span>
                        </div>
                        <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors duration-200" title="Notifications">
                            <span class="material-icons">notifications</span>
                        </button>
                        <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors duration-200" title="Logout">
                            <span class="material-icons">logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Bar -->
        <nav class="border-b-4 border-blue-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <ul class="flex items-center space-x-1 overflow-x-auto">
                    <li>
                        <a href="{{ url('/employees') }}" class="flex items-center space-x-2 px-4 py-4 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 border-b-4 border-blue-700 transition-all duration-300">
                            <span class="material-icons text-lg">people</span>
                            <span>Employee</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/department') }}" class="flex items-center space-x-2 px-4 py-4 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 border-b-4 border-transparent hover:border-blue-300 transition-all duration-300">
                            <span class="material-icons text-lg">apartment</span>
                            <span>Department</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/attendance') }}" class="flex items-center space-x-2 px-4 py-4 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 border-b-4 border-transparent hover:border-blue-300 transition-all duration-300">
                            <span class="material-icons text-lg">event_available</span>
                            <span>Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/report') }}" class="flex items-center space-x-2 px-4 py-4 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 border-b-4 border-transparent hover:border-blue-300 transition-all duration-300">
                            <span class="material-icons text-lg">assessment</span>
                            <span>Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/settings') }}" class="flex items-center space-x-2 px-4 py-4 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 border-b-4 border-transparent hover:border-blue-300 transition-all duration-300">
                            <span class="material-icons text-lg">settings</span>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    {{--  main content  --}}
    <main>
        @yield('content')
    </main>

    {{--  footer  --}}
    <footer class="bg-white border-t-4 border-blue-500 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-lg shadow-lg">
                            <span class="material-icons text-white text-xl">business</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Employee</h3>
                            <p class="text-xs text-gray-500">Management System</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Electronic Engineering Polytechnic Institute of Surabaya</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('/employees') }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                                <span class="material-icons text-sm">arrow_right</span>
                                <span>Employee Directory</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/department') }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                                <span class="material-icons text-sm">arrow_right</span>
                                <span>Departments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/attendance') }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                                <span class="material-icons text-sm">arrow_right</span>
                                <span>Attendance Records</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/report') }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200 flex items-center space-x-2">
                                <span class="material-icons text-sm">arrow_right</span>
                                <span>Reports</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Contact Information</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <span class="material-icons text-blue-500 text-sm mt-0.5">location_on</span>
                            <span class="text-sm text-gray-600">Jl. Raya ITS, Sukolilo, Surabaya, East Java 60111</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="material-icons text-blue-500 text-sm">phone</span>
                            <span class="text-sm text-gray-600">+62 31 594 7280</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="material-icons text-blue-500 text-sm">email</span>
                            <span class="text-sm text-gray-600">info@pens.ac.id</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="material-icons text-blue-500 text-sm">language</span>
                            <a href="https://www.pens.ac.id" class="text-sm text-blue-600 hover:text-blue-700 transition-colors duration-200">www.pens.ac.id</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <p class="text-sm text-gray-600 flex items-center space-x-2">
                        <span class="material-icons text-sm text-blue-500">copyright</span>
                        <span>{{ date('Y') }} Employee Management App. All rights reserved.</span>
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">Privacy Policy</a>
                        <span class="text-gray-400">|</span>
                        <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">Terms of Service</a>
                        <span class="text-gray-400">|</span>
                        <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">Help</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
