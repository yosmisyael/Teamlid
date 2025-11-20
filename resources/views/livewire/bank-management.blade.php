<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">account_balance</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Banks</p>
                <span class="text-2xl font-bold text-primary">{{ $totalBanks }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Available</p>
                <span class="text-2xl font-bold text-primary">{{ $availableBanks }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">block</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Unavailable</p>
                <span class="text-2xl font-bold text-primary">{{ $unavailableBanks }}</span>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <input type="text" wire:model.live.debounce.300ms="searchQuery"
                       class="bg-gray-100 rounded-md py-2.5 pl-10 pr-4 w-full focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white"
                       placeholder="Search banks...">
            </div>
            <div class="flex items-center space-x-2">
                <select wire:model.live="filterStatus" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-secondary text-sm">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                </select>
                <button wire:click="toggleForm" class="button-primary">
                    <span class="material-icons">add_business</span>
                    Add Bank
                </button>
            </div>
        </div>
    </div>

    <!-- Banks Table -->
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 w-12"><input type="checkbox" class="h-4 w-4 text-secondary rounded border-gray-300 focus:ring-secondary"></th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Bank Name</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Status</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Last Updated</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($banks as $bank)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="h-4 w-4 text-secondary rounded border-gray-300"></td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-primary font-bold">
                                    {{ substr($bank->name, 0, 1) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $bank->name }}</div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            @if($bank->status === 'available')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Available
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Unavailable
                                </span>
                            @endif
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $bank->updated_at->diffForHumans() }}
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <button wire:click="editBank({{ $bank->id }})" class="text-gray-400 hover:text-secondary">
                                    <span class="material-icons">edit_square</span>
                                </button>
                                <button wire:click="toggleDeleteModal({{ $bank->id }})" class="text-gray-400 hover:text-red-500">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            No banks found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $banks->links('components.pagination') }}
    </div>

    {{-- Form  --}}
    <section class="h-screen w-full md:w-1/3 {{ $isFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-20 bg-surface-high shadow-2xl flex flex-col">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-primary">
                {{ $bankToEditId ? 'Edit Bank' : 'Add New Bank' }}
            </h2>
            <button wire:click="toggleForm" class="text-gray-500 hover:text-red-500">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto flex-1">
            <form wire:submit.prevent="saveBank" class="flex flex-col gap-5">

                {{-- Bank Name Input --}}
                <div class="input-group">
                    <label for="name" class="input-label">Bank Name</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">account_balance</span>
                        <input wire:model.live="name" id="name" type="text" class="input-field" placeholder="e.g. BCA">
                    </div>
                    @error('name')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid name</span> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Input --}}
                <div class="input-group">
                    <label for="status" class="input-label">Status</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">toggle_on</span>
                        <select wire:model.live="status" id="status" class="input-select">
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                    @error('status')
                    <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Invalid status</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200 mt-auto">
                    <button wire:click="toggleForm" type="button" class="button-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="button-primary">
                        {{ $bankToEditId ? 'Save Changes' : 'Add Bank' }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{--  Delete Modal  --}}
    @if($isDeleteModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center z-50">
            <div class="bg-surface-high p-6 w-96 rounded-lg shadow-xl">
                <h3 class="text-lg font-bold text-red-600 mb-2">Delete Bank?</h3>
                <p class="text-gray-600 text-sm mb-6">Are you sure you want to remove this bank? This might affect payroll records linked to it.</p>
                <div class="flex gap-3 justify-end">
                    <button wire:click="toggleDeleteModal" class="button-secondary">Cancel</button>
                    <button wire:click="deleteBank" class="button-danger border-gray-200 border-2 shadow-md">Confirm</button>
                </div>
            </div>
        </section>
    @endif
</main>
