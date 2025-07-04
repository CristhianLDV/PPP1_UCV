@extends('layouts.master')
@section('title', 'Gestión de Usuarios')

@section('css')
<!-- No es necesario repetir estilos, ya están en app.css -->
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Gestión de Usuarios</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Administración</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>
</div>
@endsection

@section('content')
@include('includes.flash')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Botón visible solo en escritorio -->
                <div class="d-none d-md-flex justify-content-end mb-3">
                    <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat">
                        <i class="mdi mdi-plus mr-2"></i> Nuevo Usuario
                    </a>
                </div>

                <!-- Tabla -->
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th data-priority="1">ID</th>
                            <th data-priority="2">Nombre</th>
                            <th data-priority="3">Correo Electrónico</th>
                            <th data-priority="4">Roles</th>
                            <th data-priority="6">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td>
                                <a href="#edit{{$user->id}}" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                                    <i class='fa fa-edit'></i> Editar
                                </a>
                                <a href="#delete{{$user->id}}" data-toggle="modal" class="btn btn-danger btn-sm btn-flat">
                                    <i class='fa fa-trash'></i> Eliminar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Botón flotante para móviles -->
<a href="#addnew" data-toggle="modal" class="btn btn-primary floating-add-button d-md-none" title="Nuevo Usuario">
    <i class="mdi mdi-plus"></i>
</a>

@foreach($users as $user)
    @include('includes.edit_delete_user', ['user' => $user])
@endforeach

@include('includes.add_user')
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#roles').select2({
            placeholder: "Seleccione los roles",
            allowClear: true
        });
    });
</script>
@endsection
