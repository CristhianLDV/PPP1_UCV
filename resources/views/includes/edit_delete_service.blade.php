<!-- Modal Editar Servicio -->
<div class="modal fade" id="editService{{ $service->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('services.update', $service->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Servicio</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nombre del Servicio</label>
            <input type="text" class="form-control" name="name" value="{{ $service->name }}" required>
          </div>
          <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" name="description">{{ $service->description }}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Eliminar Servicio -->
<div class="modal fade" id="deleteService{{ $service->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('services.destroy', $service->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Eliminación</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar el servicio <strong>{{ $service->name }}</strong>?
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
    </form>
  </div>
</div>
