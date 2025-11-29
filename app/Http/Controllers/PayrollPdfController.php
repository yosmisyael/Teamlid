<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Deduction;
use App\Models\Payroll;
use App\Models\Salary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PayrollPdfController extends Controller
{
    public function download($id)
    {
        $payroll = Payroll::query()->with(['employee.position', 'employee.department'])
            ->findOrFail($id);

        $salary = Salary::query()->where('employee_id', $payroll->employee_id)->first();

        $admin = Auth::guard('admins')->user();

        $company = $admin->company;

        $logoPath = public_path('logo.svg');
        $logoBase64 = '';

        if (File::exists($logoPath)) {
            $logoData = File::get($logoPath);
            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode($logoData);
        }

        $tax = Deduction::query()->where('slug', 'tax')->firstOrFail();
        $taxedSalary = (float) $salary->base_salary + $salary->allowance - ($salary->base_salary + $salary->allowance) * ($tax->value / 100);
        $healthInsurance = Deduction::query()->where('slug', 'health_insurance')->firstOrFail();
        $fine = Deduction::query()->whereIn('slug', ['fine_late', 'fine_absence'])->pluck(
            'value', 'slug'
        );

        $pdf = Pdf::loadView('pdf.payslip', [
            'otherCuts' => $salary->cut,
            'payroll' => $payroll,
            'company' => $company,
            'logoBase64' => $logoBase64,
            'tax' => [
                'percentage' => $tax->value,
                'value' => ($tax->value / 100) * ($payroll->base_salary + $payroll->allowance),
            ],
            'taxedSalary' => $taxedSalary,
            'healthInsurance' => $healthInsurance->value,
            'fine' => $fine
        ]);

        $pdf->setPaper('a4', 'portrait');

        $fileName = "salary-{$payroll->id}-{$payroll->employee->name}-{$payroll->period_month}.pdf";
        return $pdf->download($fileName);
    }
}
