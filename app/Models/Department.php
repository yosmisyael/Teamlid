<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manager_id',
        'is_active',
        'company_id',
    ];

    public function employees(): HasMany {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }

    public function manager(): BelongsTo {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
