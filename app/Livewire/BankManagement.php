<?php

namespace App\Livewire;

use App\Models\Bank;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class BankManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;
    public bool $isDeleteModalOpen = false;
    public ?int $bankToDeleteId = null;
    public ?int $bankToEditId = null;

    // Form Properties
    #[Rule('required|string|unique:banks,name')]
    public string $name = '';
    #[Rule('required|in:available,unavailable')]
    public string $status = 'available';

    // Filter Properties
    public string $searchQuery = '';
    public string $filterStatus = '';

    public function toggleForm(): void
    {
        $this->isFormOpen = !$this->isFormOpen;

        if ($this->isFormOpen) {
            if (!$this->bankToEditId) {
                $this->reset(['name', 'status']);
                $this->status = 'available';
            }
        } else {
            $this->reset(['bankToEditId', 'name', 'status']);
        }
    }

    public function toggleDeleteModal(int $id = null): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->bankToDeleteId = $id;
    }

    public function editBank(int $id): void
    {
        $bank = Bank::query()->findOrFail($id);

        $this->bankToEditId = $id;
        $this->name = $bank->name;
        $this->status = $bank->status;

        $this->isFormOpen = true;
    }

    public function saveBank(): void
    {
        $rules = [
            'name' => 'required|string|max:100|unique:banks,name' . ($this->bankToEditId ? ',' . $this->bankToEditId : ''),
            'status' => 'required|in:available,unavailable',
        ];

        $validated = $this->validate($rules);

        if ($this->bankToEditId) {
            Bank::query()->findOrFail($this->bankToEditId)->update($validated);
            $message = 'Bank details updated successfully!';
        } else {
            Bank::query()->create($validated);
            $message = 'New bank added successfully!';
        }

        $this->toggleForm();
        session()->flash('success', $message);
    }

    public function deleteBank(): void
    {
        if (!$this->bankToDeleteId) {
            return;
        }

        Bank::destroy($this->bankToDeleteId);

        $this->bankToDeleteId = null;
        $this->toggleDeleteModal();
        session()->flash('success', 'Bank removed successfully.');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function render(): View
    {
        FacadesView::share('pageTitle', 'Bank Management');

        $query = Bank::query();

        if ($this->searchQuery) {
            $query->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Stats
        $totalBanks = Bank::count();
        $availableBanks = Bank::where('status', 'available')->count();
        $unavailableBanks = $totalBanks - $availableBanks;

        return view('livewire.bank-management', [
            'banks' => $query->latest()->paginate(10),
            'totalBanks' => $totalBanks,
            'availableBanks' => $availableBanks,
            'unavailableBanks' => $unavailableBanks,
        ]);
    }
}
