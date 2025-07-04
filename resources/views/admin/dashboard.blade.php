@extends('layouts.master')
@section('title', 'Panel de Control')

@section('css')
<!-- Chart.js no necesita CSS adicional -->
@endsection

@section('breadcrumb')
<div class="col-sm-6 text-left">
    <h4 class="page-title">Dashboard</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Bienvenido al sistema de gestión de asistencia del Centro Médico Tambogrande</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    @php
        $cards = [
            ['icon' => 'ti-id-badge', 'label' => 'Total Empleados', 'value' => $data['totalEmpleados'], 'iconBig' => 'ti-user'],
            ['icon' => 'ti-alarm-clock', 'label' => 'A Tiempo Porcentaje', 'value' => $data['porcentajePuntualidad'] . '%', 'iconBig' => 'ti-pie-chart'],
            ['icon' => 'ti-check-box', 'label' => 'A Tiempo Hoy', 'value' => $data['aTiempoHoy'], 'iconBig' => 'ti-check'],
            ['icon' => 'ti-alert', 'label' => 'Tarde Hoy', 'value' => $data['tardeHoy'], 'iconBig' => 'ti-timer'],
            ['icon' => 'ti-close', 'label' => 'Faltas Hoy', 'value' => $data['faltasHoy'], 'iconBig' => 'ti-na'],
        ];
    @endphp

    @foreach($cards as $card)
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-left mini-stat-img mr-4">
                        <i class="{{ $card['icon'] }}" style="font-size: 20px"></i>
                    </div>
                    <h6 class="font-16 text-uppercase mt-0 text-white-50">{{ $card['label'] }}</h6>
                    <h4 class="font-500">{{ $card['value'] }}</h4>
                    <span class="{{ $card['iconBig'] }}" style="font-size: 64px; opacity: 0.2; float: right;"></span>
                </div>
                <div class="pt-2">
                    <div class="float-right">
                        <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                    </div>
                    <p class="text-white-50 mb-0">Más información</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt-4">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Asistencia por Día (Últimos 7 días)</h5>
                <canvas id="attendanceChart" height="200"></canvas>
                <div class="text-center mt-3">
                    <span class="badge badge-pill bg-danger">Total</span>
                    <span class="badge badge-pill bg-success">A Tiempo</span>
                    <span class="badge badge-pill bg-warning">Tarde</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Resumen General</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Asistencias Hoy
                        <span class="badge badge-success badge-pill">{{ $data['aTiempoHoy'] + $data['tardeHoy'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Porcentaje Puntualidad
                        <span class="badge badge-info badge-pill">{{ $data['porcentajePuntualidad'] }}%</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Empleados Registrados
                        <span class="badge badge-primary badge-pill">{{ $data['totalEmpleados'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Faltas Hoy
                        <span class="badge badge-danger badge-pill">{{ $data['faltasHoy'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Asistencia Mensual (Total por Mes)</h5>
                <canvas id="monthlyAttendanceChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels ?? ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom']) !!},
            datasets: [
                {
                    label: 'Total',
                    data: {!! json_encode($series['Total'] ?? [5, 8, 7, 6, 4, 5, 6]) !!},
                    borderColor: '#d70206',
                    backgroundColor: 'rgba(215,2,6,0.2)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'A Tiempo',
                    data: {!! json_encode($series['A Tiempo'] ?? [4, 6, 6, 5, 3, 4, 5]) !!},
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Tarde',
                    data: {!! json_encode($series['Tarde'] ?? [1, 2, 1, 1, 1, 1, 1]) !!},
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.2)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    enabled: true
                },
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endsection
