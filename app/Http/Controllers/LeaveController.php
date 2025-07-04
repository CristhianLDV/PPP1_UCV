<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequest;
use DateTime;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Leave;
use App\Models\WorkSchedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::with('employee')->get();

        return view('admin.leave')->with(['leaves' => $leaves]);
    }

    public function assign()
    {
        $employees = Employee::all();

        return view('admin.assign_leave', compact('employees'));
        
    }


public function store(LeaveRequest $request)
{
    // Verifica si ya existe un permiso para ese empleado en esa fecha
    $permisoExistente = Leave::where('emp_id', $request->emp_id)
        ->where('leave_date', $request->leave_date)
        ->exists();

    if ($permisoExistente) {
        flash()->error('Error', 'Ya existe un permiso registrado para este empleado en esa fecha.');
        return redirect()->route('leave.index');
    }

    // Validar si el empleado tiene turno programado
    $turno = WorkSchedule::where('emp_id', $request->emp_id)
        ->where('work_date', $request->leave_date)
        ->first();

    if (!$turno) {
        flash()->error('Error', 'No se puede registrar el permiso: el empleado no tiene turno programado en esa fecha.');
        return redirect()->route('leave.index');
    }

    $leave = new Leave();
    $this->fillLeaveData($leave, $request);

    flash()->success('Éxito', 'Permiso registrado exitosamente.');
    return redirect()->route('leave.index');
}




public function update(LeaveRequest $request, $id)
{
    // Verifica si ya existe otro permiso con la misma fecha
    $permisoExistente = Leave::where('emp_id', $request->emp_id)
        ->where('leave_date', $request->leave_date)
        ->where('id', '!=', $id) // excluye el permiso que se está actualizando
        ->exists();

    if ($permisoExistente) {
        flash()->error('Error', 'Ya existe otro permiso registrado para este empleado en esa fecha.');
        return redirect()->route('leave.index');
    }

    $turno = WorkSchedule::where('emp_id', $request->emp_id)
        ->where('work_date', $request->leave_date)
        ->first();

    if (!$turno) {
        flash()->error('Error', 'No se puede actualizar el permiso: el empleado no tiene turno programado en esa fecha.');
        return redirect()->route('leave.index');
    }

    $leave = Leave::findOrFail($id);
    $this->fillLeaveData($leave, $request);

    flash()->success('Éxito', 'Permiso actualizado correctamente.');
    return redirect()->route('leave.index');
}




    public function destroy(Leave $leave)
    {
        $leave->delete();

        flash()->success('Éxito', 'Permiso eliminado correctamente.');
        return redirect()->route('leave.index');  
    }


        // Método reutilizable para asignar datos a Leave
private function fillLeaveData(Leave $leave, LeaveRequest $request)
{
    $leave->emp_id = $request->emp_id;
    $leave->leave_date = $request->leave_date;
    $leave->concept = $request->concept ?? 0;
    $leave->status = $request->status ?? 1;
    $leave->type = $request->type ?? 1;
    $leave->save();

    $asistencia = Attendance::where('emp_id', $leave->emp_id)
        ->where('attendance_date', $leave->leave_date)
        ->first();

    if (!$asistencia && $leave->status == 0) {
        Attendance::create([
            'emp_id' => $leave->emp_id,
            'attendance_date' => $leave->leave_date,
            'attendance_time' => now()->format('H:i:s'),
            'status' => 3,
            'type' => 2,
            'reason' => 'permiso',
        ]);
    }
}



    public function indexOvertime()
    {
        return view('admin.overtime')->with(['overtimes' => Overtime::all()]);
    }


    public static function overTimeDevice($att_dateTime, Employee $employee)
    {
        
            $attendance_time =new DateTime($att_dateTime);
            $checkout = new DateTime($employee->schedules->first()->time_out);
            $difference = $checkout->diff($attendance_time)->format('%H:%I:%S');

            $overtime = new Overtime();
            $overtime->emp_id = $employee->id;
            $overtime->duration = $difference;
            $overtime->overtime_date = date('Y-m-d', strtotime($att_dateTime));
            $overtime->save();
        
    }
    
    public function assignLeaveForm()
    {
        return view('includes.leaves_assign');
    }

    public function downloadPDF($id)
    {
    $leave = \App\Models\Leave::with('employee')->findOrFail($id);

    $pdf = Pdf::loadView('admin.leave_pdf', compact('leave'));
    return $pdf->download('Permiso_' . $leave->employee->dni . '.pdf');
    }




}
