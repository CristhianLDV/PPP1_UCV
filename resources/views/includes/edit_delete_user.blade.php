<!-- Modal de Edición para Usuarios -->
<div class="modal fade" id="edit{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b><span class="user_id">Editar Usuario</span></b></h4>
            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Dejar en blanco para no cambiar">
                    </div>
                    <div class="form-group">
                        <label for="roles" class="col-sm-3 control-label">Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" style="width: 100%;">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                            <i class="fa fa-close"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-success btn-flat">
                            <i class="fa fa-check-square-o"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Eliminación para Usuarios -->
<div class="modal fade" id="delete{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="align-items: center">
                <h4 class="modal-title"><span class="user_id">Eliminar Usuario</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('users.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="text-center">
                        <h6>¿Está seguro de que desea eliminar al usuario:</h6>
                        <h2 class="bold del_user_name">{{ $user->name }}</h2>
                        <p>Email: {{ $user->email }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                            <i class="fa fa-close"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-danger btn-flat">
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>