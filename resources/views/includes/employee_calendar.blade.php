@foreach($employees as $employee)
<!-- Modal para calendario de cada empleado -->
<div class="modal fade" id="calendarModal{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel{{$employee->id}}" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="calendarModalLabel{{$employee->id}}">
                    <i class="fa fa-calendar me-2"></i>Programación de {{$employee->name}}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>
                    <strong>Instrucciones:</strong> Selecciona una fecha o rango de fechas en el calendario para asignar horarios de trabajo.
                </div>
                <div id="employeeCalendar{{$employee->id}}">
                    <div class="calendar-loader">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                        <p>Cargando calendario...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach