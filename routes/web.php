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


route::get('/', [PageController::class, 'landingpage'])->name('home');

Route::get('/peta', [PageController::class, 'map'])
    ->middleware(['auth', 'verified'])
    ->name('peta');

route::get('/table', [PageController::class, 'Table'])->name('table');

// ✅ FIX: tambahkan ->name('geojson.points') yang sebelumnya tidak ada
Route::get('/geojson/points', function () {
    $points = DB::table('points')
        ->selectRaw("
        id,
        ST_AsGeoJSON(geom) as geometry,
        name,
        description,
        image,
        created_at,
        updated_at
    ")
        ->get();

    return response()->json([
        'type'     => 'FeatureCollection',
        'features' => $points->map(function ($p) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($p->geometry),
                'properties' => [
                    'id'          => $p->id,
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
    $polylines = DB::table('polylines')
        ->selectRaw("
        id,
        ST_AsGeoJSON(geom) as geometry,
        name,
        description,
        image,
        created_at,
        updated_at
    ")
        ->get();

    return response()->json([
        'type'     => 'FeatureCollection',
        'features' => $polylines->map(function ($p) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($p->geometry),
                'properties' => [
                    'id'          => $p->id,
                    'name'        => $p->name,
                    'description' => $p->description,
                    'image'       => $p->image,
                    'created_at'  => $p->created_at,
                    'updated_at'  => $p->updated_at,
                ]
            ];
        })
    ]);
})->name('geojson.polylines'); // ← INI YANG HILANG

Route::get('/geojson/polygons', function () {

    $polygons = DB::table('polygons')
        ->selectRaw("
            id,
            ST_AsGeoJSON(geom) as geometry,
            name,
            description,
            image,
            created_at,
            updated_at
        ")
        ->get();

    return response()->json([
        'type'     => 'FeatureCollection',
        'features' => $polygons->map(function ($p) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($p->geometry),
                'properties' => [
                    'id'          => $p->id,
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

Route::get(
    '/points/{id}/edit',
    [PointsController::class, 'edit']
)
    ->name('points.edit');

Route::patch(
    '/points/{id}',
    [PointsController::class, 'update']
)
    ->name('points.update');

Route::post('/store-polylines', [PolylinesController::class, 'store'])
    ->name('polylines.store');

Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])
    ->name('polylines.delete');

Route::get(
    '/polylines/{id}/edit',
    [PolylinesController::class, 'edit']
)
    ->name('polylines.edit');

Route::patch(
    '/polylines/{id}',
    [PolylinesController::class, 'update']
)
    ->name('polylines.update');

Route::post('/store-polygons', [PolygonsController::class, 'store'])
    ->name('polygons.store');

Route::delete('/delete-polygons/{id}', [PolygonsController::class, 'destroy'])
    ->name('polygons.delete');

Route::get(
    '/polygons/{id}/edit',
    [PolygonsController::class, 'edit']
)
    ->name('polygons.edit');

Route::patch(
    '/polygons/{id}',
    [PolygonsController::class, 'update']
)
    ->name('polygons.update');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/settings.php';
