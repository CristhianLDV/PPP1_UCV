@extends('layouts.master')
@section('title', 'Reporte de Asistencia')

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Reporte de Asistencia</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="#">Reportes</a></li>
        <li class="breadcrumb-item active">Asistencia</li>
    </ol>
</div>
@endsection

@section('content')
@include('includes.flash')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                {{-- FILTROS --}}
                <form method="GET" action="{{ route('sheet-report') }}" class="row mb-4">
                    <div class="col-md-3">
                        <label>Empleado</label>
                        <select name="emp_id" class="form-control">
                            <option value="">-- Todos --</option>
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}" {{ request('emp_id') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Servicio</label>
                        <select name="service_id" class="form-control">
                            <option value="">-- Todos --</option>
                            @foreach ($services as $srv)
                                <option value="{{ $srv->id }}" {{ request('service_id') == $srv->id ? 'selected' : '' }}>
                                    {{ $srv->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Estado</label>
                        <select name="status" class="form-control">
                            <option value="">-- Todos --</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Presente</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Ausente</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Tipo</label>
                        <select name="type" class="form-control">
                            <option value="">-- Todos --</option>
                            <option value="1" {{ request('type') === '1' ? 'selected' : '' }}>Entrada</option>
                            <option value="0" {{ request('type') === '0' ? 'selected' : '' }}>Salida</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Desde</label>
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Hasta</label>
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                    </div>
                        <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="mdi mdi-filter"></i> Filtrar
                    </button>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('attendance.export.excel', request()->all()) }}" class="btn btn-success w-100">
                        <i class="mdi mdi-file-excel"></i> Excel
                    </a>
                </div>

        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('attendance.export.pdf', request()->all()) }}" class="btn btn-danger w-100" target="_blank">
                <i class="mdi mdi-file-pdf"></i> PDF
            </a>
        </div>
        </form>

                {{-- RESUMEN --}}
                <div class="mb-3">
                    <strong>Total registros:</strong> {{ $attendances->count() }} |
                    <strong>Entradas:</strong> {{ $attendances->where('type', 1)->count() }} |
                    <strong>Salidas:</strong> {{ $attendances->where('type', 0)->count() }} |
                    <strong>Presentes:</strong> {{ $attendances->where('status', 1)->count() }} |
                    <strong>Ausentes:</strong> {{ $attendances->where('status', 0)->count() }}
                </div>

                {{-- TABLA --}}
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-bordered table-hover text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>Empleado</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Tardanza</th>
                                <th>Horas Extras</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $a)
                                <tr>
                                    <td>{{ $a->employee->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->attendance_date)->format('d/m/Y') }}</td>
                                    <td>{{ $a->attendance_time }}</td>

                                    <td>
                                    @php
                                        $badgeClass = 'secondary';
                                        $typeLabel = 'Desconocido';

                                        if ($a->type === 1) {
                                            $badgeClass = 'primary';
                                            $typeLabel = 'Entrada';
                                        } elseif ($a->type === 0) {
                                            $badgeClass = 'info';
                                            $typeLabel = 'Salida';
                                        } elseif ($a->type === 2) {
                                            $badgeClass = 'warning';
                                            $typeLabel = 'Permiso';
                                        }
                                    @endphp

                                    <span class="badge badge-{{ $badgeClass }}">{{ $typeLabel }}</span>
                                </td>


                                    <td>
                                    @if ($a->type == 1)
                                        @if ($a->status == 1)
                                            <span class="badge badge-success">✔ a tiempo</span>
                                        @else
                                            <span class="badge badge-danger">✖ tarde</span>
                                        @endif
                                    @elseif ($a->type == 0)
                                        @if ($a->status == 1)
                                            <span class="badge badge-success">✔ a tiempo</span>
                                        @else
                                            <span class="badge badge-danger">tiempo extra</span>
                                        @endif
                                    @endif
                                </td>
                                    <td>
                                        @php
                                            $late = $a->type == 1 ? \App\Models\Latetime::where('emp_id', $a->emp_id)
                                                ->whereDate('latetime_date', $a->attendance_date)
                                                ->first() : null;
                                        @endphp
                                        {{ $late ? $late->duration : '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $extra = $a->type == 0 ? \App\Models\Overtime::where('emp_id', $a->emp_id)
                                                ->whereDate('overtime_date', $a->attendance_date)
                                                ->first() : null;
                                        @endphp
                                        {{ $extra ? $extra->duration : '-' }}
                                    </td>
                                    

                                </tr>
                            @empty
                                <tr>
                                    
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

 
            </div>
        </div>
    </div>
</div>
@endsection
