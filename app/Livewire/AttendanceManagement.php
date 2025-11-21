<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class AttendanceManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;
    public ?int $attendanceToEditId = null;

    // Form Properties
    public ?int $employee_id = null;
    public string $employee_name_display = '';
    public string $date = '';
    public ?string $check_in_at = null;
    public ?string $check_out_at = null;
    public string $status = '';

    // Filter Properties
    public string $filterDate = '';
    public string $searchQuery = '';
    public string $filterStatus = '';

    // Constants for logic
    const STATUSES_WITH_TIME = ['attended', 'late', 'early exit'];

    public function mount(): void
    {
        $this->filterDate = Carbon::today()->format('Y-m-d');
    }

    public function toggleForm(): void
    {
        $this->isFormOpen = !$this->isFormOpen;

        if ($this->isFormOpen) {
            if (!$this->attendanceToEditId) {
                $this->date = Carbon::today()->format('Y-m-d');
                $this->status = 'attended';
            }
        } else {
            $this->reset(['attendanceToEditId', 'employee_id', 'employee_name_display', 'date', 'check_in_at', 'check_out_at', 'status']);
        }
    }

    public function editAttendance(int $id): void
    {
        $attendance = Attendance::with('employee')->findOrFail($id);

        $this->attendanceToEditId = $id;
        $this->employee_id = $attendance->employee_id;
        $this->employee_name_display = $attendance->employee->name;
        $this->date = $attendance->date->format('Y-m-d');

        $this->check_in_at = $attendance->check_in_at ? Carbon::parse($attendance->check_in_at)->format('H:i') : null;
        $this->check_out_at = $attendance->check_out_at ? Carbon::parse($attendance->check_out_at)->format('H:i') : null;

        $this->status = $attendance->status;

        $this->isFormOpen = true;
    }

    public function updatedStatus($value): void
    {
        if (!in_array($value, self::STATUSES_WITH_TIME)) {
            $this->check_in_at = null;
            $this->check_out_at = null;
        }
    }

    public function saveAttendance(): void
    {
        $rules = [
            'date' => 'required|date',
            'status' => 'required|in:attended,leave,sick leave,annual leave,absent,late,early exit',
        ];

        // Only validate times if status supports them
        if (in_array($this->status, self::STATUSES_WITH_TIME)) {
            $rules['check_in_at'] = 'nullable|date_format:H:i';
            $rules['check_out_at'] = 'nullable|date_format:H:i|after:check_in_at';
        } else {
            $rules['check_in_at'] = 'nullable';
            $rules['check_out_at'] = 'nullable';
        }

        if (!$this->attendanceToEditId) {
            $rules['employee_id'] = 'required|exists:employees,id';
        }

        $validated = $this->validate($rules);

        if (!in_array($this->status, self::STATUSES_WITH_TIME)) {
            $validated['check_in_at'] = null;
            $validated['check_out_at'] = null;
        }

        if ($this->attendanceToEditId) {
            Attendance::query()->findOrFail($this->attendanceToEditId)->update($validated);
            $message = 'Attendance record corrected successfully.';
        } else {
            Attendance::create($validated);
            $message = 'New attendance record created.';
        }

        $this->toggleForm();
        session()->flash('success', $message);
    }

    public function updatedFilterDate(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;

        FacadesView::share('pageTitle', 'Attendance Monitoring');

        $baseQuery = Attendance::query()
            ->whereHas('employee.department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $query = (clone $baseQuery)->with('employee');

        if ($this->filterDate) {
            $query->whereDate('date', $this->filterDate);
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->searchQuery) {
            $query->whereHas('employee', function ($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('email', 'like', '%' . $this->searchQuery . '%');
            });
        }

        $dailyStats = (clone $baseQuery)
            ->whereDate('date', $this->filterDate ?: Carbon::today())
            ->selectRaw("
            count(*) as total,
            sum(case when status = 'attended' then 1 else 0 end) as present,
            sum(case when status = 'late' then 1 else 0 end) as late,
            sum(case when status = 'absent' then 1 else 0 end) as absent
        ")->first();

        return view('livewire.attendance-management', [
            'attendances' => $query->latest('date')->paginate(10),

            'employees' => Employee::query()
                ->whereHas('department', function ($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                })
                ->orderBy('name')
                ->get(['id', 'name']),

            'dailyStats' => $dailyStats,
        ]);
    }
}
