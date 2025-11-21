<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View as FacadesView;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class DashboardManagement extends Component
{
    public function render()
    {
        $admin = Auth::guard('admins')->user();
        $companyId = $admin->company->id;

       FacadesView::share('pageTitle', 'Dashboard');

        $employeeQuery = Employee::query()
            ->whereHas('department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        $departmentQuery = Department::query()
            ->where('company_id', $companyId);

        $departments = (clone $departmentQuery)->withCount('employees')->get();
        $deptLabels = $departments->pluck('name');
        $deptData = $departments->pluck('employees_count');

        $growthRaw = (clone $employeeQuery)
            ->select(
                DB::raw('count(id) as count'),
                DB::raw("TO_CHAR(created_at, 'YYYY-MM') as new_date")
            )
            ->where('created_at', '>=', \Carbon\Carbon::now()->subYear())
            ->groupBy('new_date')
            ->orderBy('new_date', 'ASC')
            ->get();

        $growthLabels = [];
        $growthData = [];

        foreach($growthRaw as $data) {
            $growthLabels[] = Carbon::createFromFormat('Y-m', $data->new_date)->format('M Y');
            $growthData[] = $data->count;
        }

        $approval = Leave::query()
            ->whereHas('employee', function ($q) use ($companyId) {
                $q->whereHas('department', function ($subQ) use ($companyId) {
                    $subQ->where('company_id', $companyId);
                });
            })
            ->where('status', 'pending')
            ->count();

        $attendanceCount = Attendance::query()
            ->whereHas('employee.department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->whereDate('date', today())
            ->count();

        $currentMonth = now()->format('Y-m');
        $monthlyPayrollCost = Payroll::query()
            ->whereHas('employee.department', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->where('period_month', '<', $currentMonth)
            ->sum(DB::raw('base_salary + allowance - cut - COALESCE(absence_deduction, 0)'));


        return view('livewire.dashboard-management', [
            'totalEmployee' => (clone $employeeQuery)->count(),
            'todayAttendance' => $attendanceCount,
            'monthlyPayrollCost' => $monthlyPayrollCost,
            'pendingLeaveCount' => $approval,
            'chartDeptLabels' => $deptLabels,
            'chartDeptData' => $deptData,
            'chartGrowthLabels' => $growthLabels,
            'chartGrowthData' => $growthData,
        ]);
    }
}
