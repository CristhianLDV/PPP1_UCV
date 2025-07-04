<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\WorkSchedule;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;
use Carbon\Carbon;

class WorkScheduleController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start_month', now()->format('Y-m'));
        $end = $request->input('end_month', now()->addMonth()->format('Y-m'));

        $startDate = \Carbon\Carbon::parse($start . '-01');
        $endDate = \Carbon\Carbon::parse($end . '-01')->endOfMonth();
        $dateRange = \Carbon\CarbonPeriod::create($startDate, $endDate);
        
        $employees = Employee::with('workSchedules')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->get();
            
    $services = Service::all();
        $schedules = Schedule::all();
        return view('admin.work_schedule', compact('employees', 'schedules', 'services', 'dateRange'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id', // Changed from emp_id
            'work_date' => 'required|string', // Formato: 2025-06-10|2025-06-11
            'schedule' => 'required|string', // Changed to accept slug
            'service_id' => 'required|exists:services,id',
        ]);

        // Find schedule by slug
        $schedule = Schedule::where('slug', $request->schedule)->first();
        if (!$schedule) {
            return redirect()->back()->with('error', 'Horario no encontrado.');
        }

        // Parse date range
        $dateRange = explode('|', $request->work_date);
        $startDate = Carbon::parse($dateRange[0]);
        $endDate = Carbon::parse($dateRange[1]);
        
        // Create period between dates
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate->subDay());
        
        foreach ($period as $date) {
            // Check if already exists to avoid duplicates
            $existing = WorkSchedule::where('emp_id', $request->employee_id)
                ->where('work_date', $date->format('Y-m-d'))
                ->first();
                
            if (!$existing) {
                WorkSchedule::create([
                    'emp_id' => $request->employee_id,
                    'work_date' => $date->format('Y-m-d'),
                    'schedule_id' => $schedule->id,
                    'service_id' => $request->service_id,
                ]);
            }
        }
        

            flash()->success('Éxito', 'Días de trabajo agregados correctamente.');
    return redirect()->back();
    }

    public function getEmployeeSchedule($employeeId)
    {
        $schedules = WorkSchedule::where('emp_id', $employeeId)
            ->with('schedule', 'service')
            ->get();
            
        $events = [];
        foreach ($schedules as $workSchedule) {
            $events[] = [
                'id' => $workSchedule->id,
                'title' => $workSchedule->schedule->slug . ': ' . $workSchedule->service->name,
                'start' => $workSchedule->work_date,
                'allDay' => true,
                'backgroundColor' => '#28a745', // Green color
                'borderColor' => '#28a745'
            ];
        }

        return response()->json($events);
    }

    public function events(Request $request)
    {
        $events = WorkSchedule::with(['employee', 'schedule', 'service'])->get()->map(function ($ws) {
            return [
                'title' => $ws->employee->name . ' - ' . $ws->schedule->name . ' - ' . $ws->service->name,
                'start' => $ws->work_date,
                'allDay' => true,
            ];
        });
        return response()->json($events);
    }

    public function assignWorkSchedule(Request $request)
    {
        $validated = $request->validate([
            'emp_id' => 'required|exists:employees,id',
            'schedule_id' => 'required|exists:schedules,id',
            'work_date' => 'required|array',
            'work_date.*' => 'date',
            'service_id' => 'required|exists:services,id',
        ]);

        foreach ($validated['work_date'] as $date) {
            WorkSchedule::create([
                'emp_id' => $validated['emp_id'],
                'schedule_id' => $validated['schedule_id'],
                'work_date' => $date,
                'service_id' => $validated['service_id'],
            ]);
        }

           flash()->success('Éxito', 'Programación registrada correctamente.');
    return redirect()->back();
    }

    public function destroy($id)
{
    $event = WorkSchedule::find($id);

    if (!$event) {
        return response()->json(['error' => 'No se encontró el evento'], 404);
    }

    $event->delete();

    return response()->json(['message' => 'Evento eliminado correctamente'], 200);
}


}