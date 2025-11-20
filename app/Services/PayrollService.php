<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayrollService
{
    public function generatePayrollForEmployee(Employee $employee): void
    {
        $salary = $employee->salary();
        $baseSalary = $salary->base_salary;
        $allowance = $salary->allowance;
        $cut = $salary->cut;

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // late fine
        $deductions = $this->calculateDeductions($employee, $startDate, $endDate);
        $netSalary = $baseSalary + $allowance - $cut - $deductions;

        try {
            DB::transaction(function () use ($employee, $baseSalary, $allowance, $cut, $deductions, $netSalary) {
                $existingPayroll = Payroll::where('employee_id', $employee->id)
                    ->where('month', Carbon::now()->format('m-Y'))
                    ->first();

                if ($existingPayroll) {
                    $payroll = $existingPayroll;
                } else {
                    $payroll = new Payroll();
                }

                $payroll->employee_id = $employee->id;
                $payroll->month = Carbon::now()->format('m-Y');
                $payroll->payment_date = Carbon::now();

                $payroll->base_salary = $baseSalary;
                $payroll->allowance = $allowance;
                $payroll->cut = $cut + $deductions;
                $payroll->total_salary = $netSalary;

                $payroll->save();

                return $payroll;
            });
        } catch (\Throwable $th) {
            Log::error('[Payroll Service] ' . $th->getMessage() . ' Line: ' . $th->getLine() . ' File: ' . $th->getFile());
        }
    }

    private function calculateDeductions(Employee $employee, Carbon $start, Carbon $end): float
    {
        $totalDeduction = 0;
        $finePerMinute = 5000;
        $fineAbsent = 100000;

        $attendanceDates = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->pluck('time_in', 'date')
            ->toArray();

        $currentDate = $start->copy();

        while ($currentDate <= $end) {
            $dateString = $currentDate->format('Y-m-d');

            if ($currentDate->isWeekend()) {
                $currentDate->addDay();
                continue;
            }

            if (array_key_exists($dateString, $attendanceDates)) {
                $startWorkAt = Carbon::parse($dateString . ' 08:00:00');
                $arrivalTime = Carbon::parse($dateString . ' ' . $attendanceDates[$dateString]);

                if ($arrivalTime->gt($startWorkAt)) {
                    $menitTelat = $arrivalTime->diffInMinutes($startWorkAt);
                    $totalDeduction += ($menitTelat * $finePerMinute);
                }
            } else {
                $totalDeduction += $fineAbsent;
            }

            $currentDate->addDay();
        }

        return $totalDeduction;
    }

    private function calculateOvertime(Employee $employee, Carbon $start, Carbon $end): float
    {
        return 0;
    }
}
