<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
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
    public string $manager_id = '';

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

        if (isset($validated['manager_id']) && $validated['manager_id'] == '') {
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
        if ($department->manager_id) {
            $this->manager_id = $department->manager_id;
        }
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
        $totalDepartments = Department::query()->count();
        $totalEmployees = Employee::query()->count();
        $avgEmployeesPerDepartment = $totalDepartments > 0
            ? round($totalEmployees / $totalDepartments, 1)
            : 0;

        return view('livewire.department-management', [
            'departments' => Department::query()->with(['manager', 'employees'])->latest()->paginate(5),
            'totalDepartments' => Department::query()->count(),
            'totalEmployees' => Employee::query()->count(),
            'managerCandidate' => Employee::query()->whereDoesntHave('managedDepartment')->get(),
            'averageEmployeesPerDepartment' => $avgEmployeesPerDepartment,
        ]);
    }
}
