<?php

namespace App\Livewire;

use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class LeaveManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isReviewFormOpen = false;
    public ?int $leaveToReviewId = null;

    public $reviewData = [];

    // Filter Properties
    public string $filterStatus = '';

    public function toggleReviewForm(): void
    {
        $this->isReviewFormOpen = !$this->isReviewFormOpen;

        if (!$this->isReviewFormOpen) {
            $this->reset(['leaveToReviewId', 'reviewData']);
        }
    }

    public function openReview(int $id): void
    {
        $leave = Leave::with(['employee.department', 'employee.job', 'employee.position'])->findOrFail($id);

        $this->leaveToReviewId = $id;

        // Populate Read-only Data
        $this->reviewData = [
            'employee_name' => $leave->employee->name,
            'employee_id' => $leave->employee->id,
            'department' => $leave->employee->department->name ?? 'N/A',
            'job' => $leave->employee->job->name ?? 'N/A',
            'position' => $leave->employee->position->name ?? 'N/A',
            'start_date' => $leave->start_date->format('M d, Y'),
            'end_date' => $leave->end_date->format('M d, Y'),
            'duration' => $leave->duration . ' Days',
            'reason' => $leave->reason,
            'status' => $leave->status,
            'applied_at' => $leave->created_at->format('M d, Y H:i'),
        ];

        $this->isReviewFormOpen = true;
    }

    public function updateStatus(string $status): void
    {
        if (!in_array($status, ['approved', 'rejected'])) {
            return;
        }

        Leave::query()->where('id', $this->leaveToReviewId)->update(['status' => $status]);

        $this->toggleReviewForm();

        $action = $status === 'approved' ? 'approved' : 'rejected';
        session()->flash('success', "Leave request has been {$action}.");
    }

    public function render(): View
    {
        FacadesView::share('pageTitle', 'Leave Requests');

        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;


        $baseQuery = Leave::query()
            ->whereHas('employee.department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $query = (clone $baseQuery)->with('employee');

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $pendingCount = (clone $baseQuery)->where('status', 'pending')->count();
        $approvedCount = (clone $baseQuery)->where('status', 'approved')->count();
        $rejectedCount = (clone $baseQuery)->where('status', 'rejected')->count();

        return view('livewire.leave-management', [
            'leaves' => $query->latest()->paginate(10),
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
