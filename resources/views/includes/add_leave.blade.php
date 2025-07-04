<!-- Add Leave Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Añadir Permiso</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('leave.store') }}">
                    @csrf

                    <!-- Empleado -->
                    <div class="form-group">
                        <label for="emp_id" class="col-sm-3 control-label">Empleado</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="emp_id" name="emp_id" required>
                                <option value="" selected disabled>- Seleccionar -</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }} ({{ $employee->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="form-group">
                        <label for="leave_date" class="col-sm-3 control-label">Fecha</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="leave_date" name="leave_date" required>
                        </div>
                    </div>

                    <!-- Concepto -->
                    <div class="form-group">
                        <label for="concept" class="col-sm-3 control-label">Concepto</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="concept" name="concept" required>
                                <option value="" selected disabled>- Seleccionar -</option>
                                <option value="1">Personal</option>
                                <option value="2">Particular</option>
                                <option value="3">Salud</option>
                                <option value="4">Fallecimiento</option>
                                <option value="5">Onomástico</option>
                                <option value="6">Compensación</option>
                                <option value="7">A cuentas bancarias</option>
                                <option value="8">Capacitaciones</option>
                                <option value="9">Comisión de servicio</option>
                            </select>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Estado</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status" required>
                                <option value="" selected disabled>- Seleccionar -</option>
                                <option value="0">Aprobado</option>
                                <option value="1">Pendiente</option>
                                <option value="2">Rechazado</option>
                            </select>
                        </div>
                    </div>
            </div>

            <!-- Botones -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> Cerrar
                </button>
                <button type="submit" class="btn btn-primary btn-flat">
                    <i class="fa fa-save"></i> Guardar
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
