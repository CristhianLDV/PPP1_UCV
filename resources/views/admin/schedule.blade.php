@extends('layouts.master')
@section('title', 'Horarios')

@section('css')
<!-- No repetir estilos, ya están en el CSS global -->
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Horarios</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Horarios</a></li>
    </ol>
</div>
@endsection

@section('content')
@include('includes.flash')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
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

                <!-- Botón para escritorio -->
                <div class="d-none d-md-flex justify-content-end mb-3">
                    <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat">
                        <i class="mdi mdi-plus mr-2"></i>Añadir
                    </a>
                </div>

                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th data-priority="1">ID</th>
                                    <th data-priority="2">Turno</th>
                                    <th data-priority="3">Hora de Entrada</th>
                                    <th data-priority="4">Hora de Salida</th>
                                    <th data-priority="5">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->id }}</td>
                                    <td>{{ $schedule->slug }}</td>
                                    <td>{{ $schedule->time_in }}</td>
                                    <td>{{ $schedule->time_out }}</td>
                                    <td>
                                        <a href="#edit{{ $schedule->slug }}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat">
                                            <i class='fa fa-edit'></i> Editar
                                        </a>
                                        <a href="#delete{{ $schedule->slug }}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat">
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
    </div>
</div>

<!-- Botón flotante solo para móvil -->
<a href="#addnew" data-toggle="modal" class="btn btn-primary floating-add-button d-md-none" title="Añadir">
    <i class="mdi mdi-plus"></i>
</a>

<!-- Modales -->
@foreach ($schedules as $schedule)
    @include('includes.edit_delete_schedule')
@endforeach

@include('includes.add_schedule')

@endsection

@section('script')
<script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>
@endsection
