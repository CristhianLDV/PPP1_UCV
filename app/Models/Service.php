<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;


    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_service', 'service_id', 'employee_id');
    }
}
