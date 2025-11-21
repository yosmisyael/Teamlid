<main class="flex-1 overflow-y-auto">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1: Total Employees -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Employees</p>
                <span class="text-4xl font-bold text-primary">{{ $totalEmployee }}</span>
                <p class="text-sm text-green-500 font-medium">+12 this month</p>
            </div>
            <div class="w-14 h-14 bg-tertiary rounded-full flex items-center justify-center">
                <span class="text-6xl material-icons text-primary">group</span>
            </div>
        </div>
        <!-- Card 2: Active Recruitments -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Active Recruitments</p>
                <span class="text-4xl font-bold text-primary">18</span>
                <p class="text-sm text-secondary font-medium">9 new positions</p>
            </div>
            <div class="w-14 h-14 bg-tertiary rounded-full flex items-center justify-center">
                <span class="text-6xl material-icons text-primary">person_search</span>
            </div>
        </div>
        <!-- Card 3: Today's Attendance -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Today's Attendance</p>
                <span class="text-4xl font-bold text-primary">{{ number_format($todayAttendance / $totalEmployee) }}%</span>
                <p class="text-sm text-gray-500 font-medium">{{ $todayAttendance }} present, {{ $totalEmployee - $todayAttendance }} absent</p>
            </div>
            <div class="w-14 h-14 bg-tertiary rounded-full flex items-center justify-center">
                <span class="text-6xl material-icons text-primary">check_circle</span>
            </div>
        </div>
        <!-- Card 4: Pending Approvals -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Pending Approvals</p>
                <span class="text-4xl font-bold text-primary">14</span>
                <p class="text-sm text-gray-500 font-medium">7 leave requests</p>
            </div>
            <div class="w-14 h-14 bg-tertiary rounded-full flex items-center justify-center">
                <span class="text-6xl material-icons text-primary">priority_high</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
        <!-- Employee Growth Chart -->
        <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Employee Growth</h3>
            <div class="relative h-80 w-full">
                <canvas id="employeeGrowthChart"></canvas>
            </div>
        </div>
        <!-- Department Distribution Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Department Distribution</h3>
            <div class="relative h-80 w-full">
                <canvas id="departmentDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Recent Activities</h3>
            <ul class="space-y-4">
                <!-- Activity Item 1 -->
                <li class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.484 3.494c.091-.091.2-.168.316-.221a4.48 4.48 0 011.83.221c.115.053.224.13.315.221l6.75 6.75a.75.75 0 010 1.06l-6.75 6.75c-.091.091-.2.168-.316.221a4.48 4.48 0 01-1.83.221c-.115-.053-.224-.13-.315-.221l-6.75-6.75a.75.75 0 010-1.06l6.75-6.75zm-6.178 6.91a.75.75 0 000 1.06l6.75 6.75c.091.091.2.168.316.221a4.48 4.48 0 001.83.221c.115-.053.224-.13.315-.221l6.75-6.75a.75.75 0 000-1.06l-6.75-6.75c-.091-.091-.2-.168-.316-.221a4.48 4.48 0 00-1.83-.221c-.115.053-.224.13-.315.221l-6.75 6.75z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">New employee onboarded</h4>
                        <p class="text-sm text-gray-500">Sarah Johnson joined Marketing Department</p>
                        <p class="text-xs text-gray-400">2 hours ago</p>
                    </div>
                </li>
                <!-- Activity Item 2 -->
                <li class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.036.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a.375.375 0 01-.375-.375V6.75A3.75 3.75 0 009 3H5.625zM10.5 17.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10.5 12a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10.5 6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM15 17.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM15 12a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Leave request approved</h4>
                        <p class="text-sm text-gray-500">Michael Chen's vacation leave approved</p>
                        <p class="text-xs text-gray-400">4 hours ago</p>
                    </div>
                </li>
                <!-- Activity Item 3 -->
                <li class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M15.75 2.25a.75.75 0 01.75.75v5.25h.75a.75.75 0 010 1.5h-.75V15a.75.75 0 01-1.5 0v-5.25H14.25a.75.75 0 010-1.5h.75V3a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                            <path d="M3 3.75A.75.75 0 013.75 3h6a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75h-6a.75.75 0 01-.75-.75V3.75z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">New job posting created</h4>
                        <p class="text-sm text-gray-500">Senior Developer position posted</p>
                        <p class="text-xs text-gray-400">6 hours ago</p>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.employees') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-tertiary text-white rounded-lg flex items-center justify-center mb-2">
                        <span class="material-icons h-7 w-7 text-primary">person_add</span>
                    </div>
                    <span class="text-sm font-medium text-primary">Add Employee</span>
                </a>
                <a href="{{ route('admin.employees') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-tertiary text-white rounded-lg flex items-center justify-center mb-2">
                        <span class="material-icons h-7 w-7 text-primary">currency_exchange</span>
                    </div>
                    <span class="text-sm font-medium text-primary">Payroll Management</span>
                </a>
                <a href="{{ route('admin.employees') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-tertiary text-white rounded-lg flex items-center justify-center mb-2">
                        <span class="material-icons h-7 w-7 text-primary">analytics</span>
                    </div>
                    <span class="text-sm font-medium text-primary">Generate Report</span>
                </a>
                <a href="{{ route('admin.employees') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-tertiary text-white rounded-lg flex items-center justify-center mb-2">
                        <span class="material-icons h-7 w-7 text-primary">person_search</span>
                    </div>
                    <span class="text-sm font-medium text-primary">ATS</span>
                </a>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxGrowth = document.getElementById('employeeGrowthChart');

    const growthLabels = @json($chartGrowthLabels);
    const growthData = @json($chartGrowthData);

    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: growthLabels,
            datasets: [{
                label: 'New Hires',
                data: growthData,
                borderWidth: 3,
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#4F46E5',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // dougnut chart
    const ctxDept = document.getElementById('departmentDistributionChart');

    const deptLabels = @json($chartDeptLabels);
    const deptData = @json($chartDeptData);

    const bgColors = [
        '#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
        '#EC4899', '#6366F1', '#14B8A6'
    ];

    new Chart(ctxDept, {
        type: 'doughnut',
        data: {
            labels: deptLabels,
            datasets: [{
                label: 'Employees',
                data: deptData,
                backgroundColor: bgColors.slice(0, deptData.length),
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
</script>
