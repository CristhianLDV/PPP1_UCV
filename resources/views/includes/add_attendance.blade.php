<!-- Add Attendance Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Registrar Asistencia</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('attendance.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="emp_id" class="control-label">Empleado</label>
                        <select class="form-control" id="emp_id" name="emp_id" required>
                            <option value="" selected disabled>- Seleccionar -</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }} ({{ $employee->dni }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="attendance_date" class="control-label">Fecha</label>
                        <input type="date" class="form-control" id="attendance_date" 
                               name="attendance_date" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="attendance_time" class="control-label">Hora</label>
                        <input type="time" class="form-control" id="attendance_time" 
                               name="attendance_time" value="{{ date('H:i') }}" required>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-close"></i> Cerrar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Registrar
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
