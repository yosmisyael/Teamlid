<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollSchedule;
use App\Services\PayrollService;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class PayrollManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;
    public bool $isDeleteModalOpen = false;
    public bool $isSetupFormOpen = false;
    public bool $isRunModalOpen = false;

    // payroll data
    public int $pendingCount = 0;
    public array $pendingEmployeesList = [];

    // automation form properties
    public int $auto_is_active = 0;
    public int $auto_run_date = 25;
    public string $auto_run_time = '10:00';

    public ?int $payrollToDeleteId = null;
    public ?int $payrollToEditId = null;

    // Form Properties
    public ?int $employee_id = null;
    public string $period_month = '';
    public string $payment_date = '';
    public $base_salary = '';
    public $allowance = 0;
    public $cut = 0;

    // Filter Properties
    public string $searchQuery = '';
    public string $filterPeriod = '';

    public function runPayrollNow(): void
    {
        $service = app(PayrollService::class);
        $paidEmployeeIds = Payroll::query()->where('period_month', $this->filterPeriod)->pluck('employee_id');

        $targets = Employee::query()->where('status', 'active')
            ->whereNotIn('id', $paidEmployeeIds)
            ->get();

        if ($targets->isEmpty()) {
            $this->isRunModalOpen = false;
            session()->flash('error', 'All employees has been paid for the selected period.');
            return;
        }

        try {
            DB::beginTransaction();
            $count = 0;
            foreach ($targets as $employee) {
                $service->generatePayrollForEmployee(
                    $employee, Carbon::createFromFormat('Y-m', $this->filterPeriod)
                );
                $count++;
            }

            DB::commit();

            $this->isRunModalOpen = false;
            session()->flash('success', "Successfully process salary for {$count} employees.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[Payroll Service] ' . $e->getMessage());
            session()->flash('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function toggleSetupForm(): void
    {
        if (!$this->isSetupFormOpen) {
            $settings = PayrollSchedule::query()->firstOrNew();

            $this->auto_is_active = (int) $settings->is_active;
            $this->auto_run_date = $settings->run_date ?? 25;
            $this->auto_run_time = $settings->run_time ? Carbon::parse($settings->run_time)->format('H:i') : '10:00';

            $this->isSetupFormOpen = true;
        } else {
            $this->isSetupFormOpen = false;
        }
    }

    public function toggleRunModal(): void
    {
        if (!$this->isRunModalOpen) {
            $paidEmployeeIds = Payroll::query()->where('period_month', $this->filterPeriod)
                ->pluck('employee_id')
                ->toArray();

            $pendingEmployees = Employee::query()->where('status', 'active')
                ->whereNotIn('id', $paidEmployeeIds)
                ->get(['id', 'name', 'created_at']);

            $this->pendingCount = $pendingEmployees->count();
            // show preview
            $this->pendingEmployeesList = $pendingEmployees->take(5)->toArray();

            $this->isRunModalOpen = true;
        } else {
            $this->isRunModalOpen = false;
        }
    }

    public function saveAutomation(): void
    {
        $this->validate([
            'auto_run_date' => 'required|integer|min:1|max:28',
            'auto_run_time' => 'required',
        ]);

        $settings = PayrollSchedule::query()->firstOrNew();
        $settings->is_active = $this->auto_is_active;
        $settings->run_date = $this->auto_run_date;
        $settings->run_time = $this->auto_run_time;
        $settings->save();

        $this->isSetupFormOpen = false;
        session()->flash('success', 'Payroll schedule has been saved successfully');
    }

    public function mount(): void
    {
        $this->filterPeriod = Carbon::now()->format('Y-m');
    }

    public function updatedEmployeeId($value): void
    {
        if ($value && !$this->payrollToEditId) {
            $salaryDef = Salary::query()->where('employee_id', $value)->first();
            if ($salaryDef) {
                $this->base_salary = (float) $salaryDef->base_salary;
                $this->allowance = (float) $salaryDef->allowance;
                $this->cut = (float) $salaryDef->cut;
            } else {
                $this->base_salary = '';
                $this->allowance = 0;
                $this->cut = 0;
            }
        }
    }

    public function toggleForm(): void
    {
        $this->isFormOpen = !$this->isFormOpen;

        if ($this->isFormOpen) {
            if (!$this->payrollToEditId) {
                $this->reset(['employee_id', 'base_salary', 'allowance', 'cut']);
                $this->period_month = Carbon::now()->format('Y-m');
                $this->payment_date = Carbon::now()->format('Y-m-d');
            }
        } else {
            $this->reset(['payrollToEditId', 'employee_id', 'period_month', 'payment_date', 'base_salary', 'allowance', 'cut']);
        }
    }

    public function toggleDeleteModal(int $id = null): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->payrollToDeleteId = $id;
    }

    public function editPayroll(int $id): void
    {
        $payroll = Payroll::query()->findOrFail($id);

        $this->payrollToEditId = $id;
        $this->employee_id = $payroll->employee_id;
        $this->period_month = $payroll->period_month;
        $this->payment_date = $payroll->payment_date->format('Y-m-d');
        $this->base_salary = (float) $payroll->base_salary;
        $this->allowance = (float) $payroll->allowance;
        $this->cut = (float) $payroll->cut;

        $this->isFormOpen = true;
    }

    public function savePayroll(): void
    {
        $validated = $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'period_month' => 'required|date_format:Y-m',
            'payment_date' => 'required|date',
            'base_salary' => 'required|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',
            'cut' => 'nullable|numeric|min:0',
        ]);

        // Ensure defaults
        $validated['allowance'] = $validated['allowance'] ?? 0;
        $validated['cut'] = $validated['cut'] ?? 0;

        if ($this->payrollToEditId) {
            Payroll::query()->findOrFail($this->payrollToEditId)->update($validated);
            $message = 'Payroll record updated successfully!';
        } else {
            Payroll::query()->create($validated);
            $message = 'Payroll payment recorded successfully!';
        }

        $this->toggleForm();
        session()->flash('success', $message);
    }

    public function deletePayroll(): void
    {
        if (!$this->payrollToDeleteId) {
            return;
        }

        Payroll::destroy($this->payrollToDeleteId);

        $this->payrollToDeleteId = null;
        $this->toggleDeleteModal();
        session()->flash('success', 'Payroll record deleted.');
    }

    public function render(): View
    {
        FacadesView::share('pageTitle', 'Payroll Management');

        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;

        $baseQuery = Payroll::query()
            ->whereHas('employee.department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $statsQuery = (clone $baseQuery);

        if ($this->filterPeriod) {
            $statsQuery->where('period_month', $this->filterPeriod);
        }

        $totalDisbursed = (clone $statsQuery)
            ->sum(DB::raw('base_salary + allowance - cut - COALESCE(absence_deduction, 0)'));

        $countDisbursed = $statsQuery->count();

        $tableQuery = (clone $baseQuery)->with('employee');

        if ($this->filterPeriod) {
            $tableQuery->where('period_month', $this->filterPeriod);
        }

        if ($this->searchQuery) {
            $tableQuery->whereHas('employee', function ($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%');
            });
        }

        return view('livewire.payroll-management', [
            'payrolls' => $tableQuery->latest('payment_date')->paginate(10),

            'employees' => Employee::query()
                ->whereHas('department', function ($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                })
                ->orderBy('name')
                ->get(['id', 'name']),

            'totalDisbursed' => $totalDisbursed,
            'countDisbursed' => $countDisbursed,
        ]);
    }
}
