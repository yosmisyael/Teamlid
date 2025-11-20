<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

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

    public function salaries(): HasMany {
        return $this->hasMany(Salary::class, 'karyawan_id');
    }

    public function attendances(): HasMany {
        return $this->hasMany(Attendance::class, 'karyawan_id');
    }
}
