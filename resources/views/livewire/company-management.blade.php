<main class="flex-1 overflow-y-auto bg-surface-low p-6">

    <div class="mx-auto space-y-6">
        <!-- Header Text -->
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $companyId ? 'Manage Company Profile' : 'Register Your Company' }}
            </h1>
            <p class="text-gray-500">
                {{ $companyId ? 'Update your organization details and public information.' : 'Please provide the details below to establish your company profile.' }}
            </p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Visual Header Line -->
            <div class="h-1.5 w-full bg-gradient-to-r from-primary to-secondary"></div>

            <form wire:submit.prevent="saveCompany" class="p-8">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Left Column: Description -->
                    <div class="lg:col-span-1 space-y-2">
                        <h3 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                            <span class="material-icons text-secondary text-2xl">business</span>
                            General Information
                        </h3>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Basic identification details for your company. This information will be visible on invoices and public reports.
                        </p>
                    </div>

                    <!-- Right Column: Fields -->
                    <div class="lg:col-span-2 space-y-5">
                        <!-- Company Name -->
                        <div class="input-group">
                            <label for="name" class="input-label">Company Name</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">business</span>
                                <input wire:model="name" id="name" type="text" class="input-field" placeholder="e.g. Acme Corporation">
                            </div>
                            @error('name') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Industry -->
                            <div class="input-group">
                                <label for="field" class="input-label">Industry / Sector</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <span class="material-icons text-xl text-primary input-icon">category</span>
                                    <input wire:model="field" id="field" type="text" class="input-field" placeholder="e.g. Technology">
                                </div>
                                @error('field') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Founded Date -->
                            <div class="input-group">
                                <label for="founded_date" class="input-label">Founded Date</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <span class="material-icons text-xl text-primary input-icon">event</span>
                                    <input wire:model="founded_date" id="founded_date" type="date" class="input-field">
                                </div>
                                @error('founded_date') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="input-group">
                            <label for="description" class="input-label">About</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons input-icon">descriptions</span>
                                <textarea wire:model="description" id="description" rows="3" class="input-field pl-4 py-3 h-auto" placeholder="Brief description of your company..."></textarea>
                            </div>
                            @error('description') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="my-8 border-t border-gray-100"></div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Left Column: Description -->
                    <div class="lg:col-span-1 space-y-2">
                        <h3 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                            <span class="material-icons text-secondary text-xl">contact_phone</span>
                            Contact & Location
                        </h3>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            How can people reach your organization? Provide your official headquarters address and contact channels.
                        </p>
                    </div>

                    <!-- Right Column: Fields -->
                    <div class="lg:col-span-2 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Phone -->
                            <div class="input-group">
                                <label for="phone" class="input-label">Phone Number</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <span class="material-icons text-xl text-primary input-icon">phone</span>
                                    <input wire:model="phone" id="phone" type="text" class="input-field" placeholder="+1 (555) ...">
                                </div>
                                @error('phone') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Website -->
                            <div class="input-group">
                                <label for="website" class="input-label">Website URL</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <span class="material-icons text-xl text-primary input-icon">language</span>
                                    <input wire:model="website" id="website" type="url" class="input-field" placeholder="https://">
                                </div>
                                @error('website') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="input-group">
                            <label for="address" class="input-label">Headquarters Address</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <span class="material-icons text-xl text-primary input-icon">location_on</span>
                                <input wire:model="address" id="address" type="text" class="input-field" placeholder="Full street address...">
                            </div>
                            @error('address') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-10 flex items-center justify-end pt-6 border-t border-gray-100">
                    <button type="submit" class="button-primary px-8 py-2.5 text-base shadow-md hover:shadow-lg transition-shadow">
                        <span class="material-icons mr-2 text-lg">save</span>
                        {{ $companyId ? 'Save Changes' : 'Register Company' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
