<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">payments</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Payroll</p>
                <span class="text-2xl font-bold text-primary">Rp{{ number_format($totalPayroll, decimal_separator: ',', thousands_separator: '.') }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">attach_money</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Avg Base Salary</p>
                <span class="text-2xl font-bold text-primary">Rp{{ number_format($avgSalary, decimal_separator: ',', thousands_separator: '.') }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">receipt_long</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Defined Records</p>
                <span class="text-2xl font-bold text-primary">{{ $totalRecords }}</span>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <input type="text" wire:model.live.debounce.300ms="searchQuery"
                       class="bg-gray-100 rounded-md py-2.5 pl-10 pr-4 w-full focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white"
                       placeholder="Search by employee or account...">
            </div>
            <div class="flex gap-4">
                <button wire:click="toggleTaxForm" class="button-primary">
                    <span class="material-icons">gavel</span>
                    Configure Tax
                </button>
                <button wire:click="toggleFineForm" class="button-primary">
                    <span class="material-icons">content_cut</span>
                    Configure Fine
                </button>
                <button wire:click="toggleHealthInsurance" class="button-primary">
                    <span class="material-icons">health_and_safety</span>
                    Manage Health Insurance
                </button>
                <button wire:click="toggleSalaryForm" class="button-primary">
                    <span class="material-icons">add_card</span>
                    Define Salary
                </button>
            </div>
        </div>
    </div>

    <!-- Salaries Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Employee</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Bank Info</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Base Salary</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Allowances / Cuts</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Net Pay</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($salaries as $salary)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $salary->employee->name }}</div>
                            <div class="text-xs text-gray-500">{{ $salary->employee->job ? $salary->employee->job->name : '-' }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $salary->bank->name }}</div>
                            <div class="text-xs text-gray-500 font-mono">{{ $salary->bank_account }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-900">
                            Rp{{ number_format($salary->base_salary, 2, decimal_separator: ',', thousands_separator: '.') }}
                        </td>
                        <td class="p-4 whitespace-nowrap text-xs">
                            <div class="text-green-600">+ Rp{{ number_format($salary->allowance, 2, decimal_separator: ',', thousands_separator: '.') }}</div>
                            <div class="text-red-500">- Rp{{ number_format($salary->cut, 2, decimal_separator: ',', thousands_separator: '.') }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-bold text-primary">
                            Rp{{ number_format($salary->net_salary, 2, decimal_separator: ',', thousands_separator: '.') }}
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <button wire:click="editSalary({{ $salary->id }})" class="text-gray-400 hover:text-primary cursor-pointer">
                                    <span class="material-icons">edit_square</span>
                                </button>
                                {{-- Requested Style for Delete Button --}}
                                <button wire:click="toggleDeleteModal({{ $salary->id }})" class="text-gray-400 hover:text-red-500 cursor-pointer">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            No salary records found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $salaries->links('components.pagination') }}
    </div>

    {{--  Slide-over Form Salary  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isSalaryFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary cursor-pointer">
                {{ $salaryToEditId ? 'Edit Salary Details' : 'Define Salary' }}
            </h2>
            <button wire:click="toggleSalaryForm" class="text-gray-500 hover:text-red-500 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="saveSalary" class="flex flex-col gap-5">

                {{-- Employee Select --}}
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
                    @error('employee_id')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Bank Select --}}
                <div class="input-group">
                    <label for="bank_id" class="input-label">Bank Provider</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">account_balance</span>
                        <select wire:model.live="bank_id" id="bank_id" class="input-select">
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('bank_id')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Bank Account --}}
                <div class="input-group">
                    <label for="bank_account" class="input-label">Account Number</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">numbers</span>
                        <input wire:model.live="bank_account" id="bank_account" type="text" class="input-field" placeholder="e.g. 123-456-7890">
                    </div>
                    @error('bank_account')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Base Salary --}}
                <div class="input-group">
                    <label for="base_salary" class="input-label">Base Salary</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">money</span>
                        <input wire:model.live="base_salary" id="base_salary" type="number" step="0.01" class="input-field" placeholder="0.00">
                    </div>
                    @error('base_salary')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Allowance --}}
                    <div class="input-group">
                        <label for="allowance" class="input-label">Allowance</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">add_circle_outline</span>
                            <input wire:model.live="allowance" id="allowance" type="number" step="0.01" class="input-field" placeholder="0.00">
                        </div>
                        @error('allowance')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Cut --}}
                    <div class="input-group">
                        <label for="cut" class="input-label">Deduction (Cut)</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <span class="material-icons text-xl text-primary input-icon">remove_circle_outline</span>
                            <input wire:model.live="cut" id="cut" type="number" step="0.01" class="input-field" placeholder="0.00">
                        </div>
                        @error('cut')
                        <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                    <button wire:click="toggleSalaryForm" type="button" class="button-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary">
                        {{ $salaryToEditId ? 'Save Changes' : 'Submit' }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Slide-over Form Health Insurance  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isHealthInsurance ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary cursor-pointer">
                Configure Premium for Health Insurance
            </h2>
            <button wire:click="toggleHealthInsurance" class="text-gray-500 hover:text-red-500 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="saveHealthInsurance" class="flex flex-col gap-5">
                {{-- Health Insurance Value --}}
                <div class="input-group">
                    <label for="healthInsurance" class="input-label">Insurance Premium</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">price_check</span>
                        <input wire:model.live="healthInsurance" id="healthInsurance" type="text" class="input-field" placeholder="130000">
                    </div>
                    @error('healthInsurance')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                    <button wire:click="toggleHealthInsurance" type="button" class="button-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Slide-over Form Fine  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isFineFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary cursor-pointer">
                Configure Fine Value
            </h2>
            <button wire:click="toggleFineForm" class="text-gray-500 hover:text-red-500 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="saveFine" class="flex flex-col gap-5">
                {{-- Values --}}
                <div class="input-group">
                    <label for="late" class="input-label">Late Fine</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">money_off</span>
                        <input wire:model.live="late" id="late" type="text" class="input-field" placeholder="5000">
                    </div>
                    @error('late')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="absence" class="input-label">Absence Fine</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">money_off</span>
                        <input wire:model.live="absence" id="late" type="text" class="input-field" placeholder="100000">
                    </div>
                    @error('absence')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                    <button wire:click="toggleFineForm" type="button" class="button-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Slide-over Form Tax  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isTaxFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary cursor-pointer">
                Configure Tax Rate
            </h2>
            <button wire:click="toggleTaxForm" class="text-gray-500 hover:text-red-500 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="saveTax" class="flex flex-col gap-5">
                {{-- Amount --}}
                <div class="input-group">
                    <label for="tax" class="input-label">Tax Percentage</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">percent</span>
                        <input wire:model.live="tax" id="tax" type="text" class="input-field" placeholder="12">
                    </div>
                    @error('tax')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                    <button wire:click="toggleTaxForm" type="button" class="button-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Delete Modal  --}}
    @if($isDeleteModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center z-50">
            <div class="bg-surface-high p-6 w-fit min-w-[300px] rounded-lg shadow-xl">
                <h3 class="text-lg font-bold text-red-600 mb-2">Remove Salary Record?</h3>
                <p class="text-gray-600 text-sm mb-6">Are you sure? This will remove the payroll configuration for this employee.</p>
                <div class="flex gap-3 justify-end">
                    <button wire:click="toggleDeleteModal" class="button-secondary">Cancel</button>
                    <button wire:click="deleteSalary" class="button-danger border-gray-200 border-2 shadow-md">Confirm</button>
                </div>
            </div>
        </section>
    @endif
</main>
