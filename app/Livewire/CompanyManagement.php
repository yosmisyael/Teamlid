<?php

namespace App\Livewire;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class CompanyManagement extends Component
{
    protected $paginationTheme = 'tailwind';

    // State Management
    public bool $isDeleteModalOpen = false;
    public ?int $companyId = null; // The ID of the user's company

    // Form Properties
    public string $name = '';
    public string $address = '';
    public string $phone = '';
    public string $founded_date = '';
    public string $website = '';
    public string $description = '';
    public string $field = '';

    public function mount(): void
    {
        // Find the company registered by the current logged-in user
        // Assuming standard Auth. If using specific guard, adjust accordingly.
        $user = Auth::user();

        // Fallback for dev seeding if Auth is not fully active yet
        $userId = $user ? $user->id : 1;

        $company = Company::where('registered_by', $userId)->first();

        if ($company) {
            $this->companyId = $company->id;
            $this->name = $company->name;
            $this->address = $company->address ?? '';
            $this->phone = $company->phone ?? '';
            $this->founded_date = $company->founded_date ? $company->founded_date->format('Y-m-d') : '';
            $this->website = $company->website ?? '';
            $this->description = $company->description ?? '';
            $this->field = $company->field ?? '';
        }
    }

    public function saveCompany(): void
    {
        $uniqueIgnore = $this->companyId ? ',' . $this->companyId : '';

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255|unique:companies,address' . $uniqueIgnore,
            'phone' => 'nullable|string|max:20|unique:companies,phone' . $uniqueIgnore,
            'founded_date' => 'nullable|date',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:500',
            'field' => 'nullable|string|max:100',
        ]);

        if (!$this->companyId) {
            $validated['registered_by'] = Auth::id() ?? 1;
            $company = Company::create($validated);
            $this->companyId = $company->id;
            $message = 'Company registered successfully!';
        } else {
            Company::query()->findOrFail($this->companyId)->update($validated);
            $message = 'Profile updated successfully!';
        }

        session()->flash('success', $message);
    }

    public function toggleDeleteModal(): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
    }

    public function deleteCompany(): void
    {
        if (!$this->companyId) {
            return;
        }

        Company::destroy($this->companyId);

        // Reset state
        $this->reset(['companyId', 'name', 'address', 'phone', 'founded_date', 'website', 'description', 'field']);

        $this->toggleDeleteModal();
        session()->flash('success', 'Company profile deleted. You can now register a new one.');
    }

    public function render(): View
    {
        FacadesView::share('pageTitle', 'Company Profile');

        return view('livewire.company-management');
    }
}
