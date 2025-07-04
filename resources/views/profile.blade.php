@extends('layouts.master')
@section('title', 'Mi Perfil')

@section('css')
<!-- Agrega aquí tus estilos CSS específicos para esta vista si es necesario -->
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Perfil de Usuario</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Usuario</a></li>
        <li class="breadcrumb-item active">Perfil</li>
    </ol>
</div>
@endsection

@section('button')
<!-- Puedes agregar botones de acción si los necesitas -->
{{-- <a href="#editProfile" data-toggle="modal" class="btn btn-primary btn-sm btn-flat">
    <i class="mdi mdi-account-edit mr-2"></i>Editar Perfil

</a> --}}
@endsection

@section('content')
@include('includes.flash')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Información del Perfil</h4>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="30%">Nombre:</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Código PIN:</th>
                                        <td>{{ $user->pin_code ?? 'No asignado' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rol:</th>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de creación:</th>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Última actualización:</th>
                                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Estado:</th>
                                        <td>
                                            <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                                {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Último inicio de sesión:</th>
                                        <td>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</td>
                                    </tr>
                                    <tr>
                                        <th>IP del último inicio:</th>
                                        <td>{{ $user->last_login_ip ?? 'No disponible' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="text-center">
                            <!-- Aquí puedes agregar la foto de perfil si tienes -->
                            <img src="{{ asset('assets/images/users/default-user.png') }}" 
                                 class="rounded-circle img-thumbnail" 
                                 alt="profile-image"
                                 width="200">
                            <h4 class="mt-3">{{ $user->name }}</h4>
                            
                            <div class="mt-3">
                                <h5>Roles asignados:</h5>
                                <ul class="list-unstyled">
                                    @foreach($user->roles as $role)
                                        <li>
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar perfil (puedes crearlo después) -->
{{-- @include('includes.edit_profile_modal') --}}
{{-- @include('includes.edit_delete_user', ['roles' => $user->roles]) --}}

@endsection

@section('script')
<!-- Agrega aquí tus scripts específicos para esta vista si es necesario -->
@endsection