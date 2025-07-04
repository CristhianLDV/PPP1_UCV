@extends('layouts.master')
@section('title', 'Permisos y Licencias')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet"
        type="text/css" media="screen">
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <h4 class="page-title text-left">Permisos</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">Permisos</a></li>
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

                <!-- Botón visible solo en escritorio -->
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
                                    <th data-priority="1">Fecha de Registro</th>
                                    <th data-priority="2">Fecha de Actualización</th>
                                      <th data-priority="3">Fecha Justificada</th> <!-- Nueva columna -->
                                    <th data-priority="3">Dni</th>
                                    <th data-priority="4">Empleado</th>
                                    <th data-priority="5">Concepto</th>
                                    <th data-priority="6">Estado</th>
                                    <th data-priority="7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $leave)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($leave->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->updated_at)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->leave_date)->format('d/m/Y') }}</td>
                                    <td>{{ $leave->employee->dni }}</td>
                                    <td>{{ $leave->employee->name }}</td>
                                    <td>
                                        @if($leave->concept == 1) Personal
                                        @elseif($leave->concept == 2) Particular
                                        @elseif($leave->concept == 3) Salud
                                        @elseif($leave->concept == 4) Fallecimiento
                                        @elseif($leave->concept == 5) Onomástico
                                        @elseif($leave->concept == 6) Compensación
                                        @elseif($leave->concept == 7) A cuentas bancarias
                                        @elseif($leave->concept == 8) Capacitaciones
                                        @elseif($leave->concept == 9) Comisión de servicio
                                        @endif
                                    </td>
                                    <td>
                                        @if($leave->status == 0)
                                            <span class="badge badge-success">Aprobado</span>
                                        @elseif($leave->status == 1)
                                            <span class="badge badge-warning">Pendiente</span>
                                        @elseif($leave->status == 2)
                                            <span class="badge badge-danger">Rechazado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#edit{{ $leave->id }}" data-toggle="modal"
                                           class="btn btn-success btn-sm edit btn-flat">
                                           <i class='fa fa-edit'></i> Editar
                                        </a>
                                        <a href="#delete{{ $leave->id }}" data-toggle="modal"
                                           class="btn btn-danger btn-sm delete btn-flat">
                                           <i class='fa fa-trash'></i> Eliminar
                                        </a>
                                      <a href="{{ route('leave.download', $leave->id) }}" class="btn btn-secondary btn-sm" target="_blank">
                                        <i class="fa fa-download"></i> PDF
                                        </a>


                                    </td>
                                </tr>
                                @includeWhen($leaves->count(), 'includes.edit_delete_leave')
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Botón flotante para móviles -->
<a href="#addnew" data-toggle="modal" class="btn btn-primary floating-add-button d-md-none" title="Añadir">
    <i class="mdi mdi-plus"></i>
</a>

@include('includes.add_leave')
@endsection

@section('script')
    <!-- Responsive-table-->
    <script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>

    @endsection
