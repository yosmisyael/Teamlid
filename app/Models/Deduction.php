<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Deduction extends Model
{
    protected $fillable = [
        'name',
        'value',
        'type',
        'is_global',
        'slug'
    ];

    protected $casts = [
        'value' => 'float',
        'is_global' => 'boolean',
    ];

    public static function booted(): void
    {
        static::creating(function ($deduction) {
            if (empty($deduction->slug)) {
                $deduction->slug = Str::slug($deduction->name);
            }
        });

         static::updating(function ($deduction) {
             if ($deduction->isDirty('name') && empty($deduction->getOriginal('slug'))) {
                 $deduction->slug = Str::slug($deduction->name, '_');
             }
         });
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_deduction');
    }
}
