<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{

    public static function conceptos()
{
    return [
        1 => 'Personal',
        2 => 'Particular',
        3 => 'Salud',
        4 => 'Fallecimiento',
        5 => 'Onomástico',
        6 => 'Compensación',
        7 => 'A cuentas bancarias',
        8 => 'Capacitaciones',
        9 => 'Comisión de servicio',
    ];
}

    protected $fillable = [
        'emp_id',
        'concept',
        'leave_time',
        'leave_date',
        'status',
    ];


    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'emp_id');
    }
        public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class, 'work_schedule_id');
    }


}
