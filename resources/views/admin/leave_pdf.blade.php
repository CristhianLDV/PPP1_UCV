<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Permiso Justificado - Centro Médico Tambogrande</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header h3 {
            margin: 0;
            font-size: 14px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section p {
            margin: 4px 0;
        }

        .conceptos ul {
            list-style: none;
            padding-left: 0;
        }

        .conceptos li {
            margin-bottom: 3px;
        }

        .firmas-container {
            margin-top: 60px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .firma {
            width: 30%;
        }

        .linea {
            border-top: 1px solid black;
            margin: 60px auto 4px auto;
            height: 1px;
            width: 80%;
        }

        .nombre-firma {
            font-weight: bold;
        }

    </style>
</head>
<body>

    <div class="header">
        <h1>Centro Médico Tambogrande - EsSalud</h1>
        <h3>Formato de Permiso Justificado</h3>
    </div>

    <div class="section">
        <p><strong>Nombre del Trabajador:</strong> {{ $leave->employee->name }}</p>
        <p><strong>DNI:</strong> {{ $leave->employee->dni }}</p>
        <p><strong>Fecha del Permiso:</strong> {{ \Carbon\Carbon::parse($leave->leave_date)->format('d/m/Y') }}</p>
        <p><strong>Fecha de Registro:</strong> {{ \Carbon\Carbon::parse($leave->created_at)->format('d/m/Y') }}</p>
    </div>

    <div class="section conceptos">
        <p><strong>Concepto del Permiso:</strong></p>
        <ul>
            @php
                $conceptos = [
                    1 => 'Personal',
                    2 => 'Particular',
                    3 => 'Salud',
                    4 => 'Fallecimiento',
                    5 => 'Onomástico',
                    6 => 'Compensación',
                    7 => 'A cuentas bancarias',
                    8 => 'Capacitaciones',
                    9 => 'Comisión de servicio'
                ];
            @endphp

            @foreach ($conceptos as $key => $nombre)
                <li>
                    @if ($leave->concept == $key)
                        ✔ {{ $nombre }}
                    @else
                        ☐ {{ $nombre }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <p><strong>Estado del Permiso:</strong>
            @if($leave->status == 0) Aprobado
            @elseif($leave->status == 1) Pendiente
            @elseif($leave->status == 2) Rechazado
            @endif
        </p>
    </div>

    <!-- FIRMAS EN TRES COLUMNAS: izquierda, centro y derecha -->
    <div class="firmas-container">
        <div class="firma">
            <div class="linea"></div>
            <div class="nombre-firma">Jefe de Personal</div>
        </div>
        <div class="firma">
            <div class="linea"></div>
            <div class="nombre-firma">Jefe Inmediato</div>
        </div>
        <div class="firma">
            <div class="linea"></div>
            <div class="nombre-firma">Supervisor</div>
        </div>
    </div>

</body>
</html>
