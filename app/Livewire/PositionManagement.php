<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Job;
use App\Models\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class PositionManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;
    public bool $isDeleteModalOpen = false;
    public ?int $positionToDeleteId = null;
    public ?int $positionToEditId = null;

    // Form Properties
    public string $name = '';
    public string $status = 'available';
    public $required_talents = '';
    public ?int $department_id = null;
    public ?int $job_id = null;

    public $availableJobs = [];

    public function mount()
    {
        $this->availableJobs = collect();
    }

    public function updatedDepartmentId($value): void
    {
        if ($value) {
            $this->availableJobs = Job::query()->where('department_id', $value)->get();
        } else {
            $this->availableJobs = collect();
        }
        $this->job_id = null;
    }

    public function toggleForm(): void
    {
        $this->isFormOpen = !$this->isFormOpen;

        if ($this->isFormOpen) {
            $this->reset(['name', 'department_id', 'job_id', 'required_talents', 'status', 'availableJobs']);
        }

        if ($this->positionToEditId) {
            $this->positionToEditId = null;
        }
    }

    public function toggleDeleteModal(int $id = null): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->positionToDeleteId = $id;
    }

    public function toggleStatus(int $id): void
    {
        $position = Position::query()->withCount('employees')->findOrFail($id);

        $newStatus = $position->status === 'available' ? 'unavailable' : 'available';

        $position->update(['status' => $newStatus]);
    }

    public function savePosition(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:100',
            'department_id' => 'required|exists:departments,id',
            'job_id' => 'required|exists:job_profiles,id',
            'required_talents' => 'nullable|integer|min:1',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($validated['required_talents'] === '' || $validated['required_talents'] === 0) {
            $validated['required_talents'] = null;
        }

        if ($this->positionToEditId) {
            Position::query()->findOrFail($this->positionToEditId)->update($validated);
            $message = 'Position details successfully updated!';
        } else {
            Position::query()->create($validated);
            $message = 'New position successfully created!';
        }

        $this->toggleForm();
        session()->flash('success', $message);
    }

    public function editPosition(int $id): void
    {
        $position = Position::query()->findOrFail($id);

        $this->positionToEditId = $id;
        $this->name = $position->name;
        $this->department_id = $position->department_id;
        $this->status = $position->status;
        $this->required_talents = $position->required_talents;

        $this->availableJobs = Job::query()->where('department_id', $position->department_id)->get();
        $this->job_id = $position->job_id;

        $this->isFormOpen = true;
    }

    public function deletePosition(): void
    {
        if (!$this->positionToDeleteId) {
            return;
        }

        Position::destroy($this->positionToDeleteId);

        $this->positionToDeleteId = null;
        $this->toggleDeleteModal();
    }

    public function render(): View
    {
        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;

        FacadesView::share('pageTitle', 'Position Management');

        $positionQuery = Position::query()
            ->whereHas('department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $totalPositions = (clone $positionQuery)->count();

        $positionsWithVacancies = (clone $positionQuery)
            ->where('status', 'available')
            ->withCount('employees')
            ->get()
            ->filter(function ($pos) {
                return is_null($pos->required_talents) || $pos->employees_count < $pos->required_talents;
            })
            ->count();

        return view('livewire.position-management', [
            'positions' => $positionQuery
                ->with(['department', 'job'])
                ->withCount('employees')
                ->latest()
                ->paginate(6),

            'departments' => Department::query()
                ->where('company_id', $companyId)
                ->orderBy('name')
                ->get(),

            'totalPositions' => $totalPositions,
            'openPositions' => $positionsWithVacancies
        ]);
    }
}
