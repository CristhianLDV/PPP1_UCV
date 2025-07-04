@foreach($leaves as $leave)
<!-- Edit Modal -->
<div class="modal fade" id="edit{{ $leave->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Editar Permiso</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('leave.update', $leave->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_emp_id" class="col-sm-3 control-label">Empleado</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_emp_id" name="emp_id" required>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $employee->id == $leave->emp_id ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_leave_date" class="col-sm-3 control-label">Fecha</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="edit_leave_date" name="leave_date" 
                                   value="{{ $leave->leave_date }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_leave_time" class="col-sm-3 control-label">Concepto</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_leave_concept" name="concept" required>
                                <option value="1" {{ $leave->concept == 1 ? 'selected' : '' }}>Personal</option>
                                <option value="2" {{ $leave->concept == 2 ? 'selected' : '' }}>Particular</option>
                                <option value="3" {{ $leave->concept == 3 ? 'selected' : '' }}>Salud</option>
                                <option value="4" {{ $leave->concept == 4 ? 'selected' : '' }}>Fallecimiento</option>
                                <option value="5" {{ $leave->concept == 5 ? 'selected' : '' }}>Onomástico</option>
                                <option value="6" {{ $leave->concept == 6 ? 'selected' : '' }}>Compensación</option>
                                <option value="7" {{ $leave->concept == 7 ? 'selected' : '' }}>A cuentas bancarias</option>
                                <option value="8" {{ $leave->concept == 8 ? 'selected' : '' }}>Capacitaciones</option>
                                <option value="9" {{ $leave->concept == 9 ? 'selected' : '' }}>Comisión de servicio</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_status" class="col-sm-3 control-label">Estado</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_status" name="status">
                                <option value="0" {{ $leave->status == 0 ? 'selected' : '' }}>Aprobado</option>
                                <option value="1" {{ $leave->status == 1 ? 'selected' : '' }}>Pendiente</option>
                                <option value="2" {{ $leave->status == 2 ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> Cerrar
                </button>
                <button type="submit" class="btn btn-success btn-flat">
                    <i class="fa fa-check"></i> Actualizar
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete{{ $leave->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Eliminar Permiso</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('leave.destroy', $leave->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="text-center">
                        <h5>¿Estás seguro de que deseas eliminar este permiso?</h5>
                        <h6>Fecha: {{ $leave->leave_date }}</h6>
                        <h6>Empleado: {{ $leave->employee->name }}</h6>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-danger btn-flat">
                    <i class="fa fa-trash"></i> Eliminar
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach