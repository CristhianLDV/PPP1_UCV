<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .org-name {
            font-size: 18px;
            font-weight: bold;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        .summary-table { width: 50%; margin: 0 auto; }
    </style>
</head>
<body>

    <div class="header">
        <div class="org-name">Centro Médico Tambogrande</div>
        <div class="report-title">Reporte Detallado de Asistencia</div>
    </div>

    <p><strong>Generado:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    @if(request('emp_id'))
        <p><strong>Empleado:</strong> {{ $attendances->first()->employee->name ?? 'N/A' }}</p>
    @else
        <p><strong>Empleado:</strong> Todos</p>
    @endif

    @if(request('from') && request('to'))
        <p><strong>Rango de fechas:</strong> {{ request('from') }} - {{ request('to') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Empleado</th>
                <th>Posición</th>
                <th>Tardanza</th>
                <th>Horas Extras</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $a)
                @php
                    $late = $a->type == 1 ? \App\Models\Latetime::where('emp_id', $a->emp_id)
                        ->whereDate('latetime_date', $a->attendance_date)
                        ->first() : null;

                    $extra = $a->type == 0 ? \App\Models\Overtime::where('emp_id', $a->emp_id)
                        ->whereDate('overtime_date', $a->attendance_date)
                        ->first() : null;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($a->attendance_date)->format('d/m/Y') }}</td>
                    <td>{{ $a->attendance_time }}</td>
                    <td>
                        @switch($a->type)
                            @case(1) Entrada @break
                            @case(0) Salida @break
                            @case(2) Permiso @break
                            @default Otro
                        @endswitch
                    </td>
                    <td>
                            @if($a->status == 1)
                                A tiempo
                            @elseif($a->status == 2)
                                Permiso
                            @elseif($a->status == 0)
                                Tarde
                            @else
                                Ausente
                            @endif
                        </td>
                    <td>{{ $a->employee->name ?? 'N/A' }}</td>
                    <td>{{ $a->employee->position ?? 'N/A' }}</td>
                    <td>{{ $late->duration ?? '-' }}</td>
                    <td>{{ $extra->duration ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="text-align:center;">Resumen por Tipo y Estado</h4>

    <table class="summary-table">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances->groupBy(['type', 'status']) as $type => $states)
                @foreach ($states as $status => $items)
                    <tr>
                        <td>
                            @switch($type)
                                @case(1) Entrada @break
                                @case(0) Salida @break
                                @case(2) Permiso @break
                                @default Otro
                            @endswitch
                        </td>
                        <td>
                            @if($status == 1)
                                A tiempo
                            @elseif($status == 2)
                                Permiso
                            @else
                                Tarde
                            @endif
                        </td>
                        <td>{{ count($items) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>
