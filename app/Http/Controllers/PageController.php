<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use App\Models\polygonsModel;
use App\Models\polylinesModel;
use App\Models\User;


class PageController extends Controller
{
    public function landingpage()
    {
        $data = [
            'title' => 'PGWL',

            // statistik data
            'totalPoints' => pointsModel::count(),
            'totalPolylines' => polylinesModel::count(),
            'totalPolygons' => polygonsModel::count(),
            'totalUsers' => User::count(),
        ];

        return view('home', $data);
    }

    public function Map()
    {
        $data = [
            'title' => 'Map',
        ];

        return view('map', $data);
    }

    public function Table()
    {
        $data = [
            'title' => 'Table',
            'points' => pointsModel::all(),
            'polylines' => polylinesModel::all(),
            'polygons' => polygonsModel::all(),
        ];

        return view('table', $data);
    }
}
