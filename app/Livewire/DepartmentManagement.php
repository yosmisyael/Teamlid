<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class DepartmentManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;

    public bool $isDeleteModalOpen = false;

    public ?int $departmentToDeleteId = null;

    public ?int $departmentToEditId = null;

    #[Rule('required|string:max:255|unique:departments,name')]
    public string $name = '';

    #[Rule('nullable|exists:employees,id')]
    public ?string $manager_id = null;

    public function toggleForm(): void {
        $this->isFormOpen = !$this->isFormOpen;

        if ($this->isFormOpen) {
            $this->reset(['name', 'manager_id']);
        }

        if ($this->departmentToEditId) {
            $this->departmentToEditId = null;
        }
    }

    public function toggleDeleteModal(int $id = null): void {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->departmentToDeleteId = $id;
    }

    public function saveDepartment(): void {
        $ruleName = 'required|string|max:255|unique:departments,name';

        if ($this->departmentToEditId) {
            $ruleName .= ',' . $this->departmentToEditId;
        }

        $validated = $this->validate([
            'name' => $ruleName,
            'manager_id' => 'nullable|exists:employees,id',
        ]);

        if (!isset($validated['manager_id']) || $validated['manager_id'] === '') {
            $validated['manager_id'] = null;
        }

        if ($this->departmentToEditId) {
            Department::query()->findOrFail($this->departmentToEditId)->update($validated);
            $message = 'Department successfully updated!';
        } else {
            Department::query()->create($validated);
            $message = 'Department successfully created!';
        }

        $this->toggleForm();

        session()->flash('success', $message);
    }

    public function editDepartment(int $id): void {
        $department = Department::query()->with('manager')->findOrFail($id);

        $this->departmentToEditId = $id;
        $this->name = $department->name;
        $this->manager_id = $department->manager_id ? $department->manager_id : 'null';
        $this->isFormOpen = true;
    }

    public function deleteDepartment(): void {
        if (!$this->departmentToDeleteId) {
            return;
        }

        Department::destroy($this->departmentToDeleteId);

        $this->departmentToDeleteId = null;
        $this->toggleDeleteModal();
    }

    public function render(): View
    {
        FacadesView::share('pageTitle', 'Department Management');
        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;

        $departmentQuery = Department::query()
            ->where('company_id', $companyId);

        $employeeQuery = Employee::query()
            ->whereHas('department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $totalDepartments = (clone $departmentQuery)->count();
        $totalEmployees = (clone $employeeQuery)->count();

        $avgEmployeesPerDepartment = $totalDepartments > 0
            ? round($totalEmployees / $totalDepartments, 1)
            : 0;

        return view('livewire.department-management', [
            'departments' => $departmentQuery
                ->with(['manager', 'employees'])
                ->withCount('employees')
                ->latest()
                ->paginate(5),

            'totalDepartments' => $totalDepartments,
            'totalEmployees' => $totalEmployees,
            'averageEmployeesPerDepartment' => $avgEmployeesPerDepartment,

            'managerCandidate' => $employeeQuery
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }
}
