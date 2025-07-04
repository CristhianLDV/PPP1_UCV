<?php

namespace App\Models;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model

{

    protected $table = 'attendances';
    protected $fillable = [

        'emp_id',
        'attendance_date', 
        'attendance_time',
        'status',
        'type',
        'reason'
      ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'emp_id');
    }
    public function latetime()
    {
        return $this->hasOne(\App\Models\Latetime::class, 'emp_id', 'emp_id')
                    ->whereColumn('latetime_date', 'attendance_date');
    }


    
}
