<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'period_month',
        'payment_date',
        'base_salary',
        'allowance',
        'cut'
    ];
}
