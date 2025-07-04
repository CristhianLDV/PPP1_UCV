<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ReportController extends Controller
{
   public function mostrarFaltas()
{
    $faltas = [];

    $empleados = \App\Models\Employee::all();

    foreach ($empleados as $empleado) {
        $turnos = \App\Models\WorkSchedule::where('emp_id', $empleado->id)
            ->where('work_date', '<=', now()->toDateString())
            ->get();

        foreach ($turnos as $turno) {
            $asistencia = \App\Models\Attendance::where('emp_id', $empleado->id)
                ->where('attendance_date', $turno->work_date)
                ->first();

            $permiso = \App\Models\Leave::where('emp_id', $empleado->id)
                ->where('leave_date', $turno->work_date)
                ->first();

            if (!$asistencia && !$permiso) {
                $faltas[] = [
                    'empleado' => $empleado->name, // ✅ aquí el cambio
                    'fecha' => $turno->work_date,
                ];
            }
        }
    }

    return view('admin.reporte_faltas', compact('faltas'));
}

}
