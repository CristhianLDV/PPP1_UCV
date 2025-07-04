<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $labels = collect();
        $total = collect();
        $onTime = collect();
        $late = collect();

        // Datos de los últimos 7 días
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $label = Carbon::parse($date)->format('d/m');

            $labels->push($label);

            $totalCount = Attendance::where('type', 1)
                ->whereDate('attendance_date', $date)
                ->count();
            $total->push($totalCount);

            $onTimeCount = Attendance::where('type', 1)
                ->whereDate('attendance_date', $date)
                ->whereDoesntHave('latetime')
                ->count();
            $onTime->push($onTimeCount);

            $lateCount = Attendance::where('type', 1)
                ->whereDate('attendance_date', $date)
                ->whereHas('latetime')
                ->count();
            $late->push($lateCount);
        }

        // Datos para las tarjetas resumen
        $totalEmpleados = Employee::count();

        $today = Carbon::today();

        $aTiempoHoy = Attendance::where('type', 1)
            ->whereDate('attendance_date', $today)
            ->whereDoesntHave('latetime')
            ->count();

        $tardeHoy = Attendance::where('type', 1)
            ->whereDate('attendance_date', $today)
            ->whereHas('latetime')
            ->count();

        $totalHoy = $aTiempoHoy + $tardeHoy;

        $porcentajePuntualidad = $totalHoy > 0
            ? round(($aTiempoHoy / $totalHoy) * 100, 2)
            : 0;

        $faltasHoy = $totalEmpleados - $totalHoy;

        return view('admin.dashboard', [
            'labels' => $labels,
            'series' => [
                'Total' => $total,
                'A Tiempo' => $onTime,
                'Tarde' => $late,
            ],
            'data' => [
                $totalEmpleados,       // index 0
                $aTiempoHoy,           // index 1
                $tardeHoy,             // index 2
                $porcentajePuntualidad,// index 3
                $faltasHoy,            // index 4
            ],
        ]);
    }
}
