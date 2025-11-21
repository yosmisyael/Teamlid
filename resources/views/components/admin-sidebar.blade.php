<aside class="w-64 bg-surface-high shadow-md text-white flex-col hidden md:flex overflow-y-auto">
    <!-- Logo -->
    <div class="h-20 flex items-center shadow-md justify-center flex-shrink-0 bg-white m-2 rounded-lg">
        <a href="index.html" class="text-3xl font-bold text-primary flex">
            <img src="{{asset('logo.ico')}}" alt="logo" class="h-8">
            eamable
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">dashboard</span>
            Dashboard
        </a>
        <a href="{{ route('admin.departments') }}" class="{{ request()->routeIs('admin.departments') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">domain</span>
            Department
        </a>
        <a href="{{ route('admin.jobs') }}" class="{{ request()->routeIs('admin.jobs') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">work</span>
            Jobs
        </a>
        <a href="{{ route('admin.positions') }}" class="{{ request()->routeIs('admin.positions') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">account_tree</span>
            Position
        </a>
        <a href="{{ route('admin.employees') }}" class="{{ request()->routeIs('admin.employees') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">assignment_ind</span>
            Employees
        </a>
        <a href="{{ route('admin.attendances') }}" class="{{ request()->routeIs('admin.attendances') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">punch_clock</span>
            Attendance
        </a>
        <a href="{{ route('admin.banks') }}" class="{{ request()->routeIs('admin.banks') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">account_balance</span>
            Authorized Bank
        </a>
        <a href="{{ route('admin.salaries') }}" class="{{ request()->routeIs('admin.salaries') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">payments</span>
            Salary
        </a>
        <a href="{{ route('admin.payrolls') }}" class="{{ request()->routeIs('admin.payrolls') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">currency_exchange</span>
            Payrolls
        </a>
        <a href="{{ route('admin.company') }}" class="{{ request()->routeIs('admin.company') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">settings</span>
            Company Profile
        </a>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.recruits.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <span class="material-icons text-xl">person_search</span>
            Recruitment
        </a>
    </nav>
    <form action="{{ route('admin.logout') }}" method="POST" class="px-4 py-4 space-y-2">
        @csrf
        @method('DELETE')
        <button type="submit" class="button-danger w-full">
            <span class="material-icons text-xl">logout</span>
            Sign Out
        </button>
    </form>
</aside>
