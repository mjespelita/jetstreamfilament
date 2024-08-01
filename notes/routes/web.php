<?php

use App\Http\Controllers\ExportReport as ControllersExportReport;
use App\Http\Middleware\MasterMiddleware;
use App\Livewire\ExportReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware(MasterMiddleware::class);

    Route::get('/export-report', ExportReport::class);
    Route::get('/export-report-process', [ControllersExportReport::class, 'exportReportProcess']);
});
