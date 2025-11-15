@extends('master')

@section('content')
<!-- Header Navigation -->
<nav class="bg-white sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <img src="logo.svg" alt="logo" class="h-8">
                <a href="#" class="text-3xl font-bold text-primary">eamable</a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex md:ml-6 md:space-x-8">
                <a href="#"
                   class="text-gray-600 hover:text-primary inline-flex items-center px-1 pt-1 text-sm font-medium">Product</a>
                <a href="#"
                   class="text-gray-600 hover:text-primary inline-flex items-center px-1 pt-1 text-sm font-medium">Solutions</a>
                <a href="#"
                   class="text-gray-600 hover:text-primary inline-flex items-center px-1 pt-1 text-sm font-medium">Resources</a>
                <a href="#"
                   class="text-gray-600 hover:text-primary inline-flex items-center px-1 pt-1 text-sm font-medium">Pricing</a>
            </div>

            <!-- Desktop Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="/login" class="text-primary hover:text-secondary text-sm font-medium">
                    Log in
                </a>
                <a href="/register"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90">
                    Sign Up Free
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button type="button"
                        class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-secondary"
                        aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Heroicon: bars-3 -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<header class="bg-gradient-to-b from-sky-50 via-white to-white pt-16 pb-24 sm:pt-24 sm:pb-32">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Hero Text Content -->
            <div class="text-center md:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-primary tracking-tight">
                    Transform Your Workforce Management
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Streamline HR processes, from talent acquisition and payroll to performance tracking, all on one
                    intuitive platform. Get the tools you need to build a happier, more productive team.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="/register"
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90">
                        Get Started Free
                    </a>
                    <a href="/login"
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-primary bg-white hover:bg-gray-50">
                        Watch a Demo
                    </a>
                </div>
            </div>

            <!-- Hero Card -->
            <div class="bg-white rounded-lg shadow-xl p-6 border border-gray-100 space-y-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center">
                        <!-- Heroicon: check-circle -->
                        <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.06-1.06l-3.25 3.25-1.5-1.5a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.06 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-primary">All-in-One HR Platform</h3>
                        <p class="text-gray-500">Manage everything from a single, unified dashboard.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center">
                        <!-- Heroicon: briefcase -->
                        <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path d="M10.5 1.5H13.5V4.5H10.5V1.5Z"/>
                            <path fill-rule="evenodd"
                                  d="M3.75 6H20.25C20.6642 6 21 6.33579 21 6.75V20.25C21 20.6642 20.6642 21 20.25 21H3.75C3.33579 21 3 20.6642 3 20.25V6.75C3 6.33579 3.33579 6 3.75 6ZM6 9V18H18V9H6Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-primary">Automated Payroll</h3>
                        <p class="text-gray-500">Run payroll in minutes, not hours, with full tax compliance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Stats Section -->
