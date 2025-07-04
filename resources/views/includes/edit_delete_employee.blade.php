<!-- Edit -->
<div class="modal fade" id="edit{{ $employee->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('employees.update', $employee->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Editar Empleado</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body text-left">
          <div class="form-group">
            <label>DNI</label>
            <input type="text" name="dni" value="{{ $employee->dni }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ $employee->name }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Posición</label>
            <input type="text" name="position" value="{{ $employee->position }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" name="email" value="{{ $employee->email }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ $employee->telefono }}" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Actualizar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete -->
<!-- Delete -->
<div class="modal fade" id="delete{{ $employee->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('employees.destroy', $employee->id) }}">
        @csrf
        @method('DELETE')

        <div class="modal-header">
          <h5 class="modal-title">Eliminar Empleado</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body text-center">
          <p>¿Está seguro de que desea eliminar al siguiente empleado?</p>
          <h4><strong>{{ $employee->name }}</strong></h4>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
