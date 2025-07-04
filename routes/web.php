<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    AdminController,
    AttendanceController,
    CheckController,
    EmployeeController,
    LeaveController,
    ScheduleController,
    ServiceController,
    UserController,
    WorkScheduleController,
    ReportController,
    FaltasController
};

// Página principal
Route::get('/', fn() => view('welcome'))->name('welcome');

// Autenticación
Auth::routes(['register' => false, 'reset' => false]);

// Logout manual
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Panel de administración
Route::get('admin', [AdminController::class, 'index'])->name('admin');

// Usuarios y empleados
Route::resource('employees', EmployeeController::class);
Route::resource('users', UserController::class);

// Servicios y horarios
Route::resource('services', ServiceController::class);
Route::resource('schedule', ScheduleController::class);
Route::resource('work-schedule', WorkScheduleController::class)->only(['index']);

// Asistencia y Permisos
Route::resource('attendance', AttendanceController::class);
Route::resource('leave', LeaveController::class);

// Llegadas tardías
Route::get('latetime', [AttendanceController::class, 'indexLatetime'])->name('indexLatetime');

// Horas extras (opcional: mover a su propio controlador si crece)
Route::get('overtime', [LeaveController::class, 'indexOvertime'])->name('indexOvertime');

// Reportes
Route::prefix('reportes')->group(function () {
    Route::get('faltas', [ReportController::class, 'mostrarFaltas'])->name('reporte.faltas');

    Route::get('asistencia/export-excel', [CheckController::class, 'exportExcel'])->name('attendance.export.excel');
    Route::get('asistencia/export-pdf', [CheckController::class, 'exportPDF'])->name('attendance.export.pdf');
});

// Check (asistencia con QR)
Route::resource('check', CheckController::class);
Route::post('check-store', [CheckController::class, 'CheckStore'])->name('check_store');
Route::get('sheet-report', [CheckController::class, 'sheetReport'])->name('sheet-report');
 Route::get('attended/{user_id}', [AttendanceController::class, 'attended'])->name('attended');

// PDF de Permisos
Route::get('leave/download/{id}', [LeaveController::class, 'downloadPDF'])->name('leave.download');
// Faltas
Route::get('/faltas/download-pdf', [FaltasController::class, 'downloadPdf'])->name('faltas.downloadPdf');



// Perfil
Route::get('/perfil', [UserController::class, 'showProfile'])->name('perfil')->middleware('auth');

// Funciones con calendario de programación
Route::prefix('employee')->group(function () {
    Route::post('/schedule/store', [WorkScheduleController::class, 'store'])->name('employee.schedule.store');
    Route::get('/schedule/{id}', [WorkScheduleController::class, 'getEmployeeSchedule']);
    Route::delete('/schedule/{id}', [WorkScheduleController::class, 'destroy'])->name('employee.schedule.destroy');

    // QR del empleado
    Route::get('/{id}/qr', [EmployeeController::class, 'showQR'])->name('employee.qr');
    Route::get('/{id}/qr/download-image', [EmployeeController::class, 'downloadQrPng'])->name('employee.qr.download.image');

    // Reporte de programación del empleado
    Route::get('/{id}/calendar-report', [EmployeeController::class, 'generateCalendarPdf'])->name('employee.calendar.pdf');
});
