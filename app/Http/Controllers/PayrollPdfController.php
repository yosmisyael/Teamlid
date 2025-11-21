<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PayrollPdfController extends Controller
{
    public function download($id)
    {
        $payroll = Payroll::query()->with(['employee.position', 'employee.department'])
            ->findOrFail($id);

        $admin = Auth::guard('admins')->user();

        $company = $admin->company;

        $logoPath = public_path('logo.svg');
        $logoBase64 = '';

        if (File::exists($logoPath)) {
            $logoData = File::get($logoPath);
            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode($logoData);
        }

        $pdf = Pdf::loadView('pdf.payslip', [
            'payroll' => $payroll,
            'company' => $company,
            'logoBase64' => $logoBase64
        ]);

        $pdf->setPaper('a4', 'portrait');

        $fileName = "salary-{$payroll->id}-{$payroll->employee->name}-{$payroll->period_month}.pdf";
        return $pdf->download($fileName);
    }
}
