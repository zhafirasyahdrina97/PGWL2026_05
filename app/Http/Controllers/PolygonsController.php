<?php

namespace App\Http\Controllers;

use App\Models\polygonsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolygonsController extends Controller
{
    protected $polygons;

    public function __construct()
    {
        $this->polygons = new polygonsModel();
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'              => 'required|string|max:255',
                'geometry_polygon' => 'required',
                'description'       => 'nullable|string',
                'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'geometry_polygon.required' => 'The geometry polygon field is required.',
                'name.required'              => 'The name field is required.',
            ]
        );

        // HANDLE UPLOAD IMAGE
        $name_image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . '_polygon.' . strtolower($image->getClientOriginalExtension());

            // Simpan ke storage/app/public/images
            $image->storeAs('public/images', $name_image);

            // ✅ Copy juga ke public/storage/images agar bisa diakses web server di Windows
            $image->move(public_path('storage/images'), $name_image);
        }

        // ✅ FIX: geom harus dikonversi dari WKT ke spatial column pakai ST_GeomFromText
        //         Sebelumnya geom diisi string WKT mentah → tidak tersimpan sebagai geometry
        $data = [
            'geom'        => DB::raw("ST_GeomFromText('{$request->geometry_polygon}', 4326)"),
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $name_image,
        ];

        if (!$this->polygons->create($data)) {
            return redirect()->route('peta')->with('error', 'Failed to add polygon!');
        }

        return redirect()->route('peta')->with('success', 'Polygon added successfully!');
    }
}
