<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'employees';

    protected $fillable = [
        'dni', 'name', 'email', 'pin_code'
    ];

    protected $hidden = [
        'pin_code', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    // Relación con registros de asistencia
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'emp_id');
    }

    // Relación con llegadas tarde
    public function latetimes()
    {
        return $this->hasMany(Latetime::class);
    }

    // Relación con permisos (leaves)
    public function leaves()
    {
        return $this->hasMany(Leave::class, 'emp_id');
    }

    // Relación con horas extra
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    // Relación con horario asignado
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_employees', 'emp_id', 'schedule_id');
    }

    // Relación con work_schedules
    public function workSchedules()
    {
        return $this->hasMany(WorkSchedule::class, 'emp_id');
    }

    // Relación con checadas
    public function checks()
    {
        return $this->hasMany(Check::class);
    }
    // Relación con servicios
 
    public function services()
    {
        return $this->belongsToMany(Service::class, 'employee_service', 'employee_id', 'service_id');
    }
    


}
