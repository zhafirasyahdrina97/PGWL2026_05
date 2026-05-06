<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use App\Models\pointsModel;
use App\Models\polygonsModel;
use App\Models\polylinesModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// ✅ FIX: tambahkan ->name('geojson.points') yang sebelumnya tidak ada
Route::get('/geojson/points', function () {
    $points = DB::table('points')
        ->selectRaw("ST_AsGeoJSON(geom) as geometry, name, description, image, created_at, updated_at")
        ->get();

    return response()->json([
        'type'     => 'FeatureCollection',
        'features' => $points->map(function ($p) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($p->geometry),
                'properties' => [
                    'name'        => $p->name,
                    'description' => $p->description,
                    'image'       => $p->image,
                    'created_at'  => $p->created_at,
                    'updated_at'  => $p->updated_at,
                ]
            ];
        })
    ]);
})->name('geojson.points'); // ← INI YANG HILANG

Route::get('/geojson/polylines', function () {
    // ✅ FIX: pakai DB::table + ST_AsGeoJSON agar geometry terbaca (sama seperti points)
    $polylines = DB::table('polylines')
        ->selectRaw("ST_AsGeoJSON(geom) as geometry, name, description, image, created_at, updated_at")
        ->get();

    return response()->json([
        'type'     => 'FeatureCollection',
        'features' => $polylines->map(function ($p) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($p->geometry),
                'properties' => [
                    'name'        => $p->name,
                    'description' => $p->description,
                    'image'       => $p->image,
                    'created_at'  => $p->created_at,
                    'updated_at'  => $p->updated_at,
                ]
            ];
        })
    ]);
})->name('geojson.polylines');

Route::get('/geojson/polygons', function () {
    // ✅ FIX: pakai DB::table + ST_AsGeoJSON agar geometry terbaca (sama seperti points)
    $polygons = DB::table('polygons')
        ->selectRaw("ST_AsGeoJSON(geom) as geometry, name, description, image, created_at, updated_at")
        ->get();

    return response()->json([
        'type'     => 'FeatureCollection',
        'features' => $polygons->map(function ($p) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($p->geometry),
                'properties' => [
                    'name'        => $p->name,
                    'description' => $p->description,
                    'image'       => $p->image,
                    'created_at'  => $p->created_at,
                    'updated_at'  => $p->updated_at,
                ]
            ];
        })
    ]);
})->name('geojson.polygons');

Route::get('/peta', [PageController::class, 'map'])->name('peta');

Route::get('/table', [PageController::class, 'table'])->name('table');

Route::post('/store-points', [PointsController::class, 'store'])
    ->name('points.store');

Route::delete('/delete-points/{id}', [PointsController::class, 'destroy'])
    ->name('points.delete');

Route::post('/store-polylines', [PolylinesController::class, 'store'])
    ->name('polylines.store');

Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])
    ->name('polylines.delete');

Route::post('/store-polygons', [PolygonsController::class, 'store'])
    ->name('polygons.store');

Route::delete('/delete-polygons/{id}', [PolygonsController::class, 'destroy'])
    ->name('polygons.delete');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/settings.php';
