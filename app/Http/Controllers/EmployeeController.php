<?php

namespace App\Http\Controllers;


use App\Models\Employee;
use App\Models\WorkSchedule;
use App\Http\Requests\EmployeeRec;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller
{
   
    public function index()
    {
        
        return view('admin.employee')->with(['employees'=> Employee::all()]);
    }

    
    public function store(EmployeeRec $request)
    {
        $request->validated();
        $employee = new Employee();
        $this->fillEmployeeData($employee, $request);

        flash()->success('Éxito', 'Empleado creado correctamente.');
        return redirect()->route('employees.index'); 
    }

    public function update(EmployeeRec $request, $id)

    {
        $employee = Employee::findOrFail($id);
        $request->validated();
        $this->fillEmployeeData($employee, $request);

        // Mensaje de confirmación con flash
        flash()->success('Éxito', 'Empleado actualizado correctamente.');
        return redirect()->route('employees.index');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

                // Mensaje de confirmación con flash
        flash()->success('Éxito', 'Empleado eliminado correctamente.');
        return redirect()->route('employees.index');
    }

    private function fillEmployeeData(Employee $employee, EmployeeRec $request)
    {
        $employee->dni = $request->dni;
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->telefono = $request->telefono;

        // Solo actualizar pin_code si fue enviado (evitar sobreescribir en blanco)
        if ($request->filled('pin_code')) {
            $employee->pin_code = bcrypt($request->pin_code);
        }

        $employee->save();
    }

    
    //Ruta para generar el QR hecho por el usuario CLdv
    public function showQR($id)
    {
        $employee = Employee::findOrFail($id);
        $qr = QrCode::size(250)->generate($employee->id);
        return view('admin.qr', compact('employee', 'qr'));
    }

public function assignWorkSchedule(Request $request)
{
    // Validar datos del formulario
    $validated = $request->validate([
        'emp_id' => 'required|exists:employees,id',
        'schedule_id' => 'required|exists:schedules,id',
        'work_date' => 'required|array',
        'work_date.*' => 'date',
    ]);

    // Guardar cada fecha seleccionada
    foreach ($validated['work_date'] as $date) {
        WorkSchedule::create([
            'emp_id' => $validated['emp_id'],
            'schedule_id' => $validated['schedule_id'],
            'work_date' => $date,
        ]);
    }

    return redirect()->back()->with('success', 'Programación registrada correctamente');
}


public function downloadQrPng($id)
{
    $employee = Employee::findOrFail($id);

    // Solo el ID como texto en el QR (igual que showQR)
    $qrData = (string) $employee->id;

    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($qrData)
        ->size(300)
        ->margin(10)
        ->build();

    return response($result->getString(), 200)
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="empleado_'.$employee->id.'_qr.png"');
}



public function generateCalendarPdf($id)
{

        $employee = Employee::findOrFail($id);

    $workSchedules = WorkSchedule::where('emp_id', $employee->id)
        ->with('schedule','service') // Esta línea carga la relación
        ->orderBy('work_date', 'asc') // ← corr
        ->get();

    // Agrupar y contar por nombre de servicio
    $serviceSummary = $workSchedules->groupBy('service.name')->map(function ($items) {
        return $items->count();
    });

    $pdf = Pdf::loadView('admin.employee_calendar_pdf', [
        'employee' => $employee,
        'workSchedules' => $workSchedules,
        'serviceSummary' => $serviceSummary
    ]);

    return $pdf->download('calendario_trabajo_'.$employee->name.'.pdf');
}

}




