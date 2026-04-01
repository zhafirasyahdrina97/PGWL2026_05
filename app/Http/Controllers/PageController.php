<?php

namespace App\Http\Controllers;


class PageController extends Controller
{
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
        ];

        return view('table', $data);
    }
}
