<?php

namespace App\Services;

use App\Mail\PayslipReleasedMail;
use App\Models\Attendance;
use App\Models\Deduction;
use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PayrollService
{
    private float $fineLatePerMinute;
    private float $fineAbsent;
    private string $startWorkHour;

    private float $healthInsurancePremium;

    private float $tax;

    public function __construct()
    {
        $configs = Deduction::query()
            ->whereIn('slug', ['fine_late', 'fine_absence', 'health_insurance', 'tax'])
            ->pluck('value', 'slug');

        $this->fineLatePerMinute = $configs['fine_late'] ?? 5000;
        $this->fineAbsent    = $configs['fine_absence'] ?? 100000;

        $this->startWorkHour = '08:00:00';

        $this->healthInsurancePremium = $configs['health_insurance'] ?? 0;
        $this->tax = $configs['tax'] ?? 0;
    }

    public function generatePayrollForEmployee(Employee $employee, Carbon $period): void
    {
        $salary = $employee->salary;
        Log::info("[Payroll Service] Processing payroll for employee: $employee->id");

        if (!$salary) {
            Log::warning("[Payroll Service] Skipped Employee ID $employee->id: No Salary Record Found.");
            return;
        }

        $baseSalary = $salary->base_salary;
        $allowance = $salary->allowance;
        $cut = $this->healthInsurancePremium + $salary->cut;

        $startDate = $period->copy()->startOfMonth();
        $endDate = $period->copy()->endOfMonth();

        $joinDate = Carbon::parse($employee->created_at);

        // handling employee who join between paid period
        if ($joinDate->between($startDate, $endDate)) {
            $daysWorked = $joinDate->diffInDays($endDate) + 1;
            $totalDaysInMonth = $startDate->daysInMonth;

            $proRataFactor = $daysWorked / $totalDaysInMonth;

            $baseSalary = $baseSalary * $proRataFactor;
        }

        // late or absent fine
        $deductionData = $this->calculateDeductions($employee, $startDate, $endDate);

        try {
            DB::transaction(function () use ($employee, $baseSalary, $allowance, $cut, $deductionData, $period) {
                $existingPayroll = Payroll::query()->where('employee_id', $employee->id)
                    ->where('period_month', $period->format('m-Y'))
                    ->first();

                if ($existingPayroll) {
                    $payroll = $existingPayroll;
                } else {
                    $payroll = new Payroll();
                }

                $payroll->employee_id = $employee->id;
                $payroll->period_month = $period->format('Y-m');
                $payroll->payment_date = Carbon::now();

                $payroll->base_salary = $baseSalary;
                $payroll->allowance = $allowance;
                $payroll->cut = $cut;
                $payroll->working_days = $deductionData['workingDays'];
                $payroll->total_absence = $deductionData['totalAbsence'];
                $payroll->total_late = $deductionData['totalLate'];
                $payroll->absence_deduction = $deductionData['totalDeduction'];

                $payroll->save();

                if ($employee->name == 'Misyael Yosevian') {
                    Mail::to($employee->email)
                        ->queue(new PayslipReleasedMail($payroll));
                }

                return $payroll;
            });
        } catch (\Throwable $th) {
            Log::error('[Payroll Service] ' . $th->getMessage() . ' Line: ' . $th->getLine() . ' File: ' . $th->getFile());
        }
    }

    private function calculateDeductions(Employee $employee, Carbon $start, Carbon $end, ): array
    {
        // Counters
        $totalDeduction = 0;
        $totalWorkdays = 0;
        $totalAbsence = 0;
        $totalLate = 0;

        $attendanceRecords = Attendance::query()
            ->where('employee_id', $employee->id)
            ->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        $currentDate = $start->copy();
        $limitDate = $end->isFuture() ? Carbon::now()->endOfDay() : $end->endOfDay();

        while ($currentDate->lte($limitDate)) {
            $dateString = $currentDate->format('Y-m-d');

            // Handle Weekends
            if ($currentDate->isWeekend()) {
                $currentDate->addDay();
                continue;
            }

            $totalWorkdays++;

            /** @var Attendance|null $record */
            $record = $attendanceRecords->get($dateString);

            if ($record) {
                // Check based on Schema Status
                switch ($record->status) {
                    case 'attended':
                    case 'late':
                    case 'early exit':
                        // Check for Lateness
                        if ($record->check_in_at) {
                            $startWorkAt = Carbon::parse($dateString . ' ' . $this->startWorkHour);
                            $arrivalTime = Carbon::parse($dateString . ' ' . $record->check_in_at);

                            if ($arrivalTime->gt($startWorkAt)) {
                                $minutes = $arrivalTime->diffInMinutes($startWorkAt);
                                $totalLate += $minutes;
                            }
                        }
                        break;

                    case 'absent':
                        $totalAbsence++;
                        $totalDeduction += $this->fineAbsent;
                        break;

                    case 'leave':
                    case 'sick leave':
                    case 'annual leave':
                        break;
                }

            } else {
                $totalAbsence++;
                $totalDeduction += $this->fineAbsent;
            }

            $currentDate->addDay();
        }

        $deductionSum = $totalDeduction + ($totalLate * -1) * $this->fineLatePerMinute;

        return [
            'totalDeduction' => $deductionSum,
            'totalAbsence'   => $totalAbsence,
            'totalLate'      => $totalLate * -1,
            'workingDays'    => $totalWorkdays,
        ];
    }

    private function calculateOvertime(Employee $employee, Carbon $start, Carbon $end): float
    {
        return 0;
    }
}
