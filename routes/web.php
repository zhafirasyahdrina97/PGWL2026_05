<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/peta', [PageController::class, 'map'])->name('peta');

Route::get('/table', [PageController::class, 'table'])->name('table');

Route::post('/store-points', [PointsController::class, 'store'])
->name('points.store');

Route::post('/store-polylines', [PolylinesController::class, 'store'])
->name('polylines.store');

Route::post('/store-polygons', [PolygonsController::class, 'store'])
->name('polygons.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
->name('dashboard');

require __DIR__.'/settings.php';
