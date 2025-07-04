@extends('layouts.master')
@section('title', 'Programación de Trabajo')

@section('css')
<style>
    [id^="employeeCalendar"] {
        min-height: 400px;
        max-height: 80vh;
        overflow-y: auto;
    }

    table.dataTable {
        width: 100% !important;
    }

    @media (max-width: 768px) {
        .modal-xl {
            max-width: 100%;
            margin: 0;
        }

        .modal-body,
        .modal-header,
        .modal-footer {
            padding: 10px;
        }
    }

    .fc-event {
        font-size: 12px;
        padding: 2px 4px;
        cursor: pointer;
    }

    .calendar-loader {
        text-align: center;
        padding: 20px;
    }

    .fc-highlight {
        background-color: #007bff !important;
        opacity: 0.3;
    }
</style>
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Programación de Horarios</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="#">Programación de Horarios</a></li>
        <li class="breadcrumb-item active">Lista de Empleados</li>
    </ol>
</div>
@endsection

@section('content')

{{-- Mensajes con SweetAlert --}}
@include('includes.flash')

{{-- Errores de validación con SweetAlert --}}
@if ($errors->any())
    <script>
        swal({
            title: "Errores encontrados",
            text: `{!! implode('\n', $errors->all()) !!}`,
            icon: "error",
            button: true
        });
    </script>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Posición</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr data-employee-id="{{ $employee->id }}">
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->dni }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-warning btn-sm"
                                        data-toggle="modal"
                                        data-target="#calendarModal{{ $employee->id }}"
                                        title="Ver calendario de {{ $employee->name }}">
                                    <i class="fa fa-calendar"></i> Calendario
                                </button>
                                <a href="{{ route('employee.calendar.pdf', $employee->id) }}" class="btn btn-info btn-sm" target="_blank" title="Generar reporte PDF">
                                    <i class="fa fa-file-pdf"></i> Reporte PDF
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('includes.employee_calendar')
@include('includes.work_day')
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/es.global.min.js"></script>

<script>
$(document).ready(function() {
    function initCalendar(employeeId, calendarId) {
        const calendarEl = document.getElementById(calendarId);
        if (!calendarEl) {
            console.error('Elemento del calendario no encontrado:', calendarId);
            return;
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            selectable: true,
            selectMirror: true,
            selectOverlap: false,
            weekends: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                list: 'Lista'
            },
            events: {
                url: `/employee/schedule/${employeeId}`,
                failure: function() {
                    alert('Error al cargar los eventos del calendario');
                }
            },
            loading: function(bool) {
                $(calendarEl).find('.calendar-loader').toggle(bool);
            },
            select: function(info) {
                $('#modalEmployeeId').val(employeeId);
                $('#modalWorkDate').val(info.startStr + '|' + info.endStr);

                const startDate = new Date(info.startStr);
                const endDate = new Date(info.endStr);
                endDate.setDate(endDate.getDate() - 1);

                const formatDate = date =>
                    date.toLocaleDateString('es-ES', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                const datesText = (startDate.getTime() === endDate.getTime())
                    ? formatDate(startDate)
                    : `${formatDate(startDate)} al ${formatDate(endDate)}`;

                $('#selectedDatesInput').val(datesText);
                $('#schedule, #task_description').val('');
                $('#workDayModal').modal('show');
            },
            eventDidMount: function(info) {
                info.el.title = info.event.title;
                info.el.classList.add('custom-event');
            },
            eventClick: function(info) {
                if (confirm(`¿Eliminar el evento: ${info.event.title}?`)) {
                    $.ajax({
                        url: `/employee/schedule/${info.event.id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function() {
                            info.event.remove();
                            showAlert('success', 'Evento eliminado correctamente');
                        },
                        error: function() {
                            showAlert('danger', 'No se pudo eliminar el evento');
                        }
                    });
                }
            }
        });

        calendar.render();
        return calendar;
    }

    $('div[id^="calendarModal"]').on('shown.bs.modal', function() {
        const modalId = $(this).attr('id');
        const employeeId = modalId.replace('calendarModal', '');
        const calendarId = `employeeCalendar${employeeId}`;

        if (!$(this).data('calendar-initialized')) {
            const calendar = initCalendar(employeeId, calendarId);
            $(this).data('calendar-initialized', true);
            $(this).data('calendar-instance', calendar);
        } else {
            const calendar = $(this).data('calendar-instance');
            calendar?.refetchEvents();
        }
    });

    $('#workDayForm').on('submit', function(e) {
        e.preventDefault();
        const $submitBtn = $('#saveWorkDayBtn');
        const originalText = $submitBtn.html();

        $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i>Guardando...');

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#workDayModal').modal('hide');
                showAlert('success', response.message || 'Días de trabajo agregados correctamente');

                const openModal = $('.modal[id^="calendarModal"]:visible');
                const calendar = openModal.data('calendar-instance');
                calendar?.refetchEvents();
            },
            error: function(xhr) {
                let errorMessage = 'Error al guardar los días de trabajo';

                if (xhr.responseJSON?.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorMessage = errors.join('<br>');
                } else if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showAlert('danger', errorMessage);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    $('#workDayModal').on('hidden.bs.modal', function() {
        $('#workDayForm')[0].reset();
        $('#modalEmployeeId, #modalWorkDate, #selectedDatesInput').val('');
    });

    function showAlert(type, message) {
        const icon = type === 'danger' ? 'error' : type;
        swal({
            title: type === 'success' ? '¡Éxito!' : 'Aviso',
            text: message,
            icon: icon,
            timer: 3000,
            buttons: false
        });
    }
});
</script>
@endsection
