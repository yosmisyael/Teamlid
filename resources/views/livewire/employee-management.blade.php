<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">badge</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Workforce</p>
                <span class="text-2xl font-bold text-primary">{{ $totalEmployees }}</span>
            </div>
            <span class="text-sm font-medium text-green-500">+2%</span>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-green-600">verified_user</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Active</p>
                <span class="text-2xl font-bold text-green-600">{{ $activeEmployees }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-red-500">do_not_disturb_on</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Inactive</p>
                <span class="text-2xl font-bold text-red-500">{{ $inactiveEmployees }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">cake</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Birthdays (Month)</p>
                <span class="text-2xl font-bold text-primary">--</span>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <input type="text"
                       class="bg-gray-100 rounded-md py-2.5 pl-10 pr-4 w-full focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white"
                       placeholder="Search by name, email, or ID...">
            </div>
            <div class="flex items-center space-x-2">
                <button
                    class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <span class="material-icons text-gray-400 text-sm mr-2">filter_list</span>
                    Filter
                </button>
                <button
                    wire:click="toggleForm"
                    class="button-primary">
                        <span class="material-icons">
                            person_add
                        </span>
                    Onboard Employee
                </button>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 w-12"><input type="checkbox" class="h-4 w-4 text-secondary rounded border-gray-300 focus:ring-secondary"></th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Employee</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Job & Position</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Department</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Status</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($employees as $employee)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="h-4 w-4 text-secondary rounded border-gray-300"></td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <img class="w-10 h-10 rounded-full bg-gray-200 object-cover"
                                     src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=random"
                                     alt="{{ $employee->name }}">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $employee->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $employee->email }}</div>
                                    <div class="text-xs text-gray-400">{{ $employee->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-900 font-semibold">{{ $employee->position ? $employee->position->name : 'No Position' }}</span>
                                <span class="text-xs text-gray-500">{{ $employee->job ? $employee->job->name : 'No Job Profile' }}</span>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $employee->department->name }}
                            </span>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            @if($employee->status === 'active')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <button wire:click="editEmployee({{ $employee->id }})" class="text-gray-400 hover:text-primary cursor-pointer">
                                    <span class="material-icons">edit_square</span>
                                </button>
                                <button wire:click="toggleDeleteModal({{ $employee->id }})" class="text-gray-400 hover:text-red-500 cursor-pointer">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $employees->links('components.pagination') }}
    </div>

    {{--  Slide-over Form  --}}
    <section class="h-screen w-full md:w-2/3 lg:w-1/2 {{ $isFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary">
                {{ $employeeToEditId ? 'Edit Employee' : 'Onboard New Employee' }}
            </h2>
            <button wire:click="toggleForm" class="text-gray-500 hover:text-red-500 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="saveEmployee" class="flex flex-col gap-5">

                {{-- personal info field --}}
                <div class="bg-surface-high p-4 rounded-md border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-500 mb-3 uppercase tracking-wider">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- name field --}}
                        <div class="input-group">
                            <label class="input-label">Full Name</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">person</span>
                                <input wire:model="name" type="text" class="input-field">
                            </div>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        {{-- email field --}}
                        <div class="input-group">
                            <label class="input-label">Email Address</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">mail</span>
                                <input wire:model="email" type="email" class="input-field">
                            </div>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        {{-- password field --}}
                        @if(!$employeeToEditId)
                            <div class="input-group">
                                <label class="input-label">Account Password</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <span class="material-icons text-xl text-primary input-icon">key</span>
                                    <input wire:model="password" type="password" class="input-field">
                                </div>
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        @endif
                        {{-- phone field --}}
                        <div class="input-group">
                            <label class="input-label">Phone Number</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">phone_enabled</span>
                                <input wire:model="phone" type="text" class="input-field">
                            </div>
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        {{-- message field --}}
                        <div class="input-group">
                            <label class="input-label">Date of Birth</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">today</span>
                                <input wire:model="birth_date" type="date" class="input-field">
                            </div>
                            @error('birth_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        {{-- address field --}}
                        <div class="input-group md:col-span-2">
                            <label class="input-label">Residential Address</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">add_location_alt</span>
                                <textarea wire:model="address" rows="2" class="input-field"></textarea>
                            </div>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- employments field --}}
                <div class="bg-tertiary/10 p-4 rounded-md border border-blue-100">
                    <h3 class="text-sm font-bold text-secondary mb-3 uppercase tracking-wider">Employment Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Department (Triggers Job Filter) -->
                        <div class="input-group md:col-span-2">
                            <label class="input-label">Department</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">domain</span>
                                <select wire:model.live="department_id" class="input-select">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('department_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- job field --}}
                        <div class="input-group">
                            <label class="input-label">Job Profile</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">work</span>
                                <select wire:model.live="job_id" class="input-select" {{ $availableJobs->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">Select Job</option>
                                    @foreach($availableJobs as $job)
                                        <option value="{{ $job->id }}">{{ $job->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($availableJobs->isEmpty() && $department_id) <span class="text-xs text-gray-500">No jobs in this dept.</span> @endif
                            @error('job_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- position field --}}
                        <div class="input-group">
                            <label class="input-label">Position Title</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">account_tree</span>
                                <select wire:model="position_id" class="input-select" {{ $availablePositions->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">Select Position (Optional)</option>
                                    @foreach($availablePositions as $pos)
                                        <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($availablePositions->isEmpty() && $job_id) <span class="text-xs text-gray-500">No positions found.</span> @endif
                            @error('position_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- status field --}}
                        <div class="input-group md:col-span-2">
                            <label class="input-label">Status</label>
                            <div class="flex items-center gap-3 mt-2">
                                <label class="cursor-pointer flex-1 sm:flex-none">
                                    <input type="radio" wire:model="status" value="active" class="peer sr-only">
                                    <div class="px-4 py-2 rounded-md border border-gray-400 text-gray-500 hover:bg-gray-50 transition-all
                                                    peer-checked:border-primary peer-checked:text-primary peer-checked:bg-primary/10 peer-checked:border-2 peer-checked:shadow-sm font-medium flex items-center justify-center gap-2">
                                        <span class="material-icons text-lg">check_circle_outline</span>
                                        Active
                                    </div>
                                </label>
                                <label class="cursor-pointer flex-1 sm:flex-none">
                                    <input type="radio" wire:model="status" value="inactive" class="peer sr-only">
                                    <div class="px-4 py-2 rounded-md border border-gray-400 text-gray-500 hover:bg-gray-50 transition-all
                                                    peer-checked:border-red-500 peer-checked:text-red-700 peer-checked:bg-red-50/50 peer-checked:border-2 peer-checked:shadow-sm font-medium flex items-center justify-center gap-2">
                                        <span class="material-icons text-lg">highlight_off</span>
                                        Inactive
                                    </div>
                                </label>
                            </div>
                            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- buttons field --}}
                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                    <button wire:click="toggleForm" type="button" class="button-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary">
                        {{ $employeeToEditId ? 'Save Changes' : 'Onboard' }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Delete Modal  --}}
    @if($isDeleteModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center z-50">
            <div class="bg-surface-high p-6 w-96 rounded-lg shadow-xl">
                <h3 class="form-title">Confirm Termination</h3>
                <p class="text-gray-600 text-sm mb-6">Are you sure you want to move this employee to archives? This action triggers soft delete.</p>
                <div class="flex gap-3 justify-end">
                    <button wire:click="toggleDeleteModal" class="button-secondary">Cancel</button>
                    <button wire:click="deleteEmployee" class="button-danger border-2 border-gray-200 shadow-md">Confirm</button>
                </div>
            </div>
        </section>
    @endif
</main>
