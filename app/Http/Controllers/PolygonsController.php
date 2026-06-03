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

    public function edit($id)
    {
        $polygon = $this->polygons->findOrFail($id);

        return view(
            'map-edit-polygon',
            compact('polygon')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'geometry'    => 'required',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $polygon = $this->polygons->findOrFail($id);

        // image lama
        $name_image = $polygon->image;

        // upload image baru
        if ($request->hasFile('image')) {

            // hapus image lama
            if ($polygon->image) {

                $oldImage = public_path(
                    'storage/images/' . $polygon->image
                );

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $image = $request->file('image');

            $name_image =
                time() . '_polygon.' .
                $image->getClientOriginalExtension();

            $image->move(
                public_path('storage/images'),
                $name_image
            );
        }

        // update data
        $polygon->update([

            'geom' => DB::raw(
                "ST_GeomFromText('{$request->geometry}', 4326)"
            ),

            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $name_image,
        ]);

        return redirect()
            ->route('peta')
            ->with(
                'success',
                'Polygon updated successfully!'
            );
    }

    public function destroy($id)
    {
        $polygon = $this->polygons->findOrFail($id);

        // Hapus image jika ada
        if ($polygon->image) {
            $imagePath = public_path('storage/images/' . $polygon->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if (!$polygon->delete()) {
            return response()->json(['message' => 'Failed to delete polygon!'], 500);
        }

        return response()->json(['message' => 'Polygon deleted successfully!']);
    }
}
