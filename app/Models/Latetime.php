<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Latetime extends Model
{
    protected $fillable = [
        'emp_id',
        'latetime_date', // Asegúrate de que este campo exista en tu base de datos
        'duration', // Duración del retraso
      
      
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
 