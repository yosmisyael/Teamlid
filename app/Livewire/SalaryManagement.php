<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Deduction;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class SalaryManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isSalaryFormOpen = false;
    public bool $isTaxFormOpen = false;
    public bool $isHealthInsurance = false;
    public bool $isFineFormOpen = false;
    public bool $isDeleteModalOpen = false;
    public ?int $salaryToDeleteId = null;
    public ?int $salaryToEditId = null;

    // Form Properties
    #[Rule('required|numeric|min:0|max:9999999999.99|decimal:0,2')]
    public $tax;
    #[Rule('required|numeric|min:0|max:9999999999.99|decimal:0,2')]
    public $late;
    #[Rule('required|numeric|min:0|max:9999999999.99|decimal:0,2')]
    public $absence;
    #[Rule('required|numeric|min:0|max:9999999999.99|decimal:0,2')]
    public $healthInsurance;

    public ?int $employee_id = null;
    public ?int $bank_id = null;
    public string $bank_account = '';
    public $base_salary = '';
    public $allowance = 0;
    public $cut = 0;

    // Filter Properties
    public string $searchQuery = '';

    public function toggleSalaryForm(): void
    {
        $this->isSalaryFormOpen = !$this->isSalaryFormOpen;

        if (!$this->isSalaryFormOpen) {
            $this->reset(['salaryToEditId', 'employee_id', 'bank_id', 'bank_account', 'base_salary', 'allowance', 'cut']);
        }
    }

    public function toggleTaxForm(): void
    {
        $this->isTaxFormOpen = !$this->isTaxFormOpen;

        if ($this->isTaxFormOpen) {
            $taxRecord = Deduction::query()->where('slug', '=', 'tax')->first();
            if ($taxRecord) {
                $this->tax = $taxRecord->value;
            }
        } else {
            $this->reset('tax');
        }
    }

    public function toggleHealthInsurance(): void
    {
        $this->isHealthInsurance = !$this->isHealthInsurance;

        if ($this->isHealthInsurance) {
            $record = Deduction::query()->where('slug', '=', 'health_insurance')->first();
            if ($record) {
                $this->healthInsurance = $record->value;
            }
        } else {
            $this->reset('healthInsurance');
        }
    }

    public function toggleFineForm(): void
    {
        $this->isFineFormOpen = !$this->isFineFormOpen;

        if ($this->isFineFormOpen) {
            $lateFineRecord = Deduction::query()
                ->where('slug', '=', 'fine_late')
                ->first();
            $absenceFineRecord = Deduction::query()
                ->where('slug', '=', 'fine_absence')
                ->first();

            if ($lateFineRecord) {
                $this->late = $lateFineRecord->value;
            }

            if ($absenceFineRecord) {
                $this->absence = $absenceFineRecord->value;
            }
        }
    }

    public function toggleDeleteModal(int $id = null): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->salaryToDeleteId = $id;
    }

    public function editSalary(int $id): void
    {
        $salary = Salary::query()->findOrFail($id);

        $this->salaryToEditId = $id;
        $this->employee_id = $salary->employee_id;
        $this->bank_id = $salary->bank_id;
        $this->bank_account = $salary->bank_account;
        $this->base_salary = (float) $salary->base_salary;
        $this->allowance = (float) $salary->allowance;
        $this->cut = (float) $salary->cut;

        $this->isSalaryFormOpen = true;
    }

    public function saveTax(): void
    {
        Deduction::query()->updateOrCreate([ 'name' => 'Tax' ], [
            'value' => (float) $this->tax,
            'type' => 'percentage',
            'is_global' => true,
        ]);

        $this->toggleTaxForm();
    }

    public function saveFine(): void
    {
        try {
            DB::beginTransaction();
            Deduction::query()->updateOrCreate([ 'slug' => 'fine_late'], [
                'name' => 'Fine Late',
                'value' => (float) $this->late,
                'type' => 'fixed',
                'is_global' => true,
            ]);

            Deduction::query()->updateOrCreate([ 'slug' => 'fine_absence' ], [
                'name' => 'Fine Absence',
                'value' => (float) $this->absence,
                'type' => 'fixed',
                'is_global' => true,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        $this->toggleFineForm();
    }

    public function saveHealthInsurance(): void
    {
        Deduction::query()->updateOrCreate([ 'slug' => 'health_insurance' ], [
            'name' => 'Health Insurance',
            'value' => (float) $this->healthInsurance,
            'type' => 'fixed',
            'is_global' => true,
        ]);

        $this->toggleHealthInsurance();
    }


    public function saveSalary(): void
    {
        $employeeRule = 'required|exists:employees,id|unique:salaries,employee_id';
        if ($this->salaryToEditId) {
            $employeeRule .= ',' . $this->salaryToEditId;
        }

        $validated = $this->validate([
            'employee_id' => $employeeRule,
            'bank_id' => 'required|exists:banks,id',
            'bank_account' => 'required|string|max:50',
            'base_salary' => 'required|numeric|min:0|max:99999999.99',
            'allowance' => 'nullable|numeric|min:0|max:99999999.99',
            'cut' => 'nullable|numeric|min:0|max:99999999.99',
        ]);

        // Ensure defaults
        $validated['allowance'] = $validated['allowance'] ?? 0;
        $validated['cut'] = $validated['cut'] ?? 0;

        $this->allowance = $this->allowance ?? 0;
        $this->cut = $this->cut ?? 0;

        if ($this->salaryToEditId) {
            Salary::query()->findOrFail($this->salaryToEditId)->update($validated);
            $message = 'Salary details updated successfully!';
        } else {
            Salary::query()->create($validated);
            $message = 'Payroll data defined successfully!';
        }

        $this->toggleSalaryForm();
        session()->flash('success', $message);
    }

    public function deleteSalary(): void
    {
        if (!$this->salaryToDeleteId) {
            return;
        }

        Salary::destroy($this->salaryToDeleteId);

        $this->salaryToDeleteId = null;
        $this->toggleDeleteModal();
        session()->flash('success', 'Salary record removed.');
    }

    public function render(): View
    {
        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;

        FacadesView::share('pageTitle', 'Salary Management');

        $baseSalaryQuery = Salary::query()
            ->whereHas('employee.department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $totalRecords = (clone $baseSalaryQuery)->count();

        $totalPayroll = (clone $baseSalaryQuery)
            ->sum(DB::raw('base_salary + allowance'));

        $avgSalary = $totalRecords > 0
            ? (clone $baseSalaryQuery)->avg('base_salary')
            : 0;

        $tableQuery = (clone $baseSalaryQuery)->with(['employee', 'bank']);

        if ($this->searchQuery) {
            $tableQuery->where(function ($q) {
                $q->whereHas('employee', function ($subQ) {
                    $subQ->where('name', 'like', '%' . $this->searchQuery . '%');
                })
                    ->orWhere('bank_account', 'like', '%' . $this->searchQuery . '%');
            });
        }

        return view('livewire.salary-management', [
            'salaries' => $tableQuery->latest()->paginate(10),

            'employees' =>Employee::query()
                ->whereHas('department', function ($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                })
                ->whereDoesntHave('salary')
                ->orderBy('name')
                ->get(['id', 'name']),

            'banks' => Bank::query()
                ->where('status', 'available')
                ->orderBy('name')
                ->get(['id', 'name']),

            'totalPayroll' => $totalPayroll,
            'avgSalary' => $avgSalary,
            'totalRecords' => $totalRecords,
        ]);
    }
}
