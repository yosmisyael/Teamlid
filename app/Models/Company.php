<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'founded_date',
        'website',
        'description',
        'field',
        'registered_by',
    ];

    protected $casts = [
        'founded_date' => 'date',
    ];

    public function registeredBy(): BelongsTo {
        return $this->belongsTo(Admin::class, 'registered_by');
    }

    public function banks(): HasMany
    {
        return $this->hasMany(Bank::class, 'company_id');
    }
}
