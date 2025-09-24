@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Details</title>
    @vite('resources/css/app.css')
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

        .profile-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .info-item {
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .avatar-shadow {
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
        }

        .status-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 12px;
            height: 12px;
            background: #3b82f6;
            border-radius: 50%;
            border: 3px solid white;
        }

        .timeline-line {
            position: absolute;
            left: -1px;
            top: 12px;
            bottom: -12px;
            width: 2px;
            background: #e5e7eb;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg border-b-4 border-blue-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('employees.index') ?? '#' }}"
                       class="p-2 text-blue-600 hover:bg-blue-100 rounded-full transition-colors duration-200"
                       title="Back to Employee List">
                        <span class="material-icons text-2xl">arrow_back</span>
                    </a>
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-500 p-2 rounded-lg">
                            <span class="material-icons text-white text-2xl">person</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Employee Details</h1>
                            <p class="text-gray-600">Complete employee information</p>
                        </div>
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
        <!-- Employee Profile Header -->
        <div class="bg-white rounded-2xl card-shadow overflow-hidden mb-8 fade-in">
            <div class="profile-gradient px-8 py-12 relative">
                <div class="absolute top-6 right-6">
                    <div class="flex space-x-2">
                        <a href="{{ route('employees.edit', $employee->id ?? 1) ?? '#' }}"
                           class="btn-ripple py-3 px-[15px] bg-white bg-opacity-20 text-white rounded-full hover:bg-opacity-30 transition-all duration-300"
                           title="Edit Employee">
                            <span class="material-icons text-indigo-700">edit</span>
                        </a>
                        <button onclick="confirmDelete()"
                                class="btn-ripple py-3 px-[15px] bg-white bg-opacity-20 text-white rounded-full hover:bg-opacity-30 transition-all duration-300"
                                title="Delete Employee">
                            <span class="material-icons text-indigo-700">delete</span>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                    <div class="relative">
                        <div
                            class="w-32 h-32 bg-white rounded-full flex items-center justify-center text-4xl font-bold text-blue-600 avatar-shadow">
                            {{ strtoupper(substr($employee->nama_lengkap, 0, 2)) }}
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-400 rounded-full border-4 border-white flex items-center justify-center">
                            <span class="w-3 h-3 bg-green-600 rounded-full status-pulse"></span>
                        </div>
                    </div>

                    <div class="text-center md:text-left text-white flex-1">
                        <h2 class="text-4xl font-bold mb-2">{{ $employee->nama_lengkap }}</h2>
                        <p class="text-xl text-blue-100 mb-4">{{ $employee->status == 'aktif' ? 'Active Employee' : 'Inactive Employee' }}</p>
                        <div
                            class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-6 text-blue-100">
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <span class="material-icons text-lg">badge</span>
                                <span>ID: EMP{{ str_pad($employee->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <span class="material-icons text-lg">calendar_today</span>
                                <span>Joined {{ date('M d, Y', strtotime($employee->tanggal_masuk)) }}</span>
                            </div>
                            <div class="flex items-center justify-center md:justify-start space-x-2">
                                <span class="material-icons text-lg">schedule</span>
                                <span>{{ floor(Carbon::parse($employee->tanggal_masuk)->diffInMonths(now())) }} months</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Personal Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl card-shadow p-8 mb-8 slide-in">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <span class="material-icons text-blue-600 text-xl">person_outline</span>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800">Personal Information</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">email</span>
                                <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Email
                                    Address</label>
                            </div>
                            <p class="text-gray-900 font-medium">{{ $employee->email ?? 'ahmad.dahlan@pens.ac.id' }}</p>
                        </div>

                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">phone</span>
                                <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Phone
                                    Number</label>
                            </div>
                            <p class="text-gray-900 font-medium">{{ $employee->nomor_telepon ?? '+62 812 3456 7890' }}</p>
                        </div>

                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">cake</span>
                                <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Date of
                                    Birth</label>
                            </div>
                            <p class="text-gray-900 font-medium">{{ date('M d, Y', strtotime($employee->tanggal_lahir ?? '1992-03-15')) }}</p>
                            <p class="text-sm text-gray-500">{{ Carbon::parse($employee->tanggal_lahir ?? '1992-03-15')->age ?? '31' }}
                                years old</p>
                        </div>

                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">event</span>
                                <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Start
                                    Date</label>
                            </div>
                            <p class="text-gray-900 font-medium">{{ date('M d, Y', strtotime($employee->tanggal_masuk ?? '2023-01-15')) }}</p>
                            <p class="text-sm text-gray-500">{{ Carbon::parse($employee->tanggal_masuk ?? '2023-01-15')->diffForHumans() ?? '10 months ago' }}</p>
                        </div>

                        <div class="info-item bg-gray-50 rounded-xl p-4 md:col-span-2">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">location_on</span>
                                <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Address</label>
                            </div>
                            <p class="text-gray-900 font-medium">{{ $employee->alamat ?? 'Jl. Ahmad Yani No. 123, Surabaya, East Java 60234, Indonesia' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Employment Details -->
                <div class="bg-white rounded-2xl card-shadow p-8 slide-in">
                    <div class="flex items-center mb-6">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <span class="material-icons text-green-600 text-xl">work</span>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800">Employment Details</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">badge</span>
                                <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Employee
                                    ID</label>
                            </div>
                            <p class="text-gray-900 font-medium">
                                EMP{{ str_pad($employee->id ?? 1, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>

                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">assignment_ind</span>
                                <label
                                    class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Department</label>
                            </div>
                            <p class="text-gray-900 font-medium">Information Technology</p>
                        </div>

                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-gray-500 text-lg mr-2">trending_up</span>
                                <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Position</label>
                            </div>
                            <p class="text-gray-900 font-medium">Senior Software Engineer</p>
                        </div>

                        <div class="info-item bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-500 text-lg mr-2">verified_user</span>
                                    <label class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Employment
                                        Status</label>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                        {{ ($employee->status ?? 'Active') == 'Active' ? 'bg-green-100 text-green-800' :
                                           (($employee->status ?? 'Active') == 'Inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        <span class="w-2 h-2 rounded-full mr-2 mt-1
                                            {{ ($employee->status ?? 'Active') == 'Active' ? 'bg-green-400' :
                                               (($employee->status ?? 'Active') == 'Inactive' ? 'bg-red-400' : 'bg-yellow-400') }}"></span>
                                        {{ $employee->status ?? 'Active' }}
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats & Actions -->
            <div class="space-y-8">
                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                    <div class="flex items-center mb-6">
                        <div class="bg-purple-100 p-3 rounded-full mr-3">
                            <span class="material-icons text-purple-600 text-xl">analytics</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Quick Stats</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons text-blue-600">schedule</span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Service Length</p>
                                    <p class="font-semibold text-gray-900">{{ floor(Carbon::parse($employee->tanggal_masuk)->diffInMonths(now())) }}
                                        months</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons text-green-600">event_available</span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Days Until Birthday</p>
                                    @php
                                        $birthDate = Carbon::parse($employee->tanggal_lahir);

                                        $today = Carbon::today();

                                        $nextBirthday = $birthDate->copy()->year($today->year);

                                        if ($nextBirthday->isBefore($today)) {
                                            $nextBirthday->addYear();
                                        }

                                        $daysUntilBirthday = $today->diffInDays($nextBirthday);
                                    @endphp
                                    <p class="font-semibold text-gray-900">
                                        {{ floor($daysUntilBirthday) }}
                                        days
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons text-yellow-600">star</span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Performance</p>
                                    <p class="font-semibold text-gray-900">Excellent</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Timeline -->
                <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                    <div class="flex items-center mb-6">
                        <div class="bg-indigo-100 p-3 rounded-full mr-3">
                            <span class="material-icons text-indigo-600 text-xl">timeline</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Recent Activity</h3>
                    </div>

                    <div class="space-y-4 relative pl-6">
                        <div class="timeline-line"></div>

                        <div class="relative timeline-item">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="font-medium text-gray-900">Profile Updated</p>
                                <p class="text-sm text-gray-600">Contact information was updated</p>
                                <p class="text-xs text-gray-500 mt-1">2 days ago</p>
                            </div>
                        </div>

                        <div class="relative timeline-item">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="font-medium text-gray-900">Project Completed</p>
                                <p class="text-sm text-gray-600">Finished backend development</p>
                                <p class="text-xs text-gray-500 mt-1">1 week ago</p>
                            </div>
                        </div>

                        <div class="relative timeline-item">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="font-medium text-gray-900">Training Attended</p>
                                <p class="text-sm text-gray-600">Completed React Advanced workshop</p>
                                <p class="text-xs text-gray-500 mt-1">2 weeks ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('employees.edit', $employee->id ?? 1) ?? '#' }}"
                           class="btn-ripple w-full flex items-center justify-center space-x-3 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <span class="material-icons text-lg">edit</span>
                            <span>Edit Employee</span>
                        </a>

                        <button
                            class="w-full flex items-center justify-center space-x-3 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                            <span class="material-icons text-lg">print</span>
                            <span>Print Profile</span>
                        </button>

                        <button
                            class="w-full flex items-center justify-center space-x-3 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                            <span class="material-icons text-lg">email</span>
                            <span>Send Email</span>
                        </button>

                        <button onclick="confirmDelete()"
                                class="w-full flex items-center justify-center space-x-3 px-4 py-3 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                            <span class="material-icons text-lg">delete</span>
                            <span>Delete Employee</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 card-shadow">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <span class="material-icons text-red-600 text-xl">warning</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Delete Employee</h3>
                    <p class="text-gray-600">This action cannot be undone</p>
                </div>
            </div>
            <p class="text-gray-700 mb-8">Are you sure you want to delete <span
                    class="font-semibold">{{ $employee->nama_lengkap ?? 'Ahmad Dahlan' }}</span>? All data associated with
                this employee will be permanently removed.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                    Cancel
                </button>
                <form action="{{ route('employees.destroy', $employee->id ?? 1) ?? '#' }}" method="POST"
                      style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-6 py-3 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                        Delete Employee
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Delete confirmation modal
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Escape key to close modal
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Initialize animations
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.fade-in, .slide-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0) translateX(0)';
                }, index * 100);
            });
        });
</script>
</body>
</html>
