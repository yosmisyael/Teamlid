<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class JobManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;

    public bool $isDeleteModalOpen = false;

    public ?int $jobToDeleteId = null;

    public ?int $jobToEditId = null;

    // Form Properties
    public string $name = '';

    public ?int $department_id = null;

    public $min_salary = '';

    public $max_salary = '';

    public function toggleForm(): void
    {
        $this->isFormOpen = !$this->isFormOpen;

        if ($this->isFormOpen) {
            $this->reset(['name', 'department_id', 'min_salary', 'max_salary']);
        }

        if ($this->jobToEditId) {
            $this->jobToEditId = null;
        }
    }

    public function toggleDeleteModal(int $id = null): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->jobToDeleteId = $id;
    }

    public function saveJob(): void
    {
        // Dynamic validation for unique name ignoring current ID on edit
        $uniqueRule = 'required|string|max:100|unique:job_profiles,name';

        if ($this->jobToEditId) {
            $uniqueRule .= ',' . $this->jobToEditId;
        }

        $validated = $this->validate([
            'name' => $uniqueRule,
            'department_id' => 'required|exists:departments,id',
            'min_salary' => 'required|integer|min:0',
            'max_salary' => 'required|integer|gte:min_salary',
        ]);

        if ($this->jobToEditId) {
            Job::query()->findOrFail($this->jobToEditId)->update($validated);
            $message = 'Job profile successfully updated!';
        } else {
            Job::query()->create($validated);
            $message = 'Job profile successfully created!';
        }

        $this->toggleForm();

        session()->flash('success', $message);
    }

    public function editJob(int $id): void
    {
        $job = Job::query()->findOrFail($id);

        $this->jobToEditId = $id;
        $this->name = $job->name;
        $this->department_id = $job->department_id;
        $this->min_salary = $job->min_salary;
        $this->max_salary = $job->max_salary;

        $this->isFormOpen = true;
    }

    public function deleteJob(): void
    {
        if (!$this->jobToDeleteId) {
            return;
        }

        Job::destroy($this->jobToDeleteId);

        $this->jobToDeleteId = null;
        $this->toggleDeleteModal();
    }

    public function render(): View
    {
        $admin =Auth::guard('admins')->user();
        $companyId = $admin->company->id;

        FacadesView::share('pageTitle', 'Job Profiles Management');

        $jobQuery = Job::query()
            ->whereHas('department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $totalJobs = (clone $jobQuery)->count();

        $avgMinSalary = $totalJobs > 0
            ? (clone $jobQuery)->avg('min_salary')
            : 0;

        $avgMaxSalary = $totalJobs > 0
            ? (clone $jobQuery)->avg('max_salary')
            : 0;

        return view('livewire.job-management', [
            'jobs' => $jobQuery
                ->with('department')
                ->latest()
                ->paginate(5),

            'departments' => Department::query()
                ->where('company_id', $companyId)
                ->orderBy('name')
                ->get(),

            'totalJobs' => $totalJobs,
            'avgMinSalary' => round($avgMinSalary),
            'avgMaxSalary' => round($avgMaxSalary),
        ]);
    }
}
