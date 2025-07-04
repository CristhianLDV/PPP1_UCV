<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Faltas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Reporte de Faltas</h3>
    <table>
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Fecha de Falta</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faltas as $f)
                <tr>
                    <td>{{ $f['empleado'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($f['fecha'])->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align:center;">No se registraron faltas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
