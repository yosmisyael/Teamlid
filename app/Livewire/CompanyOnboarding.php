<?php

namespace App\Livewire;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CompanyOnboarding extends Component
{
    public $currentStep = 1;

    #[Title('Onboarding step')]

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|string|max:255')]
    public $address = '';

    #[Rule('nullable|string|max:20|unique:companies,phone')]
    public $phone = '';

    #[Rule('nullable|date')]
    public $founded_date = null;

    #[Rule('nullable|url|max:255')]
    public $website = '';

    #[Rule('required|string|max:1000')]
    public $description = '';

    #[Rule('required|string|max:255')]
    public $field = '';

    public function nextStep(): void
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20|unique:companies,phone',
            ]);
        }

        $this->currentStep++;
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function saveCompany(): null
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20|unique:companies,phone',
            'founded_date' => 'nullable|date',
            'website' => 'nullable|url|max:255',
            'description' => 'required|string|max:1000',
            'field' => 'required|string|max:255',
        ]);

        $admin = Auth::guard('admins')->user();

        Company::query()->create([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'founded_date' => $this->founded_date,
            'website' => $this->website,
            'description' => $this->description,
            'field' => $this->field,
            'registered_by' => $admin->id,
        ]);

        session()->flash('success', 'Company setup complete! Welcome to Teamable.');

        return $this->redirect('/admin/dashboard', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.company-onboarding', [
            'title' => 'Company Onboarding Step ' . $this->currentStep,
        ]);
    }
}
