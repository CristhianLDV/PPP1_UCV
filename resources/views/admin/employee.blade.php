@extends('layouts.master')
@section('title', 'Lista de Empleados')

@section('css')
<!-- No necesitas repetir estilos, ya están en app.css o custom.css -->
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Empleados</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Empleados</a></li>
        <li class="breadcrumb-item active">Lista de Empleados</li>
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

                <!-- Botón solo en escritorio -->
                <div class="d-none d-md-flex justify-content-end mb-3">
                    <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus mr-2"></i> Añadir
                    </a>
                </div>

                <!-- Tabla -->
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th data-priority="1">ID Empleados</th>
                            <th data-priority="2">DNI</th>
                            <th data-priority="3">Nombre</th>
                            <th data-priority="4">Posición</th>
                            <th data-priority="5">Correo Electrónico</th>
                            <th data-priority="6">Teléfono</th>
                            <th data-priority="8">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->dni }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->telefono }}</td>
                            <td>
                                <a href="#edit{{ $employee->id }}" data-toggle="modal" class="btn btn-success btn-sm">
                                    <i class='fa fa-edit'></i> Editar
                                </a>
                                <a href="#delete{{ $employee->id }}" data-toggle="modal" class="btn btn-danger btn-sm">
                                    <i class='fa fa-trash'></i> Eliminar
                                </a>
                                <a href="{{ route('employee.qr', $employee->id) }}" class="btn btn-primary btn-sm btn-flat">
                                    <i class='fa fa-qrcode'></i> QR
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
<a href="#addnew" data-toggle="modal" class="btn btn-primary floating-add-button d-md-none" title="Añadir">
    <i class="mdi mdi-plus"></i>
</a>

@foreach($employees as $employee)
    @include('includes.edit_delete_employee')
@endforeach

@include('includes.add_employee')

@endsection

@section('script')
<!-- Aquí puedes cargar tus scripts DataTables o lo que necesites -->
@endsection
