<!-- Modal para registrar día de trabajo -->
<div class="modal fade" id="workDayModal" tabindex="-1" role="dialog" aria-labelledby="workDayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="workDayForm" method="POST" action="{{ route('employee.schedule.store') }}">
            @csrf
            <input type="hidden" name="employee_id" id="modalEmployeeId">
            <input type="hidden" name="work_date" id="modalWorkDate">

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="workDayModalLabel">
                        <i class="fa fa-plus-circle me-2"></i>Agregar Día de Trabajo
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selectedDatesInput">
                            <i class="fa fa-calendar me-1"></i>Días seleccionados
                        </label>
                        <input type="text" class="form-control" id="selectedDatesInput" readonly>
                    </div>

                    <div class="form-group">
                        <label for="schedule">
                            <i class="fa fa-clock me-1"></i>Horarios
                        </label>
                        <select class="form-control" id="schedule" name="schedule" required>
                            <option value="">- Seleccionar Horario -</option>
                            @foreach($schedules as $schedule)
                            <option value="{{$schedule->slug}}">
                                {{$schedule->slug}} → {{$schedule->time_in}} a {{$schedule->time_out}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                            <div class="form-group">
                                <label for="service_id">
                                    <i class="fa fa-briefcase me-1"></i>Servicio
                                </label>
                                <select class="form-control" id="service_id" name="service_id" required>
                                    <option value="">- Seleccionar Servicio -</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="saveWorkDayBtn">
                        <i class="fa fa-save me-1"></i>Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times me-1"></i>Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>