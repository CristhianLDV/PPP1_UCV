<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            <h4 class="modal-title"><b>Añadir Empleado</b></h4>
            <div class="modal-body">

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="number" class="form-control" placeholder="Ingrese el DNI del empleado" id="dni" name="dni"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" placeholder="Ingrese el nombre del empleado" id="name" name="name"
                                required />
                        </div>

                        <div class="form-group">
                            <label for="position">Posición</label>
                            <input type="text" class="form-control" placeholder="Ingrese la posición del empleado" id="position" name="position"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" placeholder="Ingrese el correo electrónico del empleado" id="email" name="email"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="number" class="form-control" placeholder="Ingrese el teléfono del empleado" id="telefono" name="telefono"
                                required />
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Guardar
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5" data-dismiss="modal">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>

    </div>
</div>
</div>