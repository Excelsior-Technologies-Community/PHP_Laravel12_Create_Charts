<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');
Route::get('/charts/create', [ChartController::class, 'create'])->name('charts.create');
Route::post('/charts', [ChartController::class, 'store'])->name('charts.store');
Route::get('/charts/{chart}/edit', [ChartController::class, 'edit'])->name('charts.edit');
Route::put('/charts/{chart}', [ChartController::class, 'update'])->name('charts.update');
Route::delete('/charts/{chart}', [ChartController::class, 'destroy'])->name('charts.destroy');
Route::get('/api/charts', [ChartController::class, 'apiCharts']);
Route::get('/charts/{chart}', [ChartController::class, 'show']);
