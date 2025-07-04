<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendance;

class FaltasController extends Controller
{
    public function calcularFaltas()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $faltas = [];

        $employees = Employee::all();

        foreach ($employees as $employee) {
            $fechasLaborales = collect();

            // Generar días laborales (lunes a viernes)
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                    $fechasLaborales->push($date->format('Y-m-d'));
                }
            }

            // Fechas con asistencia reales
            $fechasConAsistencia = Attendance::where('emp_id', $employee->id)
                ->whereBetween('attendance_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->pluck('attendance_date')
                ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
                ->unique();

            // Faltas = fechas laborales - fechas con asistencia
            $fechasFaltas = $fechasLaborales->diff($fechasConAsistencia);

            foreach ($fechasFaltas as $fecha) {
                $faltas[] = [
                    'empleado' => $employee->name,
                    'fecha' => $fecha,
                ];
            }
        }

        return $faltas;
    }

    public function downloadPdf()
    {
        $faltas = $this->calcularFaltas();

        $pdf = Pdf::loadView('admin.faltas_pdf', compact('faltas'));

        return $pdf->download('ReporteFaltas.pdf');
    }
}
