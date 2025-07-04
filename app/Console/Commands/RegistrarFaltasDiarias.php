<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WorkSchedule;
use App\Models\Attendance;
use App\Models\Leave;
use Carbon\Carbon;

class RegistrarFaltasDiarias extends Command
{
    protected $signature = 'faltas:registrar';
    protected $description = 'Registra faltas automáticamente para empleados que no asistieron ni solicitaron permiso';

    public function handle()
    {
        $hoy = Carbon::today()->format('Y-m-d');

        $turnosHoy = WorkSchedule::where('work_date', $hoy)->get();
        $contador = 0;

        foreach ($turnosHoy as $turno) {
            $emp_id = $turno->emp_id;

            $asistencia = Attendance::where('emp_id', $emp_id)
                ->where('attendance_date', $hoy)
                ->exists();

            $permiso = Leave::where('emp_id', $emp_id)
                ->where('leave_date', $hoy)
                ->exists();

            if (!$asistencia && !$permiso) {
                Attendance::create([
                    'emp_id' => $emp_id,
                    'attendance_date' => $hoy,
                    'attendance_time' => now()->format('H:i:s'),
                    'status' => 0, // 0 = falta
                    'type' => 0,
                    'reason' => 'falta automática',
                ]);
                $contador++;
            }
        }

        $this->info("Se registraron $contador faltas.");
    }
}
