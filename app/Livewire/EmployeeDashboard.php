<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class EmployeeDashboard extends Component
{
    use WithPagination;
    // State
    public bool $isLeaveFormOpen = false;
    public bool $isPayslipListOpen = false;
    public bool $isDetailLeaveOpen = false;
    public $selectedLeave;
    public string $currentTime = '';

    public bool $isMenuOpened = false;

    // Leave Form
    public string $leave_type = 'annual leave';
    public string $start_date = '';
    public string $end_date = '';
    public string $reason = '';

    public Employee $employee;

    public $companyParam = '';

    public function mount($company): void
    {
        if (is_object($company)) {
            $this->companyParam = $company->getRouteKey();
        } else {
            $this->companyParam = $company;
        }

        $this->employee = auth()->guard('employees')->user();
        $this->currentTime = Carbon::now()->format('H:i');
    }

    public function toggleLeaveForm(): void
    {
        $this->isLeaveFormOpen = !$this->isLeaveFormOpen;
        if (!$this->isLeaveFormOpen) {
            $this->reset(['leave_type', 'start_date', 'end_date', 'reason']);
        }
    }

    public function togglePayslipList(): void
    {
        $this->isPayslipListOpen = !$this->isPayslipListOpen;
    }

    public function toggleMenu(): void
    {
        $this->isMenuOpened = !$this->isMenuOpened;
    }

    public function showLeaveDetail($leaveId)
    {
        $this->selectedLeave = Leave::find($leaveId);
        if ($this->selectedLeave) {
            $this->isDetailLeaveOpen = true;
        }
    }

    public function recordAttendance(): void
    {
        $employeeId = $this->employee->id;

        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');

        $attendance = Attendance::query()->where('employee_id', $employeeId)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            Attendance::query()->create([
                'employee_id' => $employeeId,
                'date' => $today,
                'check_in_at' => $now,
                'status' => $now > '09:00' ? 'late' : 'attended',
            ]);
            session()->flash('success', 'Checked in successfully at ' . $now);
        } elseif (!$attendance->check_out_at) {
            // Check Out
            $attendance->update([
                'check_out_at' => $now,
                'status' => $attendance->status === 'late' ? 'late' : ($now < '17:00' ? 'early exit' : 'attended'),
            ]);
            session()->flash('success', 'Checked out successfully at ' . $now);
        } else {
            session()->flash('error', 'You have already completed attendance for today.');
        }
    }

    public function submitLeave(): void
    {
        $employeeId = $this->employee->id;

        $this->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        Leave::query()->create([
            'employee_id' => $employeeId,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'reason' => "[$this->leave_type] " . $this->reason,
            'status' => 'pending',
        ]);

        $this->toggleLeaveForm();
        session()->flash('success', 'Leave request submitted for approval.');
    }

    public function render(): View
    {
        FacadesView::share('pageTitle', 'My Dashboard');

        $employeeId = $this->employee->id;

        $todayRecord = Attendance::query()->where('employee_id', $employeeId)
            ->where('date', Carbon::today())
            ->first();

        $attendanceState = 'none';
        if ($todayRecord) {
            $attendanceState = $todayRecord->check_out_at ? 'completed' : 'checked_in';
        }

        $recentActivity = Attendance::query()->where('employee_id', $employeeId)
            ->whereNotNull('check_in_at')
            ->whereNotNull('check_out_at')
            ->latest('date')
            ->paginate(5)
            ->through(function ($item) {
                $item->type = 'attendance';
                return $item;
            });
        $leaveRequest = Leave::query()->where('employee_id', $employeeId)->paginate(5);

        $payslips = Payroll::query()->where('employee_id', $employeeId)
            ->paginate(5);

        return view('livewire.employee-dashboard', [
            'attendanceState' => $attendanceState,
            'checkInTime' => $todayRecord->check_in_at ?? null,
            'checkOutTime' => $todayRecord->check_out_at ?? null,
            'recentActivity' => $recentActivity,
            'leaveRequest' => $leaveRequest,
            'payslips' => $payslips,
        ]);
    }
}
