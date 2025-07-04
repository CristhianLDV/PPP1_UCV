@extends('layouts.master')
@section('title', 'Reporte de Faltas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Faltas detectadas</h4>
    <div>
        <a href="{{ url()->current() }}" class="btn btn-outline-primary btn-sm">Actualizar reporte</a>
        <a href="{{ route('faltas.downloadPdf') }}" class="btn btn-success btn-sm">Descargar PDF</a>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary btn-sm">Volver a asistencias</a>
    </div>
</div>

<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Empleado</th>
            <th>Fecha de Falta</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($faltas as $f)
            <tr>
                <td>{{ $f['empleado'] }}</td>
                <td>{{ \Carbon\Carbon::parse($f['fecha'])->format('d/m/Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">No se encontraron faltas.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
