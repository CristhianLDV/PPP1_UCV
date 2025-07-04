<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckController extends Controller
{
    public function index()
    {
        return view('admin.check')->with(['employees' => Employee::all()]);
    }

    public function CheckStore(Request $request)
    {
        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('emp_id'))->first()) {
                        if (
                            !Attendance::whereAttendance_date($keys)
                                ->whereEmp_id($key)
                                ->whereType(0)
                                ->first()
                        ) {
                            $data = new Attendance();
                            
                            $data->emp_id = $key;
                            $emp_req = Employee::whereId($data->emp_id)->first();
                            $data->attendance_time = date('H:i:s', strtotime($emp_req->schedules->first()->time_in));
                            $data->attendance_date = $keys;
                            $data->save();
                        }
                    }
                }
            }
        }
        if (isset($request->leave)) {
            foreach ($request->leave as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('emp_id'))->first()) {
                        if (
                            !Leave::whereLeave_date($keys)
                                ->whereEmp_id($key)
                                ->whereType(1)
                                ->first()
                        ) {
                            $data = new Leave();
                            $data->emp_id = $key;
                            $emp_req = Employee::whereId($data->emp_id)->first();
                            $data->leave_time = $emp_req->schedules->first()->time_out;
                            $data->leave_date = $keys;
                            // if ($employee->schedules->first()->time_out <= $data->leave_time) {
                            //     $data->status = 1;
                                
                            // }
                            // 
                            $data->save();
                        }
                    }
                }
            }
        }
        flash()->success('Success', 'You have successfully submited the attendance !');
        return back();
    }



public function sheetReport(Request $request)
{
    $query = Attendance::with('employee');

    if ($request->filled('emp_id')) {
        $query->where('emp_id', $request->emp_id);
    }

    if ($request->filled('from')) {
        $query->where('attendance_date', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->where('attendance_date', '<=', $request->to);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Filtro de servicio (requiere join indirecto)
    if ($request->filled('service_id')) {
        $query->whereHas('employee.workSchedules', function ($q) use ($request) {
            $q->where('service_id', $request->service_id);
        });
    }

    $attendances = $query->orderBy('attendance_date', 'desc')->get();

    return view('admin.sheet-report', [
        'employees' => Employee::all(),
        'services' => \App\Models\Service::all(),
        'attendances' => $attendances,
    ]);
}



public function exportExcel(Request $request)
{
    $attendances = $this->filtrarAsistencias($request);
    return Excel::download(new AttendanceExport($attendances), 'reporte_asistencia.xlsx');
    
}

public function exportPDF(Request $request)
{
    $attendances = $this->filtrarAsistencias($request);

    $pdf = Pdf::loadView('exports.attendances', compact('attendances'))
        ->setPaper('A4', 'portrait');

    return $pdf->download('reporte_asistencia.pdf');
}


private function filtrarAsistencias(Request $request)
 {
    $query = Attendance::with('employee');

    if ($request->filled('emp_id')) {
        $query->where('emp_id', $request->emp_id);
    }
    if ($request->filled('service_id')) {
        $query->whereHas('employee.service', function ($q) use ($request) {
            $q->where('id', $request->service_id);
        });
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    if ($request->filled('from')) {
        $query->whereDate('attendance_date', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $query->whereDate('attendance_date', '<=', $request->to);
    }

    return $query->get();
}


}