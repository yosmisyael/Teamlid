<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'address',
        'status',
        'department_id',
        'job_id',
        'position_id',
        'password',
    ];

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function managedDepartment(): HasOne {
        return $this->hasOne(Department::class, 'manager_id', 'id');
    }

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function job(): BelongsTo {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function salary(): HasOne {
        return $this->hasOne(Salary::class, 'employee_id', 'id');
    }

    public function attendances(): HasMany {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }

    public function company(): HasOneThrough {
        return $this->hasOneThrough(Company::class, Department::class, 'id', 'id', 'department_id');
    }

    public function isRegisteredInCompany(string $companyName): bool {
        return $this->department?->company?->name === $companyName;
    }

    public function deductions()
    {
        return $this->belongsToMany(Deduction::class, 'employee_deduction');
    }
}
