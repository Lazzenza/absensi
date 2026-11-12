<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Presensi Harian (Check-in, Check-out, Form Presensi Khusus)
    Route::get('/presensi', [AttendanceController::class, 'create'])->name('attendances.create');

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::post('/attendances/{attendance}/approve', [AttendanceController::class, 'approve'])->name('attendances.approve');
    Route::post('/attendances/{attendance}/reject', [AttendanceController::class, 'reject'])->name('attendances.reject');
    Route::get('/attendances/report/pdf', [AttendanceController::class, 'downloadReport'])->name('attendances.report.pdf');
    Route::get('/attendances/report/csv', [AttendanceController::class, 'exportCsv'])->name('attendances.report.csv');

    // Laporan & Pratinjau
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/preview', [\App\Http\Controllers\ReportController::class, 'previewPdf'])->name('reports.preview');
    Route::get('/reports/user/{user}', [\App\Http\Controllers\ReportController::class, 'userDetail'])->name('reports.user.detail');
});
