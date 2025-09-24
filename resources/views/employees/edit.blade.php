<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .material-input {
            transition: all 0.3s ease;
        }
        .material-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }
        .floating-label {
            transition: all 0.2s ease-in-out;
        }
        /* This is the general rule for floating labels on focus/fill */
        .input-focused .floating-label,
        .input-filled .floating-label {
            transform: translateY(-26px) scale(0.85);
            color: #3b82f6;
            padding: 0 4px; /* A little padding for the background */
            background-color: #fff;
        }

        /* * This is the SPECIFIC rule for labels that should ALWAYS be floated.
         * It targets the label inside a container with '.label-floated-default'.
        */
        .label-floated-default .floating-label {
            transform: translateY(-26px) scale(0.85);
            color: #6b7280; /* A neutral gray color for the default state */
            padding: 0 4px;
            background-color: #fff;
        }

        /* Rule to color the floated label on focus, even for the default-floated ones */
        .label-floated-default.input-focused .floating-label {
            color: #3b82f6;
        }

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
                        <h1 class="text-3xl font-bold text-gray-900">Employee Management</h1>
                        <p class="text-gray-600">Manage team effectively</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                    <span class="material-icons text-blue-500">business</span>
                    <span>3124500039 - Misyael Yosevian Wiarda</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Edit Employee Form -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <span class="material-icons text-blue-600 text-xl">edit</span>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Employee Details</h2>
                </div>

                <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="input-container relative">
                            <input type="text"
                                   id="nama_lengkap"
                                   name="nama_lengkap"
                                   value="{{ old('nama_lengkap', $employee->nama_lengkap) }}"
                                   class="material-input w-full px-4 pt-5 pb-1 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="nama_lengkap" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Full Name
                            </label>
                        </div>

                        <!-- Email -->
                        <div class="input-container relative">
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $employee->email) }}"
                                   class="material-input w-full px-4 pt-5 pb-1 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="email" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Email Address
                            </label>
                        </div>

                        <!-- Phone Number -->
                        <div class="input-container relative">
                            <input type="tel"
                                   id="nomor_telepon"
                                   name="nomor_telepon"
                                   value="{{ old('nomor_telepon', $employee->nomor_telepon) }}"
                                   class="material-input w-full px-4 pt-5 pb-1 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="nomor_telepon" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Phone Number
                            </label>
                        </div>

                        <!-- Birth Date (Label is always floated) -->
                        <div class="input-container relative label-floated-default">
                            <input type="date"
                                   id="tanggal_lahir"
                                   name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', $employee->tanggal_lahir) }}"
                                   class="material-input w-full px-4 pt-5 pb-1 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="tanggal_lahir" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Birth Date
                            </label>
                        </div>

                        <!-- Address -->
                        <div class="input-container relative md:col-span-2">
                                <textarea id="alamat"
                                          name="alamat"
                                          rows="3"
                                          class="material-input w-full px-4 pt-5 pb-1 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer resize-none"
                                          required
                                          onfocus="toggleLabel(this, true)"
                                          onblur="toggleLabel(this, false)">{{ old('alamat', $employee->alamat) }}</textarea>
                            <label for="alamat" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Address
                            </label>
                        </div>

                        <!-- Start Date (Label is always floated) -->
                        <div class="input-container relative label-floated-default">
                            <input type="date"
                                   id="tanggal_masuk"
                                   name="tanggal_masuk"
                                   value="{{ old('tanggal_masuk', $employee->tanggal_masuk) }}"
                                   class="material-input w-full px-4 pt-5 pb-1 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="tanggal_masuk" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Start Date
                            </label>
                        </div>

                        <!-- Status (Select) -->
                        <div class="input-container relative label-floated-default">
                            <select id="status"
                                    name="status"
                                    class="material-input w-full px-4 pt-5 pb-1 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                    required
                                    onfocus="toggleLabel(this, true)"
                                    onblur="toggleLabel(this, false)">
                                <option value="" disabled>Select a status</option>
                                <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>Active</option>
                                <option value="nonaktif" {{ old('status', $employee->status) == 'nonaktif' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <label for="status" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Employment Status
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button"
                                class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                            Cancel
                        </button>
                        <button type="submit"
                                class="btn-ripple px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2">
                            <span class="material-icons text-sm">save</span>
                            <span>Update Employee</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleLabel(input, isFocused) {
            const container = input.parentElement;

            if (isFocused) {
                container.classList.add('input-focused');
            } else {
                container.classList.remove('input-focused');
            }

            // Check for content to apply 'filled' class
            if (input.value) {
                container.classList.add('input-filled');
            } else {
                container.classList.remove('input-filled');
            }
        }

        // Ensure labels are in correct state on page load (e.g., for autofill or pre-filled edit forms)
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.material-input');
            inputs.forEach(input => {
                if (input.value) {
                    input.parentElement.classList.add('input-filled');
                }

                // For select elements, check selectedIndex
                if (input.tagName === 'SELECT' && input.selectedIndex > 0) {
                    input.parentElement.classList.add('input-filled');
                }
            });
        });

    </script>
</body>
</html>

