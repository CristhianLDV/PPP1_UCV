@extends('layouts.master')
@section('title', 'Asistencia de Empleados')

@section('css')
    <!-- Estilos de tabla responsive -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <h4 class="page-title text-left">Asistencia</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item active">Asistencia</li>
        </ol>
    </div>
@endsection

@section('button')
    <!-- Botón visible en escritorio -->
    <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat d-none d-md-inline-block">
        <i class="mdi mdi-plus mr-2"></i>Añadir
    </a>
@endsection

@section('content')
@include('includes.flash')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="table-rep-plugin">
                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th data-priority="1">Fecha</th>
                                    <th data-priority="2">DNI</th>
                                    <th data-priority="3">Nombre</th>
                                    <th data-priority="4">Asistencia</th>
                                    <th data-priority="5">Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d/m/Y') }}</td>
                                        <td>{{ $attendance->employee->dni }}</td>
                                        <td>{{ $attendance->employee->name }}</td>
                                        <td>
                                            {{ $attendance->attendance_time }}
                                            @if ($attendance->status == 1)
                                                <span class="badge badge-primary float-right">A tiempo</span>
                                            @elseif($attendance->status == 0)
                                                <span class="badge badge-danger float-right">Tarde</span>
                                            @else
                                                <span class="badge badge-success float-right">Justificado</span>


                                            @endif
                                        </td>
                                        <td>
                                            @if ($attendance->type == 1)
                                                Entrada
                                            @elseif ($attendance->type == 0)
                                                Salida
                                            @else
                                                Permiso
                                            @endif
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

<!-- Botón flotante solo visible en móviles -->
<a href="#addnew" data-toggle="modal" class="btn btn-primary floating-add-button d-md-none" title="Añadir">
    <i class="mdi mdi-plus"></i>
</a>

@include('includes.add_attendance')
@endsection

@section('script')
    <!-- JS de tabla responsive -->
    <script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>
    <script>
        $(function() {
            $('.table-responsive').responsiveTable({
                addDisplayAllBtn: 'btn btn-secondary'
            });
        });
    </script>
@endsection
