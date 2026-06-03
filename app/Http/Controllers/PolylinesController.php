<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolylinesController extends Controller
{
    protected $polylines;

    public function __construct()
    {
        $this->polylines = new polylinesModel();
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'              => 'required|string|max:255',
                'geometry_polyline' => 'required',
                'description'       => 'nullable|string',
                'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'geometry_polyline.required' => 'The geometry polyline field is required.',
                'name.required'              => 'The name field is required.',
            ]
        );

        $name_image = null;

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $name_image = time() . '_polyline.' . $image->getClientOriginalExtension();

            // Simpan ke storage (sama seperti point)
            $image->storeAs('public/images', $name_image);

            // Copy ke public/storage/images agar bisa diakses web server
            $image->move(public_path('storage/images'), $name_image);
        }

        $data = [
            'geom'        => DB::raw("ST_GeomFromText('{$request->geometry_polyline}', 4326)"),
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $name_image,
        ];

        if (!$this->polylines->create($data)) {
            return redirect()->route('peta')->with('error', 'Failed to add polyline!');
        }

        return redirect()->route('peta')->with('success', 'Polyline added successfully!');
    }

    public function edit($id)
    {
        $polyline = $this->polylines->findOrFail($id);

        return view(
            'map-edit-polyline',
            compact('polyline')
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

        $polyline = $this->polylines->findOrFail($id);

        // image lama
        $name_image = $polyline->image;

        // upload image baru
        if ($request->hasFile('image')) {

            // hapus image lama
            if ($polyline->image) {

                $oldImage = public_path(
                    'storage/images/' . $polyline->image
                );

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $image = $request->file('image');

            $name_image =
                time() . '_polyline.' .
                $image->getClientOriginalExtension();

            $image->move(
                public_path('storage/images'),
                $name_image
            );
        }

        // update data
        $polyline->update([

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
                'Polyline updated successfully!'
            );
    }

    public function destroy($id)
    {
        $polyline = $this->polylines->findOrFail($id);

        // Hapus image jika ada
        if ($polyline->image) {
            $imagePath = public_path('storage/images/' . $polyline->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if (!$polyline->delete()) {
            return response()->json(['message' => 'Failed to delete polyline!'], 500);
        }

        return response()->json(['message' => 'Polyline deleted successfully!']);
    }
}
