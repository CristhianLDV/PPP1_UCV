<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\Attendance;
use App\Models\WorkSchedule;
use App\Models\Schedule;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AttendanceStoreRequest;

class AttendanceController extends Controller
{   
    //show attendance 
    public function index()
    {      
        
            $attendances = Attendance::with('employee')->get();
            $employees = Employee::orderBy('name')->get(); // Asegúrate de importar el modelo Employee  
            return view('admin.attendance', compact('attendances', 'employees'));

    }



public function store(AttendanceStoreRequest $request)
{
    try {
        $employee = Employee::find($request->emp_id);
        if (!$employee) {
            flash()->error('Error', 'Empleado no encontrado.');
            return back();
        }

        $attendance_date = $request->attendance_date;
        $attendance_time = $request->attendance_time;
        $att_dateTime = $attendance_date . ' ' . $attendance_time . ':00';

        $workSchedule = WorkSchedule::where('emp_id', $employee->id)
            ->where('work_date', $attendance_date)
            ->first();

        if (!$workSchedule) {
            flash()->error('Error', 'El empleado no tiene turno programado para esa fecha.');
            return back();
        }

        $schedule = Schedule::find($workSchedule->schedule_id);
        if (!$schedule) {
            flash()->error('Error', 'No se encontró el horario programado.');
            return back();
        }

        $hasEntry = Attendance::where('emp_id', $employee->id)
            ->where('attendance_date', $attendance_date)
            ->where('type', 1)
            ->exists();

        $hasExit = Attendance::where('emp_id', $employee->id)
            ->where('attendance_date', $attendance_date)
            ->where('type', 0)
            ->exists();

        if (!$hasEntry) {
            $type = 1;
            $mensaje = 'Entrada registrada correctamente.';
        } elseif (!$hasExit) {
            $type = 0;
            $mensaje = 'Salida registrada correctamente.';
        } else {
            flash()->info('Info', 'Ya se registró entrada y salida para esa fecha.');
            return back();
        }

        $status = 1;
        $attDateTimeCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $att_dateTime);

        if ($type == 1) {
            $scheduledIn = Carbon::createFromFormat('H:i:s', $schedule->time_in)
                ->setDate($attDateTimeCarbon->year, $attDateTimeCarbon->month, $attDateTimeCarbon->day);

            // ⛔️ Validación: fuera del rango permitido de entrada
            $horaMinimaEntrada = $scheduledIn->copy()->subMinutes(10);
            $horaMaximaEntrada = $scheduledIn->copy()->addMinutes(30);
            if ($attDateTimeCarbon->lessThan($horaMinimaEntrada) || $attDateTimeCarbon->greaterThan($horaMaximaEntrada)) {
                flash()->error('Error', 'No puedes registrar entrada fuera del rango permitido (de ' . $horaMinimaEntrada->format('H:i') . ' a ' . $horaMaximaEntrada->format('H:i') . ').');
                return back();
            }

            if ($attDateTimeCarbon->greaterThan($scheduledIn)) {
                $status = 0;
                $diffInSeconds = $attDateTimeCarbon->diffInSeconds($scheduledIn);
                $duration = gmdate('H:i:s', $diffInSeconds);

                Latetime::create([
                    'emp_id' => $employee->id,
                    'latetime_date' => $attendance_date,
                    'duration' => $duration,
                ]);
            }

        } elseif ($type == 0) {
            $scheduledOut = Carbon::createFromFormat('H:i:s', $schedule->time_out)
                ->setDate($attDateTimeCarbon->year, $attDateTimeCarbon->month, $attDateTimeCarbon->day);

            // ⛔️ Validación: fuera del rango permitido de salida
            $horaMinimaSalida = $scheduledOut->copy()->subMinutes(10);
            $horaMaximaSalida = $scheduledOut->copy()->addMinutes(60);
            if ($attDateTimeCarbon->lessThan($horaMinimaSalida) || $attDateTimeCarbon->greaterThan($horaMaximaSalida)) {
                flash()->error('Error', 'No puedes registrar salida fuera del horario permitido (de ' . $horaMinimaSalida->format('H:i') . ' a ' . $horaMaximaSalida->format('H:i') . ').');
                return back();
            }

            // Si hay horas extras
            if ($attDateTimeCarbon->greaterThan($scheduledOut)) {
                $extraSeconds = $attDateTimeCarbon->diffInSeconds($scheduledOut);
                $extraDuration = gmdate('H:i:s', $extraSeconds);

                Overtime::create([
                    'emp_id' => $employee->id,
                    'duration' => $extraDuration,
                    'overtime_date' => $attendance_date,
                ]);
            }
        }

        // Registro de asistencia
        Attendance::create([
            'emp_id' => $employee->id,
            'attendance_date' => $attendance_date,
            'attendance_time' => $attendance_time,
            'status' => $status,
            'type' => $type,
        ]);

        flash()->success('Éxito', $mensaje);
        return redirect()->route('attendance.index');

    } catch (\Exception $e) {
        Log::error('Error al registrar asistencia desde el modal: ' . $e->getMessage());
        flash()->error('Error', 'Ocurrió un error al registrar la asistencia.');
        return back();
    }
}





    //show late times
    public function indexLatetime()
    {
        return view('admin.latetime')->with(['latetimes' => Latetime::all()]);
    }


