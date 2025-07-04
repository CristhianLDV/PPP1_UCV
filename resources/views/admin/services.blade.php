@extends('layouts.master')
@section('title', 'Gestión de Servicios')

@section('css')
<!-- No repetir estilos aquí, ya están en CSS global -->
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Servicios</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Servicios</a></li>
        <li class="breadcrumb-item active">Lista de Servicios</li>
    </ol>
</div>
@endsection

@section('content')
@include('includes.flash')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Botón visible solo en escritorio -->
                <div class="d-none d-md-flex justify-content-end mb-3">
                    <a href="#addServiceModal" data-toggle="modal" class="btn btn-primary btn-sm btn-flat">
                        <i class="mdi mdi-plus mr-2"></i>Añadir Servicio
                    </a>
                </div>

                <!-- Tabla de servicios -->
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Servicio</th>
                            <th>Descripción</th>
                
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->description }}</td>
                        
                            <td>
                                <a href="#editService{{ $service->id }}" data-toggle="modal" class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <a href="#deleteService{{ $service->id }}" data-toggle="modal" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Eliminar
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

<!-- Botón flotante visible solo en móvil -->
<a href="#addServiceModal" data-toggle="modal" class="btn btn-primary floating-add-button d-md-none" title="Añadir Servicio">
    <i class="mdi mdi-plus"></i>
</a>

{{-- Modales --}}
@foreach ($services as $service)
    @include('includes.edit_delete_service', ['service' => $service])
@endforeach

@include('includes.add_service')

@endsection

@section('script')
<!-- Scripts específicos si los hay -->
@endsection
