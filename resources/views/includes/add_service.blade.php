<!-- Modal Añadir Servicio -->
<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('services.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Añadir Servicio</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nombre del Servicio</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
