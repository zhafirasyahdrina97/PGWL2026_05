<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    protected $points;

    public function __construct()
    {
        $this->points = new pointsModel();
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'           => 'required|string|max:255',
                'geometry_point' => 'required',
                'description'    => 'nullable|string',
                'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'geometry_point.required' => 'The geometry point field is required.',
                'name.required'           => 'The name field is required.',
            ]
        );

        // HANDLE UPLOAD IMAGE
        $name_image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . '_point.' . $image->getClientOriginalExtension();

            // Simpan ke storage (existing)
            $image->storeAs('public/images', $name_image);

            // ✅ Copy juga ke public/storage/images agar bisa diakses web server
            $image->move(public_path('storage/images'), $name_image);
        }

        // ✅ FIX: Form mengirim WKT (dari Terraformer), bukan GeoJSON
        //         Gunakan ST_GeomFromText(), bukan ST_GeomFromGeoJSON()
        //         Tambahkan SRID 4326 agar koordinat GPS terbaca benar
        $data = [
            'geom'        => DB::raw("ST_GeomFromText('{$request->geometry_point}', 4326)"),
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $name_image,
        ];

        if (!$this->points->create($data)) {
            return redirect()->route('peta')->with('error', 'Failed to add point!');
        }

        return redirect()->route('peta')->with('success', 'Point added successfully!');
    }
}
