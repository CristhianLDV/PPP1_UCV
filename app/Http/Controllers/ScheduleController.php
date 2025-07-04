<?php

namespace App\Http\Controllers;
use App\Models\Schedule;
use App\Http\Requests\ScheduleEmp;

class ScheduleController extends Controller
{
   
    public function index()
    {
        $schedules = Schedule::all();
        return view('admin.schedule', compact('schedules'));
    }

    public function store(ScheduleEmp $request)
    {

        $validated = $request->validated();
        $schedule = new Schedule();
        $this->fillScheduleData($schedule, $validated);

        flash()->success('Éxito', 'Horario creado exitosamente.');
        return redirect()->route('schedule.index');

    }

    public function update(ScheduleEmp $request, Schedule $schedule)
    {

         $validated = $request->validated();

        // Recorta segundos si vienen incluidos
        $validated['time_in'] = substr($validated['time_in'], 0, 5);
        $validated['time_out'] = substr($validated['time_out'], 0, 5);

        $this->fillScheduleData($schedule, $validated);

        flash()->success('Éxito', 'Horario actualizado exitosamente.');
        return redirect()->route('schedule.index');

    }

  
    public function destroy(Schedule $schedule)
    {

          $schedule->delete();

        flash()->success('Éxito', 'Horario eliminado exitosamente.');
        return redirect()->route('schedule.index');
    }


    private function fillScheduleData(Schedule $schedule, array $data)
    {
        $schedule->slug = $data['slug'];
        $schedule->time_in = $data['time_in'];
        $schedule->time_out = $data['time_out'];
        $schedule->save();
    }
    
}
