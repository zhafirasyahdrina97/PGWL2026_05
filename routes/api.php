<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Geojson API
Route::get('/points', [ApiController::class, 'geojson_points'])
->name('geojson.points');

//Geojson API
Route::get('/polylines', [ApiController::class, 'geojson_polylines'])
->name('geojson.polylines');

//Geojson API
Route::get('/polygons', [ApiController::class, 'geojson_polygons'])
->name('geojson.polygons');
