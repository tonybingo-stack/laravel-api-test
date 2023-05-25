<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * Get the Company that owns the Employee.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }    
}
