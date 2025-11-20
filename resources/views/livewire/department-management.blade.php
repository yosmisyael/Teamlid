<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">domain</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Departments</p>
                <span class="text-2xl font-bold text-primary">{{ $totalDepartments }}</span>
            </div>
            <span class="text-sm font-medium text-green-500">+12%</span>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">groups</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Employees</p>
                <span class="text-2xl font-bold text-primary">{{ $totalEmployees }}</span>
            </div>
            <span class="text-sm font-medium text-green-500">+8%</span>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">person</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Average per Dept</p>
                <span class="text-2xl font-bold text-primary">{{ $averageEmployeesPerDepartment }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">person_search</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Open Positions</p>
                <span class="text-2xl font-bold text-primary">12</span>
            </div>
            <span class="text-sm font-medium text-green-500">+5%</span>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <input type="text"
                       class="bg-gray-100 rounded-md py-2.5 pl-10 pr-4 w-full focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white"
                       placeholder="Search departments by name, head, or location...">
            </div>
            <div class="flex items-center space-x-2">
                <button
                    class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M3.75 5.25a1.5 1.5 0 011.5-1.5h13.5a1.5 1.5 0 010 3H5.25a1.5 1.5 0 01-1.5-1.5zm0 6a1.5 1.5 0 011.5-1.5h13.5a1.5 1.5 0 010 3H5.25a1.5 1.5 0 01-1.5-1.5zm0 6a1.5 1.5 0 011.5-1.5h13.5a1.5 1.5 0 010 3H5.25a1.5 1.5 0 01-1.5-1.5z"
                              clip-rule="evenodd"/>
                    </svg>
                    Filters
                </button>
                <button
                    class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M11.47 2.47a.75.75 0 011.06 0l4.5 4.5a.75.75 0 01-1.06 1.06l-3.22-3.22V16.5a.75.75 0 01-1.5 0V4.81L8.03 8.03a.75.75 0 01-1.06-1.06l4.5-4.5zM3 15.75a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z"
                              clip-rule="evenodd"/>
                    </svg>
                    Export
                </button>
                <button
                    wire:click="toggleForm"
                    class="button-primary">
                        <span class="material-icons">
                            add
                        </span>
                    Add New Department
                </button>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-gray-500">Quick filters:</span>
            <a href="#" class="px-3 py-1 rounded-full text-sm font-medium bg-tertiary text-primary">All
                Departments</a>
            <a href="#" class="px-3 py-1 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100">Active</a>
            <a href="#" class="px-3 py-1 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100">With
                Vacancies</a>
        </div>
    </div>

    <!-- Departments Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <!-- Table Header -->
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 w-12"><input type="checkbox"
                                                class="h-4 w-4 text-secondary rounded border-gray-300 focus:ring-secondary">
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Department Name
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Head
                        of Department
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Total
                        Employees
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Created Date
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <!-- Table Body -->
                <tbody class="divide-y divide-gray-200">
                @foreach($departments as $department)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4">
                            <input type="checkbox"
                                   class="h-4 w-4 text-secondary rounded border-gray-300 focus:ring-secondary">
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $department->name }}</div>
                                    <div class="text-xs text-gray-500">Core Development</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <img class="w-9 h-9 rounded-full"
                                     src="https://placehold.co/40x40/93D5F1/176688?text={{ $department->manager != null ? \Illuminate\Support\Str::substr($department->manager->name, 2) : '?' }}">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $department->manager != null ? $department->manager->name : 'Not set' }}</div>
                                    <div class="text-xs text-gray-500">{{ $department->manager != null ? $department->manager->id : 'Not set' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-700 font-medium">{{ $department->employees->count() }} <span
                                class="text-green-500">Active</span></td>
                        <td class="p-4 whitespace-nowrap">
                            @php
                                $date = Carbon\Carbon::parse($department->createdAt)
                            @endphp
                            <div class="text-sm text-gray-900">{{ $date->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $date->diffForHumans() }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                {{--  action view  --}}
                                <button class="text-gray-400 hover:text-secondary">
                                    <span class="material-icons">visibility</span>
                                </button>
                                {{--  action edit  --}}
                                <button wire:click="editDepartment({{ $department->id }})" class="text-gray-400 hover:text-secondary">
                                    <span class="material-icons">edit_square</span>
                                </button>
                                {{--  action delete  --}}
                                <button wire:click="toggleDeleteModal({{ $department->id }})" class="text-gray-400 hover:text-red-500">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table Pagination -->
        {{ $departments->links('components.pagination') }}
    </div>

    {{--  Department Form  --}}
    <section
        class="h-screen w-1/3 {{ $isFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-10 bg-surface-high rounded-lg shadow-lg">
        <div class="p-6">
            <form action="" wire:submit.prevent="saveDepartment" class="flex flex-col gap-4">
                <h2 class="form-title">
                    {{ $departmentToEditId ? 'Edit Department: ' . $this->name : 'Add New Department' }}
                </h2>
                <div class="input-group">
                    <label for="name" class="input-label">Department Name</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">domain</span>
                        <input id="name" wire:model.live="name" type="text" class="input-field">
                    </div>
                    @error('name')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid department name</span> {{ $message }}</p>
                    @enderror
                </div>
                <div class="input-group">
                    <label for="manager" class="input-label">Department Manager</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">person</span>
                        <select wire:model.live="manager_id" id="manager_id" class="input-select">
                            <option value="null">Select department manager</option>
                            @foreach($managerCandidate as $candidate)
                                <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('manager')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid department name</span> {{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3 justify-end mt-5">
                    <button wire:click="toggleForm" type="button" class="button-secondary w-fit">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary w-fit">
                        {{ $departmentToEditId ? 'Save Changes' : 'Add Department' }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Delete Department Modal  --}}
    @if($isDeleteModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center">
            <div class="bg-surface-high p-4 w-fit rounded-lg">
                <form wire:submit.prevent="deleteDepartment" class="flex flex-col gap-4">
                    <h3 class="form-title">Delete Confirmation</h3>
                    <p class="text-primary">Are you sure want to remove this department?</p>
                    <div class="flex gap-3 justify-end">
                        <button wire:click="toggleDeleteModal" type="button" class="button-secondary">
                            Cancel
                        </button>
                        <button class="button-danger shadow-md border border-gray-200" type="submit">Remove</button>
                    </div>
                </form>
            </div>
        </section>
    @endif
</main>
