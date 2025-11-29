<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Slip Gaji - {{ $payroll->period_month }}</title>
    @vite('resources/css/app.css')
    <style>
        body, table, td, th {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 12px;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .container { padding: 30px 40px; position: relative; min-height: 900px; }

        /* Header Section */
        .header {
            border-bottom: 3px solid #27AAE2; /* Secondary Color */
            margin-bottom: 25px;
            padding-bottom: 20px;
        }
        .company-details { float: left; width: 60%; }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #176688; /* Primary Color */
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }
        .company-address { font-size: 10px; color: #555; line-height: 1.4; }

        .payslip-title {
            float: right;
            text-align: right;
            width: 35%;
        }
        .title-text {
            font-size: 20px;
            font-weight: bold;
            color: #27AAE2; /* Secondary Color */
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .period-text { font-size: 12px; color: #176688; margin-top: 5px; font-weight: bold; }

        /* Clearfix */
        .clear { clear: both; }

        /* Employee Info Table */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .info-table td {
            padding: 8px 0;
            border-bottom: 1px solid #93D5F1; /* Tertiary Color for lines */
        }
        .label {
            color: #176688; /* Primary Color */
            font-weight: bold;
            width: 130px;
        }
        .val { font-weight: 500; color: #333; }
        .text-right { text-align: right; }

        /* Financial Tables Layout */
        .layout-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .col-left { width: 48%; vertical-align: top; padding-right: 10px; }
        .col-right { width: 48%; vertical-align: top; padding-left: 10px; }

        .finance-box { margin-bottom: 10px; }

        /* Menggunakan Secondary Color untuk Header Tabel agar kontras */
        .box-header {
            background-color: #93D5F1;
            color: #104a63;
            padding: 8px 10px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            border-radius: 4px 4px 0 0;
        }
        .finance-table { width: 100%; border-collapse: collapse; }
        .finance-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #93D5F1; /* Tertiary Color */
            border-left: 1px solid #f0f0f0;
            border-right: 1px solid #f0f0f0;
        }

        .earning-total { color: #176688; font-weight: bold; } /* Primary */
        .deduction-total { color: #c0392b; font-weight: bold; } /* Merah tetap untuk potongan agar logis */

        /* Net Pay Box - Menggunakan Primary Color Dominan */
        .net-pay-container {
            margin-top: 25px;
            background-color: #176688; /* Primary Color */
            color: #fff;
            padding: 15px 20px;
            border-radius: 6px;
            border-bottom: 4px solid #104a63; /* Darker shade of primary for depth */
        }
        .net-label { text-transform: uppercase; font-size: 11px; letter-spacing: 1px; opacity: 0.9; }
        .net-amount { float: right; font-size: 22px; font-weight: bold; margin-top: -15px; }

        /* Footer & Signature */
        .footer-section { margin-top: 40px; }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
            color: #176688; /* Primary Color */
        }
        .sign-space {
            height: 60px;
            border-bottom: 1px solid #27AAE2; /* Secondary Color */
            margin-bottom: 5px;
        }

        /* Supported By (Sponsor Footer) */
        .sponsor-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            border-top: 1px solid #93D5F1; /* Tertiary Color */
            padding-top: 10px;
            color: #176688; /* Primary Color */
            font-size: 13px;
        }
        .sponsor-logo {
            height: 16px;
            vertical-align: middle;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="company-details">
            <span class="company-name">{{ $company->name ?? 'Company name' }}</span>
            <div class="company-address">
                {{ $company->address ?? 'Company Address' }}<br>
                {{ $company->phone ? 'Tel: '.$company->phone : '' }}
                {{ $company->website ? '| Web: '.$company->website : '' }}
            </div>
        </div>
        <div class="payslip-title">
            <div class="title-text">Salary Slip</div>
            <div class="period-text">Period: {{ \Carbon\Carbon::parse($payroll->period_month)->format('F Y') }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Employee Name</td>
            <td class="val">: {{ $payroll->employee->name }}</td>
            <td class="label">ID Payroll</td>
            <td class="val text-right">: #PYR-{{ str_pad($payroll->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="label">Employee ID</td>
            <td class="val">: {{ $payroll->employee->id }}</td>
            <td class="label">Payment Date</td>
            <td class="val text-right">: {{ \Carbon\Carbon::parse($payroll->payment_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Position</td>
            <td class="val">: {{ $payroll->employee->position->name ?? '-' }}</td>
            <td class="label">Department</td>
            <td class="val text-right">: {{ $payroll->employee->department->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="layout-table">
        <tr>
            <td class="col-left">
                <div class="box-header">EARNINGS</div>
                <table class="finance-table">
                    <tr>
                        <td>Base Salary</td>
                        <td class="text-right">{{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Allowance</td>
                        <td class="text-right">{{ number_format($payroll->allowance, 0, ',', '.') }}</td>
                    </tr>
                    <tr><td colspan="2" style="height: 20px;"></td></tr>
                    <tr style="background-color: #f4fbff;"> <td><strong>Gross Salary</strong></td>
                        <td class="text-right earning-total">Rp {{ number_format($payroll->base_salary + $payroll->allowance, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>

            <td class="col-right">
                <div class="box-header">DEDUCTIONS</div>
                <table class="finance-table">
                    <tr>
                        <td>Tax ({{ number_format($tax['percentage'], 2, ',', '.') }}%)</td>
                        <td class="text-right">{{ number_format($tax['value'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Health Insurance</td>
                        <td class="text-right">{{ number_format($healthInsurance, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Absence cuts {{ $payroll->total_absence }} x {{ $fine['fine_absence'] }}</td>
                        <td class="text-right">{{ number_format($payroll->total_absence * $fine['fine_absence'] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Late cuts ({{ abs($payroll->total_late) }} minutes x {{ $fine['fine_late']  }})</td>
                        <td class="text-right">{{ number_format($payroll->total_late * $fine['fine_late'] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Other Cuts</td>
                        <td class="text-right">{{ number_format($otherCuts, 0, ',', '.') }}</td>
                    </tr>
                    <tr><td colspan="2" style="height: 20px;"></td></tr>
                    <tr style="background-color: #fff4f4;"> <td><strong>Cuts total</strong></td>
                        <td class="text-right deduction-total">Rp {{ number_format($payroll->cut + $payroll->absence_deduction + ($payroll->base_salary + $payroll->allowance) * ($tax['percentage'] / 100), 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="net-pay-container">
        <span class="net-label">Total Take Home Pay</span>
        <div class="net-amount">
            Rp {{ number_format($taxedSalary - ($payroll->cut + $payroll->absence_deduction ?? 0 + $tax['value']), 0, ',', '.') }}
        </div>
    </div>

    <div class="footer-section">
        <div class="signature-box">
            <p style="margin-bottom: 5px;">Jakarta, {{ now()->format('d F Y') }}</p>
            <p style="font-size: 10px; color: #777;">Approved By,</p>
            <div class="sign-space"></div>
            <p><strong>HR Manager</strong></p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="sponsor-footer">
        <p style="display: inline-flex; align-items: center">
            Supported by
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" class="sponsor-logo" alt="Teamable Logo">
            @endif
            <strong>Teamable</strong>
        </p>
    </div>
</div>
</body>
</html>
