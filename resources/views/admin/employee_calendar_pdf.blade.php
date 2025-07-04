
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario Laboral - {{ $employee->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="title">Reporte de Programación de Trabajo</div>

    <p><strong>Empleado:</strong> {{ $employee->name }}</p>
    <p><strong>DNI:</strong> {{ $employee->dni }}</p>
    <p><strong>Posición:</strong> {{ $employee->position }}</p>

<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Fecha Programada</th>
            <th>Horario</th>
            <th>Servicio</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($workSchedules as $schedule)
            <tr>
                <td>{{ \Carbon\Carbon::parse($schedule->work_date)->format('d/m/Y') }}</td>
                <td>
                    {{ $schedule->schedule->slug }} 
                    ({{ \Carbon\Carbon::parse($schedule->schedule->time_in)->format('H:i') }} - 
                     {{ \Carbon\Carbon::parse($schedule->schedule->time_out)->format('H:i') }})
                </td>
                <td>{{ $schedule->service->name ?? 'No asignado' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<br><br>
<h4>Resumen por Servicio</h4>
<table border="1" width="50%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Servicio</th>
            <th>Total de días programados</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($serviceSummary as $service => $count)
            <tr>
                <td>{{ $service ?? 'No asignado' }}</td>
                <td>{{ $count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>



</body>
</html>
