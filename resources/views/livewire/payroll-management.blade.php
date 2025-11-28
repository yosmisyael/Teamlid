<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">paid</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Disbursed</p>
                <span class="text-2xl font-bold text-primary">Rp{{ number_format($totalDisbursed, decimal_separator: ',', thousands_separator: '.') }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">receipt</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Transactions</p>
                <span class="text-2xl font-bold text-primary">{{ $countDisbursed }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">calendar_today</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Period</p>
                <span class="text-lg font-bold text-primary">{{ \Carbon\Carbon::parse($filterPeriod)->format('F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div class="flex gap-4 w-full max-w-2xl">
                <!-- Search -->
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-icons text-gray-400">search</span>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="searchQuery"
                           class="bg-gray-100 rounded-md py-2.5 pl-10 pr-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white"
                           placeholder="Search employee...">
                </div>

                <!-- Period Filter -->
                <div class="relative">
                    <input type="month" wire:model.live="filterPeriod"
                           class="bg-gray-100 rounded-md py-2.5 px-4 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm">
                </div>

                <button wire:click="$refresh()" class="cursor-pointer">
                    <span class="material-icons">refresh</span>
                </button>
            </div>
            <div class="flex gap-4">
                <button wire:click="toggleForm" class="button-primary whitespace-nowrap">
                    <span class="material-icons">add_card</span>
                    New Transaction
                </button>
                <button wire:click="toggleSetupForm" class="button-primary whitespace-nowrap">
                    <span class="material-icons">manage_history</span>
                    Setup Payroll Automation
                </button>
                <button wire:click="toggleRunModal" class="button-primary whitespace-nowrap">
                    <span class="material-icons">play_arrow</span>
                    Run Payroll Now
                </button>
            </div>
        </div>
    </div>

    <!-- Payroll Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Employee</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Period / Date</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Base</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Allowance / Cut</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Absence Deduction</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Net Paid</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($payrolls as $payroll)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $payroll->employee->name }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $payroll->employee->id }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-700">{{ $payroll->period_month }}</div>
                            <div class="text-xs text-gray-500">{{ $payroll->payment_date->format('M d, Y') }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-900">
                            Rp{{ number_format($payroll->base_salary, 2, decimal_separator: ',', thousands_separator: '.') }}
                        </td>
                        <td class="p-4 whitespace-nowrap text-xs">
                            <div class="text-green-600">+ Rp{{ number_format($payroll->allowance, 2, decimal_separator: ',', thousands_separator: '.') }}</div>
                            <div class="text-red-500">- Rp{{ number_format($payroll->cut, 2, decimal_separator: ',', thousands_separator: '.') }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm text-red-500">
                            Rp{{ number_format($payroll->absence_deduction, 2, decimal_separator: ',', thousands_separator: '.') }}
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-md bg-green-50 text-green-700 text-sm font-bold border border-green-100">
                                Rp{{ number_format($payroll->calculateNetSalary(), 2, decimal_separator: ',', thousands_separator: '.') }}
                            </span>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('payroll.download', $payroll->id) }}" target="_blank"
                                   class="text-gray-400 hover:text-blue-600 cursor-pointer p-1"
                                   title="Download PDF">
                                    <span class="material-icons">picture_as_pdf</span>
                                </a>
                                <button wire:click="editPayroll({{ $payroll->id }})" class="text-gray-400 hover:text-primary cursor-pointer">
                                    <span class="material-icons">edit_square</span>
                                </button>
                                <button wire:click="toggleDeleteModal({{ $payroll->id }})" class="text-gray-400 hover:text-red-500 cursor-pointerf">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            No payroll records found for this period.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $payrolls->links('components.pagination') }}
    </div>

    {{--  Manual Form  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary">
                {{ $payrollToEditId ? 'Edit Transaction' : 'Record Payment' }}
            </h2>
            <button wire:click="toggleForm" class="text-gray-500 cursor-pointer hover:text-red-500">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="savePayroll" class="flex flex-col gap-5">
                <!-- Employee Selection -->
                <div class="input-group">
                    <label for="employee_id" class="input-label">Employee</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">badge</span>
                        <select wire:model.live="employee_id" id="employee_id" class="input-select">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 ml-1">Selecting an employee autofills data if defined in Salary.</p>
                    @error('employee_id')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Period Month -->
                <div class="input-group">
                    <label for="period_month" class="input-label">Period (Month)</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">date_range</span>
                        <input wire:model="period_month" id="period_month" type="month" class="input-field">
                    </div>
                    @error('period_month')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Date -->
                <div class="input-group">
                    <label for="payment_date" class="input-label">Payment Date</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">event</span>
                        <input wire:model="payment_date" id="payment_date" type="date" class="input-field">
                    </div>
                    @error('payment_date')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-300 my-1"></div>

                <!-- Base Salary -->
                <div class="input-group">
                    <label for="base_salary" class="input-label">Base Salary Paid</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">money</span>
                        <input wire:model="base_salary" id="base_salary" type="number" step="0.01" class="input-field" placeholder="0.00">
                    </div>
                    @error('base_salary')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Allowance -->
                    <div class="input-group">
                        <label for="allowance" class="input-label">Allowance</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">add_circle</span>
                            <input wire:model="allowance" id="allowance" type="number" step="0.01" class="input-field" placeholder="0.00">
                        </div>
                        @error('allowance')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cut -->
                    <div class="input-group">
                        <label for="cut" class="input-label">Deduction</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">remove_circle</span>
                            <input wire:model="cut" id="cut" type="number" step="0.01" class="input-field" placeholder="0.00">
                        </div>
                        @error('cut')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                    <button wire:click="toggleForm" type="button" class="button-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary">
                        {{ $payrollToEditId ? 'Save Changes' : 'Confirm Payment' }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Delete Modal  --}}
    @if($isDeleteModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center z-50">
            <div class="bg-surface-high p-6 w-fit min-w-[300px] rounded-lg shadow-xl">
                <h3 class="text-lg font-bold text-red-600 mb-2">Delete Record?</h3>
                <p class="text-gray-600 text-sm mb-6">Are you sure you want to remove this payment record?</p>
                <div class="flex gap-3 justify-end">
                    <button wire:click="toggleDeleteModal" class="button-secondary">Cancel</button>
                    <button wire:click="deletePayroll" class="button-danger border-gray-200 border-2 shadow-md">Confirm</button>
                </div>
            </div>
        </section>
    @endif

    {{--  Run Payroll Modal  --}}
    @if($isRunModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center z-50">
            <div class="bg-surface-high p-6 w-fit min-w-[300px] rounded-lg shadow-xl">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    {{-- modal header --}}
                    <div class="sm:flex sm:items-center">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-tertiary sm:mx-0 sm:h-10 sm:w-10">
                            <span class="material-icons text-primary">autorenew</span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-primary font-semibold text-2xl" id="modal-title">
                                Run Monthly Payroll
                            </h3>
                        </div>
                    </div>
                    {{-- modal body --}}
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Period: <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($filterPeriod)->format('F Y') }}</span>
                        </p>

                        @if($pendingCount > 0)
                            <div class="mt-4 bg-tertiary/10 rounded-md border-l-4 border-primary p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <span class="material-icons text-primary text-sm">info</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-primary">
                                            There are <span class="font-bold">{{ $pendingCount }} employees </span> have not paid for the selected period.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-gray-400 mt-3">Employee preview:</p>
                            <ul class="mt-1 text-sm text-gray-600 list-disc list-inside bg-gray-50 p-2 rounded">
                                @foreach($pendingEmployeesList as $emp)
                                    <li>{{ $emp['name'] }}
                                        <span class="text-xs text-gray-400">
                                                    (ID: {{ $emp['id'] }})
                                                </span>
                                    </li>
                                @endforeach
                                @if($pendingCount > 5)
                                    <li class="list-none text-xs italic mt-1">...dan {{ $pendingCount - 5 }} lainnya.</li>
                                @endif
                            </ul>
                        @else
                            <div class="mt-4 bg-green-50 border-l-4 border-green-400 p-4">
                                <p class="text-sm text-green-700 font-medium">
                                    All active employee has been paid for the selected period.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-4">
                    @if($pendingCount > 0)
                        <button wire:click="runPayrollNow" wire:loading.attr="disabled" type="button" class="button-primary">
                            <span wire:loading.remove wire:target="runPayrollNow">Process Payments</span>
                            <span wire:loading wire:target="runPayrollNow">Processing...</span>
                        </button>
                    @endif
                    <button wire:click="toggleRunModal" type="button" class="button-secondary">
                        Close
                    </button>
                </div>
            </div>
        </section>
    @endif

    {{--  Setup Automation Modal  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isSetupFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold text-primary">
                    Setup Payroll Automation
                </h2>
                <button wire:click="toggleSetupForm" class="text-gray-500 cursor-pointer hover:text-red-500">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1">
                <form wire:submit.prevent="saveAutomation" class="flex flex-col gap-5">
                    <!-- Automation Status -->
                    <div class="input-group">
                        <label for="auto_is_active" class="input-label">Automation Status</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">toggle_on</span>
                            <select wire:model="auto_is_active" id="auto_is_active" class="input-select">
                                <option value="0">Inactive (Manual Run Only)</option>
                                <option value="1">Active (Auto-Run)</option>
                            </select>
                        </div>
                        @error('auto_is_active')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Run Date -->
                    <div class="input-group">
                        <label for="auto_run_date" class="input-label">Monthly Run Date</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">event</span>
                            <input wire:model="auto_run_date" id="auto_run_date" type="number" min="1" max="28" class="input-field" placeholder="e.g. 25">
                        </div>
                        <p class="text-xs text-gray-400 mt-1 ml-1">System will automatically generate payrolls on this date every month.</p>
                        @error('auto_run_date')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Run Time -->
                    <div class="input-group">
                        <label for="auto_run_time" class="input-label">Execution Time</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">schedule</span>
                            <input wire:model="auto_run_time" id="auto_run_time" type="time" class="input-field">
                        </div>
                        @error('auto_run_time')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                        <button wire:click="toggleSetupForm" type="button" class="button-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="button-primary">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </section>
</main>
