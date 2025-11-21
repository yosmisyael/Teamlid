<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->base_salary + $this->allowance - $this->cut - $this->absence_deduction;
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
