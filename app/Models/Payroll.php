<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'period_month',
        'payment_date',
        'base_salary',
        'allowance',
        'cut',
        'absence_deduction',
        'total_absence',
        'total_late',
        'working_days',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'base_salary' => 'decimal:2',
        'allowance' => 'decimal:2',
        'cut' => 'decimal:2',
        'absence_deduction' => 'decimal:2',
    ];

    public function calculateNetSalary(): float
    {
        $tax = Deduction::query()->where('slug', '=', 'tax')->first();
        $taxedSalary = ($this->base_salary + $this->allowance) * ((1 - $tax->value / 100));
        return $taxedSalary - $this->cut - $this->absence_deduction;
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
