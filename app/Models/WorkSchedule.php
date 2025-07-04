<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory; 
   protected $table = 'work_schedules';
   protected $fillable = ['emp_id', 'work_date', 'schedule_id','service_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
        
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function leave()
    {
        return $this->hasOne(Leave::class, 'work_schedule_id');
    }


}