public function attended($id)
{
    try {
        $employee = Employee::find($id);

        if (!$employee) {
            return redirect('/')->with('error', 'Empleado no encontrado');
        }

        $attendance_date = date('Y-m-d');
        $attendance_time = date('H:i:s');
        $att_dateTime = $attendance_date . ' ' . $attendance_time;

        $workSchedule = WorkSchedule::where('emp_id', $employee->id)
            ->where('work_date', $attendance_date)
            ->first();

        if (!$workSchedule) {
            return redirect('/')->with('error', 'No tiene turno programado para hoy');
        }

        $schedule = Schedule::find($workSchedule->schedule_id);
        if (!$schedule) {
            return redirect('/')->with('error', 'No se encontró el horario programado');
        }

        $hasEntry = Attendance::where('emp_id', $employee->id)
            ->where('attendance_date', $attendance_date)
            ->where('type', 1)
            ->exists();

        $hasExit = Attendance::where('emp_id', $employee->id)
            ->where('attendance_date', $attendance_date)
            ->where('type', 0)
            ->exists();

        if (!$hasEntry) {
            $type = 1;
            $mensaje = 'Entrada registrada correctamente.';
        } elseif (!$hasExit) {
            $type = 0;
            $mensaje = 'Salida registrada correctamente.';
        } else {
            return redirect('/')->with('info', 'Ya registraste tu entrada y salida hoy.');
        }

        $status = 1;
        $attDateTimeCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $att_dateTime);

        if ($type == 1) {
            $scheduledIn = Carbon::createFromFormat('H:i:s', $schedule->time_in)
                ->setDate($attDateTimeCarbon->year, $attDateTimeCarbon->month, $attDateTimeCarbon->day);

            $horaMinimaEntrada = $scheduledIn->copy()->subMinutes(10);
            $horaMaximaEntrada = $scheduledIn->copy()->addMinutes(30);

            if ($attDateTimeCarbon->lessThan($horaMinimaEntrada) || $attDateTimeCarbon->greaterThan($horaMaximaEntrada)) {
                return redirect('/')->with('error', 'No puedes registrar entrada fuera del horario permitido (de ' . $horaMinimaEntrada->format('H:i') . ' a ' . $horaMaximaEntrada->format('H:i') . ').');
            }

            if ($attDateTimeCarbon->greaterThan($scheduledIn)) {
                $status = 0;

                $diffInSeconds = $attDateTimeCarbon->diffInSeconds($scheduledIn);
                if ($diffInSeconds > 0) {
                    $duration = gmdate('H:i:s', $diffInSeconds);

                    Latetime::create([
                        'emp_id' => $employee->id,
                        'latetime_date' => $attendance_date,
                        'duration' => $duration,
                    ]);
                }
            }

        } elseif ($type == 0) {
            $scheduledOut = Carbon::createFromFormat('H:i:s', $schedule->time_out)
                ->setDate($attDateTimeCarbon->year, $attDateTimeCarbon->month, $attDateTimeCarbon->day);

            $horaMinimaSalida = $scheduledOut->copy()->subMinutes(10);
            $horaMaximaSalida = $scheduledOut->copy()->addMinutes(60);

            if ($attDateTimeCarbon->lessThan($horaMinimaSalida) || $attDateTimeCarbon->greaterThan($horaMaximaSalida)) {
                return redirect('/')->with('error', 'No puedes registrar salida fuera del horario permitido (de ' . $horaMinimaSalida->format('H:i') . ' a ' . $horaMaximaSalida->format('H:i') . ').');
            }

            if ($attDateTimeCarbon->greaterThan($scheduledOut)) {
                $extraSeconds = $attDateTimeCarbon->diffInSeconds($scheduledOut);
                $extraDuration = gmdate('H:i:s', $extraSeconds);

                Overtime::create([
                    'emp_id' => $employee->id,
                    'duration' => $extraDuration,
                    'overtime_date' => $attendance_date,
                ]);
            }
        }

        Attendance::create([
            'emp_id' => $employee->id,
            'attendance_date' => $attendance_date,
            'attendance_time' => $attendance_time,
            'status' => $status,
            'type' => $type,
        ]);

        return redirect('/')->with('success', $mensaje);

    } catch (\Exception $e) {
        Log::error('Error al registrar asistencia: ' . $e->getMessage());
        return redirect('/')->with('error', 'Error al registrar asistencia');
    }
}


}