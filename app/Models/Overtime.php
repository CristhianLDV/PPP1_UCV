<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $fillable = [
        'emp_id',
        'duration',
        'overtime_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    

}

