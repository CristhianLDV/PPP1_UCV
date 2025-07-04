@extends('layouts.master')
@section('title', 'Código QR de Empleado')

@section('css')
    <style>
        .qr-panel {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            margin-top: 30px;
        }
        .qr-card, .attendance-table {
            flex: 1;
            min-width: 300px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }
        .qr-card h4, .attendance-table h4 {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .qr-code-container {
            text-align: center;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .btn-download {
            margin-top: 15px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="qr-panel">
        <!-- QR CODE -->
        <div class="qr-card">
            
                <h4 class="text-center">
                {{ $employee->name }} <br>
                <small class="text-muted">{{ $employee->dni }} | {{ $employee->position ?? 'Sin puesto' }}</small>
            </h4>

            <div class="qr-code-container">
                {!! $qr !!}
                
                <p class="text-muted small mt-2">Escanea este código para verificar</p>
            </div>
            <a href="{{ route('employee.qr.download.image', $employee->id) }}" class="btn btn-success">
                <i class="fas fa-download mr-1"></i> Descargar QR como Imagen
            </a>
            
          <a href="{{ route('employees.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Volver a Lista de Empleados
            </a>
 
        </div>


        <!-- ASISTENCIAS -->
        <div class="attendance-table">
            <h4 class="text-center">Mis Asistencias</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employee->attendances as $attendance)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d/m/Y') }}</td>
                                <td>{{ $attendance->attendance_time }}</td>
                                <td>
                                    {{ $attendance->type === 1 ? 'Entrada' : ($attendance->type === 0 ? 'Salida' : 'Permiso') }}
                                </td>
                        
                                <td>
                                    @if ($attendance->type == 2)
                                        <span class="badge badge-info">Permiso</span>
                                    @elseif ($attendance->status == 1)
                                        <span class="badge badge-success">A tiempo</span>
                                    @else
                                        <span class="badge badge-danger">Tarde</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Sin registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