<section class="py-16 bg-sky-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <span class="text-4xl font-bold text-primary">10K+</span>
                <p class="text-sm uppercase text-gray-500 mt-1">Companies Served</p>
            </div>
            <div>
                <span class="text-4xl font-bold text-primary">2M+</span>
                <p class="text-sm uppercase text-gray-500 mt-1">Active Users Daily</p>
            </div>
            <div>
                <span class="text-4xl font-bold text-primary">99.9%</span>
                <p class="text-sm uppercase text-gray-500 mt-1">Uptime Guarantee</p>
            </div>
            <div>
                <span class="text-4xl font-bold text-primary">50+</span>
                <p class="text-sm uppercase text-gray-500 mt-1">Countries Supported</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-secondary font-semibold uppercase text-sm">Features</span>
            <h2 class="mt-2 text-3xl md:text-4xl font-bold text-primary">Everything You Need in One Platform</h2>
            <p class="mt-4 text-lg text-gray-600">
                One unified system to manage the entire employee lifecycle. Stop switching between apps and start
                streamlining your workflow.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feature Card 1 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mb-4">
                    <!-- Heroicon: users -->
                    <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path
                            d="M10.5 6A2.25 2.25 0 116 6a2.25 2.25 0 014.5 0zM13.5 6a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM16.5 6a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM18 8.25a.75.75 0 00-.75-.75h-9a.75.75 0 000 1.5h9a.75.75 0 00.75-.75zM18 11.25a.75.75 0 00-.75-.75h-9a.75.75 0 000 1.5h9a.75.75 0 00.75-.75zM18 14.25a.75.75 0 00-.75-.75h-9a.75.75 0 000 1.5h9a.75.75 0 00.75-.75zM18 17.25a.75.75 0 00-.75-.75h-9a.75.75 0 000 1.5h9a.75.75 0 00.75-.75z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary mb-2">Talent Acquisition</h3>
                <p class="text-gray-500 text-sm">Attract, interview, and hire the best talent faster.</p>
            </div>
            <!-- Feature Card 2 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mb-4">
                    <!-- Heroicon: identification -->
                    <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M4.5 3.75A.75.75 0 015.25 3h13.5a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V3.75zM6 6.75A.75.75 0 016.75 6h10.5a.75.75 0 01.75.75v3a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75v-3zm.75 9a.75.75 0 000 1.5h6a.75.75 0 000-1.5h-6z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary mb-2">Payroll Management</h3>
                <p class="text-gray-500 text-sm">Automate pay runs, taxes, and compliance with ease.</p>
            </div>
            <!-- Feature Card 3 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mb-4">
                    <!-- Heroicon: chart-bar-square -->
                    <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M3 3.75A.75.75 0 013.75 3h16.5a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75H3.75a.75.75 0 01-.75-.75V3.75zm6 13.5v-3a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-1.5h-1.5a.75.75 0 01-.75-.75zm3.75-9a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary mb-2">Performance Management</h3>
                <p class="text-gray-500 text-sm">Set goals, run 360° reviews, and foster growth.</p>
            </div>
            <!-- Feature Card 4 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mb-4">
                    <!-- Heroicon: academic-cap -->
                    <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path
                            d="M11.7 2.052a.75.75 0 01.6 0l7.5 3.75a.75.75 0 01.3 1.05l-3.75 7.5a.75.75 0 01-1.05.3l-2.1-1.05a.75.75 0 00-.7 0l-2.1 1.05a.75.75 0 01-1.05-.3l-3.75-7.5a.75.75 0 01.3-1.05l7.5-3.75z"/>
                        <path
                            d="M12 6.131L9.423 7.52l1.64 3.281a.75.75 0 00.7.469h.474a.75.75 0 00.7-.469l1.64-3.281L12 6.131z"/>
                        <path
                            d="M3 15.75a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75zM3 18.75a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary mb-2">Learning & Development</h3>
                <p class="text-gray-500 text-sm">Create courses and track employee training progress.</p>
            </div>
            <!-- Feature Card 5 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mb-4">
                    <!-- Heroicon: clock -->
                    <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary mb-2">Time & Attendance</h3>
                <p class="text-gray-500 text-sm">Track hours, manage leave, and sync with payroll.</p>
            </div>
            <!-- Feature Card 6 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mb-4">
                    <!-- Heroicon: shield-check -->
                    <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary mb-2">Compliance & Security</h3>
                <p class="text-gray-500 text-sm">Stay compliant with GDPR, CCPA, and SOC 2 Type II.</p>
            </div>
        </div>
    </div>
</section>

