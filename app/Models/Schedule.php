<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee', 'schedule_employees', 'schedule_id', 'emp_id');
    }
    public function workSchedules() {
    return $this->hasMany(WorkSchedule::class);
    }
    

// En el modelo Schedule.php
protected $fillable = ['name', 'slug', 'time_in', 'time_out'];

}
