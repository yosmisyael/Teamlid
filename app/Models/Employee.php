<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static latest()
 */
class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'address',
        'start_date',
        'status',
        'department_id',
        'position_id',
    ];

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function salaries(): HasMany {
        return $this->hasMany(Salary::class, 'karyawan_id');
    }

    public function attendances(): HasMany {
        return $this->hasMany(Attendance::class, 'karyawan_id');
    }
}
