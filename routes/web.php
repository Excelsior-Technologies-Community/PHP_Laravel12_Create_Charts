<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Chart Example Route
|--------------------------------------------------------------------------
*/

Route::get('/chart', [ChartController::class, 'sampleChart'])
     ->name('chart.sample');
Route::get('/monthly-sales-orders', [ChartController::class, 'monthlySalesOrders']);