@extends('layouts.master')
@section('title', 'Registros de Tardanza')

@section('css')
<!-- Table css -->
<link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css"
    media="screen">

<style>
    /* Botón flotante para móvil */
    @media (max-width: 768px) {
        .floating-attendance-button {
            position: fixed !important;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            background-color: #007bff;
            color: white;
            border: none;
        }
        .floating-attendance-button:hover {
            background-color: #0056b3;
            color: white;
        }
        .floating-attendance-button i {
            font-size: 28px;
        }
    }
</style>
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Tardanza</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Tardanza</a></li>
    </ol>
</div>
@endsection

@section('button')
<a href="/attendance" class="btn btn-primary btn-sm btn-flat d-none d-md-inline-block">
    <i class="mdi mdi-plus mr-2"></i>Tabla de Asistencia
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
                                    <th data-priority="2">Dni</th>
                                    <th data-priority="3">Nombre</th>
                                    <th data-priority="4">Duración de Tardanza</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latetimes as $latetime)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($latetime->latetime_date)->format('d/m/Y') ?? 'Sin fecha' }}</td>
                                    <td>{{ $latetime->employee?->dni ?? 'Sin DNI' }}</td>
                                    <td>{{ $latetime->employee?->name ?? 'Sin nombre' }}</td>
                                    <td>{{ $latetime->duration ?? 'No calculada' }}</td>
                                   
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

<!-- Botón flotante para móviles que redirige a la tabla de asistencias -->
<a href="/attendance" class="floating-attendance-button d-md-none" title="Tabla de Asistencia">
    <i class="mdi mdi-table"></i>
</a>

@endsection

@section('script')
<!-- Responsive-table-->
<script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>

<script>
    $(function () {
        $('.table-responsive').responsiveTable({
            addDisplayAllBtn: 'btn btn-secondary'
        });
    });
</script>
@endsection
