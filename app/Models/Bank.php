<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'status',
        'company_id',
    ];

    public function salary(): HasMany {
        return $this->hasMany(Salary::class, 'bank_id', 'id');
    }

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
