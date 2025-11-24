<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use App\Models\Position;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class EmployeeManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;
    public bool $isDeleteModalOpen = false;
    public ?int $employeeToDeleteId = null;
    public ?int $employeeToEditId = null;

    // Form Properties
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $birth_date = '';
    public string $address = '';
    public string $status = 'active';
    public string $password = '';

    // Relationship Properties
    public ?int $department_id = null;
    public ?int $job_id = null;
    public ?int $position_id = null;

    // Dependent Collections
    public Collection $availableJobs;
    public Collection $availablePositions;

    public function mount()
    {
        $this->availableJobs = collect();
        $this->availablePositions = collect();
    }

    public function updatedDepartmentId($value): void
    {
        // When Dept changes, fetch Jobs, reset Job/Position
        if ($value) {
            $this->availableJobs = Job::query()->where('department_id', $value)->get();
        } else {
            $this->availableJobs = collect();
        }

        $this->job_id = null;
        $this->position_id = null;
        $this->availablePositions = collect();
    }

    public function updatedJobId($value): void
    {
        // When Job changes, fetch Positions
        if ($value) {
            $this->availablePositions = Position::query()
                ->where('job_id', $value)
                ->where('department_id', $this->department_id)
                ->get();
        } else {
            $this->availablePositions = collect();
        }

        $this->position_id = null;
    }

    public function toggleForm(): void
    {
        $this->isFormOpen = !$this->isFormOpen;

        if ($this->isFormOpen) {
            $this->reset([
                'name', 'email', 'phone', 'birth_date', 'address',
                'status', 'department_id', 'job_id', 'position_id',
                'availableJobs', 'availablePositions'
            ]);
            $this->availableJobs = collect();
            $this->availablePositions = collect();
        }

        if ($this->employeeToEditId) {
            $this->employeeToEditId = null;
        }
    }

    public function toggleDeleteModal(int $id = null): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->employeeToDeleteId = $id;
    }

    public function saveEmployee(): void
    {
        $emailRule = 'required|email|max:100|unique:employees,email';
        $passwordRule = $this->employeeToEditId ? 'nullable|string|min:8' : 'required|string|min:8';

        if ($this->employeeToEditId) {
            $emailRule .= ',' . $this->employeeToEditId;
        }

        $validated = $this->validate([
            'name' => 'required|string|max:100',
            'email' => $emailRule,
            'phone' => 'required|string|max:15',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:500',
            'status' => 'required|in:active,inactive',
            'department_id' => 'required|exists:departments,id',
            'job_id' => 'required|exists:job_profiles,id',
            'position_id' => 'nullable|exists:positions,id',
            'password' => $passwordRule,
        ]);

        if ($this->position_id) {
            $selectedPosition = Position::find($this->position_id);

            if ($selectedPosition) {
                if ((int)$selectedPosition->department_id !== (int)$this->department_id) {
                    $this->addError('position_id', 'The selected position does not belong to this department.');
                    return;
                }

                if ((int)$selectedPosition->job_id !== (int)$this->job_id) {
                    $this->addError('position_id', 'The selected position does not align with the chosen job profile.');
                    return;
                }
            }
        }

        if (empty($validated['position_id'])) {
            $validated['position_id'] = null;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($this->employeeToEditId) {
            Employee::query()->findOrFail($this->employeeToEditId)->update($validated);
            $message = 'Employee updated successfully!';
        } else {
            Employee::query()->create($validated);
            $message = 'New employee onboarded successfully!';
        }

        $this->toggleForm();
        session()->flash('success', $message);
    }

    public function editEmployee(int $id): void
    {
        $employee = Employee::query()->findOrFail($id);

        $this->employeeToEditId = $id;
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->birth_date = $employee->birth_date;
        $this->address = $employee->address;
        $this->status = $employee->status;
        $this->department_id = $employee->department_id;

        // Trigger updates for dropdowns
        $this->updatedDepartmentId($employee->department_id);
        $this->job_id = $employee->job_id;

        $this->updatedJobId($employee->job_id);
        $this->position_id = $employee->position_id;

        $this->isFormOpen = true;
    }

    public function deleteEmployee(): void
    {
        if (!$this->employeeToDeleteId) {
            return;
        }

        Employee::query()->find($this->employeeToDeleteId)->delete(); // Soft delete

        $this->employeeToDeleteId = null;
        $this->toggleDeleteModal();
        session()->flash('success', 'Employee record moved to archives.');
    }

    public function render(): View
    {
        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;
        $employeeQuery = Employee::query()
            ->whereHas('department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        FacadesView::share('pageTitle', 'Employee Directory');

        $totalEmployees = (clone $employeeQuery)->count();
        $activeEmployees = (clone $employeeQuery)->where('status', 'active')->count();
        $inactiveEmployees = $totalEmployees - $activeEmployees;

        $employees = $employeeQuery
            ->with(['department', 'job', 'position'])
            ->latest()
            ->paginate(10);

        $departments = Department::query()
            ->where('company_id', $companyId)
            ->orderBy('name')
            ->get();

        return view('livewire.employee-management', [
            'employees' => $employees,
            'departments' => $departments,
            'totalEmployees' => $totalEmployees,
            'activeEmployees' => $activeEmployees,
            'inactiveEmployees' => $inactiveEmployees,
        ]);
    }
}
