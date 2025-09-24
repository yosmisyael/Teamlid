<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee List</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
        }
        .card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }
        .btn-ripple::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn-ripple:active::before {
            width: 300px;
            height: 300px;
        }
        .search-input {
            transition: all 0.3s ease;
        }
        .search-input:focus {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }
        .table-row:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .7; }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg border-b-4 border-blue-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-500 p-2 rounded-lg">
                        <span class="material-icons text-white text-2xl">people</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Employee Directory</h1>
                        <p class="text-gray-600">Manage and view team members</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                    <span class="material-icons text-blue-500">business</span>
                    <span>3124500039 - Misyael Yosevian Wiarda</span>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Employees</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $employees->total() }}</p>
                    </div>
                    <div class="bg-blue-100 px-[16px] py-3 rounded-full">
                        <span class="material-icons text-blue-600 text-xl">group</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Active</p>
                        <p class="text-3xl font-bold text-green-600">{{ $employees->where('status', 'aktif')->count() }}</p>
                    </div>
                    <div class="bg-green-100 px-[16px] py-3 rounded-full">
                        <span class="material-icons text-green-600 text-xl">check_circle</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Inactive</p>
                        <p class="text-3xl font-bold text-red-600">{{ $employees->where('status', 'nonaktif')->count() + $inactiveEmployees }}</p>
                    </div>
                    <div class="bg-red-100 px-[15px] py-3 rounded-full">
                        <span class="material-icons text-red-600 text-xl">cancel</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Actions Bar -->
        <div class="bg-white rounded-2xl card-shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                        <input type="text"
                               placeholder="Search employees..."
                               class="search-input pl-10 pr-4 py-3 w-64 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                               id="searchInput"
                               onkeyup="searchEmployees()">
                    </div>
                    <select class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" id="statusFilter" onchange="filterByStatus()">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="flex items-center space-x-3">
                    <button class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center space-x-2">
                        <span class="material-icons text-sm">download</span>
                        <span>Export</span>
                    </button>
                    <a href="{{ route('employees.create') ?? '#' }}" class="btn-ripple px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2">
                        <span class="material-icons text-sm">add</span>
                        <span>Add Employee</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="material-icons text-white text-2xl">list</span>
                        <h2 class="text-2xl font-semibold text-white">Employee List</h2>
                    </div>
                    <div class="text-blue-100 text-sm">
                        <span id="employee-count">{{ $employees->total() }}</span> employees found
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full" id="employeeTable">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact Info</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Birth Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Address</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($employees->total() > 0)
                            @foreach($employees as $employee)
                                <tr class="table-row transition-all duration-200" data-status="{{ $employee->status }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $employee->nama_lengkap }}</div>
                                                <div class="text-sm text-gray-500">ID: EMP{{ str_pad($employee->id, 3, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-base text-gray-900 font-medium">{{ $employee->email }}</div>
                                        <div class="text-base text-gray-500">{{ $employee->nomor_telepon }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-base text-gray-900">{{ $employee->tanggal_lahir }}</td>
                                    <td class="px-6 py-4 text-base text-gray-900">{{ $employee->alamat }}</td>
                                    <td class="px-6 py-4 text-base text-gray-900">{{ $employee->tanggal_masuk }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-4 py-2 text-base font-semibold rounded-full items-center
                                            {{ $employee->status == 'aktif' ? 'bg-green-100 text-green-800' :
                                               ($employee->status == 'nonaktif' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            <span class="w-2 h-2 rounded-full mr-2 mt-0.5
                                                {{ $employee->status == 'aktif' ? 'bg-green-400' :
                                                   ($employee->status == 'nonaktif' ? 'bg-red-400' : 'bg-yellow-400') }}"></span>
                                            {{ $employee->status == 'aktif' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center space-x-1">
                                            <a href="{{ route('employees.show', $employee->id) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded-full transition-colors duration-200" title="View Details">
                                                <span class="material-icons text-lg">visibility</span>
                                            </a>
                                            <a href="{{ route('employees.edit', $employee->id) }}" class="p-2 text-amber-600 hover:bg-amber-100 rounded-full transition-colors duration-200" title="Edit Employee">
                                                <span class="material-icons text-lg">edit</span>
                                            </a>
                                            <button
                                                type="submit"
                                                onclick="openDeleteChoiceModal('{{ $employee->nama_lengkap }}')"
                                                class="p-2 text-red-600 hover:bg-red-100 rounded-full transition-colors duration-200" title="Delete Employee">
                                                <span class="material-icons text-lg">
                                                    delete
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <form id="softDeleteForm" action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <form id="forceDeleteForm" action="{{ route('employees.forceDelete', $employee->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        @else
                            <tr class="table-row transition-all duration-200">
                                <td colspan="7" class="px-6 py-4 text-center">
                                    No employees data found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        @if($employees->total() > 0)
                            Showing <span class="font-medium">{{ $employees->firstItem() }}</span> to <span class="font-medium"> {{ $employees->lastItem() }} </span> of <span class="font-medium">{{ $employees->total() }}</span> results
                        @else
                            Showing <span class="font-medium"> 0 </span> of <span class="font-medium">{{ $employees->total() }}</span> results
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl card-shadow text-center py-16 hidden" id="empty-state">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-icons text-gray-400 text-4xl">people_outline</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No employees found</h3>
            <p class="text-gray-500 mb-8">Try adjusting your search or filter criteria, or add a new employee.</p>
            <a href="#" class="btn-ripple px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center space-x-2">
                <span class="material-icons text-sm">add</span>
                <span>Add First Employee</span>
            </a>
        </div>
    </div>

    <!-- Delete Choice Modal -->
    <div id="deleteChoiceModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 card-shadow">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                    <span class="material-icons text-yellow-600 text-xl">delete_sweep</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Choose Deletion Method</h3>
                    <p class="text-gray-600">Select how to remove <span id="employeeNameChoice" class="font-semibold"></span>.</p>
                </div>
            </div>
            <p class="text-gray-700 mb-8">
                <b>Soft Delete</b> will hide the employee from lists but keep their data for potential recovery.
                <br>
                <b>Permanent Delete</b> will erase the employee's record forever. This cannot be undone.
            </p>
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                <button onclick="closeDeleteModals()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                    Cancel
                </button>
                <button onclick="document.getElementById('softDeleteForm').submit()" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
                    Soft Delete
                </button>
                <button onclick="handlePermanentDeleteChoice()" class="px-6 py-3 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                    Permanent Delete
                </button>
            </div>
        </div>
    </div>

    <!--Permanant Delete Confirmation -->
    <div id="permanentDeleteModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 card-shadow">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <span class="material-icons text-red-600 text-xl">warning</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Are you absolutely sure?</h3>
                    <p class="text-gray-600">This action cannot be undone.</p>
                </div>
            </div>
            <p class="text-gray-700 mb-8">Are you sure you want to permanently delete the record for <span id="employeeNamePermanent" class="font-semibold"></span>? All data will be lost forever.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModals()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                    Cancel
                </button>
                <button onclick="document.getElementById('forceDeleteForm').submit()" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                    Yes, Permanently Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        function searchEmployees() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('employeeTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            let visibleCount = 0;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();

                if (name.includes(searchInput) || email.includes(searchInput)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }

            updateEmployeeCount(visibleCount);
        }

        // Filter by status
        function filterByStatus() {
            const statusFilter = document.getElementById('statusFilter').value;
            const table = document.getElementById('employeeTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            let visibleCount = 0;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const status = row.getAttribute('data-status');

                if (statusFilter === '' || status === statusFilter) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }

            updateEmployeeCount(visibleCount);
        }

        // Update employee count
        function updateEmployeeCount(count) {
            document.getElementById('employee-count').textContent = count;
        }

        // modals for delete
        const deleteChoiceModal = document.getElementById('deleteChoiceModal');
        const permanentDeleteModal = document.getElementById('permanentDeleteModal');
        const employeeNameChoiceSpan = document.getElementById('employeeNameChoice');
        const employeeNamePermanentSpan = document.getElementById('employeeNamePermanent');

        function openDeleteChoiceModal(employeeName) {
            employeeNameChoiceSpan.textContent = employeeName;
            employeeNamePermanentSpan.textContent = employeeName;
            deleteChoiceModal.classList.remove('hidden');
        }

        function closeDeleteModals() {
            deleteChoiceModal.classList.add('hidden');
            permanentDeleteModal.classList.add('hidden');
        }

        function handlePermanentDeleteChoice() {
            deleteChoiceModal.classList.add('hidden');
            permanentDeleteModal.classList.remove('hidden');
        }
    </script>
</body>
</html>