<!-- "Why Choose Us" Section -->
<section class="py-16 md:py-24 bg-sky-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div>
                <span class="text-secondary font-semibold uppercase text-sm">Why Us</span>
                <h2 class="mt-2 text-3xl md:text-4xl font-bold text-primary">Why Choose Teamable?</h2>
                <p class="mt-4 text-lg text-gray-600">
                    We're not just another HR tool. We're a partner dedicated to your success, providing insights that
                    drive real business results.
                </p>
                <ul class="mt-8 space-y-4">
                    <li class="flex items-start gap-3">
                        <!-- Heroicon: check-circle (solid) -->
                        <svg class="w-6 h-6 text-secondary flex-shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-primary">Reduce Time-to-Hire by 40%</h4>
                            <p class="text-gray-500 text-sm">Our AI-powered sourcing finds qualified candidates
                                instantly.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-secondary flex-shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-primary">Simple, Transparent Pricing</h4>
                            <p class="text-gray-500 text-sm">No hidden fees, no surprises. Just pay for what you
                                use.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-secondary flex-shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-primary">Seamless Integration</h4>
                            <p class="text-gray-500 text-sm">Connects with 100+ apps like Slack, Google, and more.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Stats Card -->
            <div class="bg-white rounded-lg shadow-xl p-6 border border-gray-100 space-y-6">
                <!-- Stat 1 -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-base font-medium text-primary">Employee Satisfaction</span>
                        <span class="text-sm font-medium text-primary">84%</span>
                    </div>
                    <div class="w-full bg-tertiary/50 rounded-full h-3">
                        <div class="bg-secondary h-3 rounded-full" style="width: 84%"></div>
                    </div>
                </div>
                <!-- Stat 2 -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-base font-medium text-primary">Talent Retention Rate</span>
                        <span class="text-sm font-medium text-primary">97%</span>
                    </div>
                    <div class="w-full bg-tertiary/50 rounded-full h-3">
                        <div class="bg-secondary h-3 rounded-full" style="width: 97%"></div>
                    </div>
                </div>
                <!-- Stat 3 -->
                <div class="pt-2">
                    <span class="text-4xl font-bold text-primary">3.9k</span>
                    <p class="text-gray-500">Daily Active Users</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-secondary font-semibold uppercase text-sm">Testimonials</span>
            <h2 class="mt-2 text-3xl md:text-4xl font-bold text-primary">Trusted by Industry Leaders</h2>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Testimonial Card 1 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6">
                <div class="flex text-yellow-400 mb-4">
                    <!-- Heroicon: star (solid) -->
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-gray-600 italic mb-6">"Teamable has revolutionized our hiring process. We're finding
                    better candidates and filling roles in half the time. It's a game-changer."</p>
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full" src="https://placehold.co/40x40/93D5F1/176688?text=S"
                         alt="Sarah Johnson">
                    <div>
                        <p class="font-semibold text-primary">Sarah Johnson</p>
                        <p class="text-sm text-gray-500">Head of Talent, Acme Inc.</p>
                    </div>
                </div>
            </div>
            <!-- Testimonial Card 2 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6">
                <div class="flex text-yellow-400 mb-4">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-gray-600 italic mb-6">"The single best platform for managing a distributed team. Payroll
                    and compliance are now worries of the past."</p>
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full" src="https://placehold.co/40x40/93D5F1/176688?text=M"
                         alt="Mark Chen">
                    <div>
                        <p class="font-semibold text-primary">Mark Chen</p>
                        <p class="text-sm text-gray-500">CFO, Innovate Solutions</p>
                    </div>
                </div>
            </div>
            <!-- Testimonial Card 3 -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 p-6">
                <div class="flex text-yellow-400 mb-4">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.007z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-gray-600 italic mb-6">"Our employee engagement scores are up 30% since we adopted
                    Teamable. The performance review module is intuitive and effective."</p>
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full" src="https://placehold.co/40x40/93D5F1/176688?text=E"
                         alt="Emily Rodriguez">
                    <div>
                        <p class="font-semibold text-primary">Emily Rodriguez</p>
                        <p class="text-sm text-gray-500">VP of People, Quantum Leap</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Logo Cloud Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h4 class="text-gray-500 mb-8">Trusted by Leading Companies Worldwide</h4>
        <div class="flex flex-wrap justify-center items-center gap-x-12 gap-y-8">
            <!-- Using text as logo placeholders based on the image -->
            <span class="text-2xl font-bold text-gray-400 grayscale opacity-75">Microsoft</span>
            <span class="text-2xl font-bold text-gray-400 grayscale opacity-75">Google</span>
            <span class="text-2xl font-bold text-gray-400 grayscale opacity-75">Apple</span>
            <span class="text-2xl font-bold text-gray-400 grayscale opacity-75">Discord</span>
        </div>
    </div>
</section>

<!-- Footer CTA Section -->
<section class="py-16 md:py-24 bg-primary">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Transform Your HR Operations?</h2>
        <p class="text-lg text-tertiary mb-8">
            Join thousands of companies who trust Teamable to manage their workforce.
            Start your free trial today—no credit card required.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#"
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-md shadow-sm text-primary bg-white hover:bg-gray-100">
                Get Started Free
            </a>
            <a href="#"
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-secondary hover:bg-secondary/90">
                Schedule a Demo
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <p class="text-center text-base text-gray-400">
            &copy; 2025 Teamable. All rights reserved.
        </p>
    </div>
</footer>
@endsection
