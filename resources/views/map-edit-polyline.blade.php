@extends('layouts.template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <style>
        body {
            background: #fff0f6;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #ff4da6, #ff80bf);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 22px;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            margin-right: 10px;
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover {
            background: white;
            color: #ff4da6 !important;
            border-radius: 8px;
            padding: 6px 12px;
        }

        #map {
            height: 80vh;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            margin-top: 20px;
        }

        .map-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="map-container">
            <h3 style="color:#ff4da6; font-weight:600;">Yogyakarta Maps</h3>
            <div id="map"></div>
        </div>
    </div>

    {{-- ✅ FIX: modal input polyline — hapus duplikat id preview-image-polyline --}}
    <div class="modal" tabindex="-1" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-edit" action="" method="post" enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_polyline" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name_polyline" name="name"
                                placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label for="description_polyline" class="form-label">Description</label>
                            <textarea class="form-control" id="description_polyline" name="description" placeholder="Add description"
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry" name="geometry" placeholder="Add geometry" rows="3" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_polyline" class="form-label">Image</label>
                            {{-- ✅ FIX: id unik untuk input & preview --}}
                            <input class="form-control" type="file" id="image_polyline" name="image"
                                onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image" class="img-thumbnail mt-2" width="400"
                                style="display:none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var map = L.map('map').setView([-7.7956, 110.3695], 12);

        // ✅ FIX: invalidateSize dipindah ke dalam script section
        setTimeout(function() {
            map.invalidateSize();
        }, 100);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: false,
            edit: {
                featureGroup: drawnItems,
                edit: true,
                remove: false
            }
        });

        map.addControl(drawControl);

        map.on('draw:edited', function(e) {

            var layers = e.layers;

            layers.eachLayer(function(layer) {

                // ambil geojson
                var drawnJSONObject = layer.toGeoJSON();

                // convert ke WKT
                var objectGeometry =
                    Terraformer.geojsonToWKT(
                        drawnJSONObject.geometry
                    );

                // ambil properties
                var properties =
                    layer.feature.properties;

                // isi form modal
                $('#name_polyline').val(
                    properties.name
                );

                $('#description_polyline').val(
                    properties.description
                );

                $('#geometry').val(
                    objectGeometry
                );

                // preview image
                if (properties.image) {

                    $('#preview-image')
                        .attr(
                            'src',
                            "{{ asset('storage/images') }}/" +
                            properties.image
                        )
                        .show();
                }

                // set route update
                var updateRoute =
                    "{{ route('polylines.update', ':id') }}";

                updateRoute = updateRoute.replace(
                    ':id',
                    properties.id
                );

                $('#form-edit').attr(
                    'action',
                    updateRoute
                );

                // tampilkan modal
                var modalEdit = new bootstrap.Modal(
                    document.getElementById('modalEdit')
                );

                modalEdit.show();
            });
        });

        // ✅ FIX: show preview image saat file dipilih (show element yg tersembunyi)
        document.getElementById('image_polyline').addEventListener('change', function() {
            var preview = document.getElementById('preview-image-polyline');
            preview.src = window.URL.createObjectURL(this.files[0]);
            preview.style.display = 'block';
        });

        // ✅ FIX: helper untuk build popup content dengan path image yang benar
        function buildPopup(feature, deleteRoute) {

            var img = feature.properties.image &&
                feature.properties.image !== 'null' &&
                feature.properties.image !== null ?

                `<img src="{{ asset('storage/images') }}/${feature.properties.image}"
            class="img-thumbnail" width="300">`

                :
                '<em>No Image</em>';

            return `
        <b>Name:</b> ${feature.properties.name}<br>
        <b>Description:</b> ${feature.properties.description}<br>
        <b>Created:</b> ${feature.properties.created_at}<br>
        <b>Image:</b><br>${img}<br>
        <b>Updated:</b> ${feature.properties.updated_at}<br><br>

        <button
            class="btn btn-warning btn-sm me-2"
            onclick='editData(
    ${feature.properties.id},
    ${JSON.stringify(feature.properties.name)},
    ${JSON.stringify(feature.properties.description ?? '')},
    ${JSON.stringify(feature.properties.image ?? '')},
    ${JSON.stringify(feature.geometry.coordinates)}
)'>
            ✏️ Edit
        </button>

        <button
            class="btn btn-danger btn-sm"
            onclick="deleteFeature('${deleteRoute}')">
            🗑️ Delete
        </button>
    `;
        }

        // Fungsi delete
        function deleteFeature(deleteRoute) {
            if (!confirm('Are you sure want to delete this data?')) return;

            fetch(deleteRoute, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert('Data deleted successfully!');
                    location.reload();
                })
                .catch(err => {
                    alert('Failed to delete data.');
                    console.error(err);
                });
        }

        function editData(id, name, description, image, geometry) {

            var updateRoute =
                "{{ route('polylines.update', ':id') }}";

            updateRoute = updateRoute.replace(':id', id);

            $('#form-edit').attr('action', updateRoute);

            $('#name_polyline').val(name);

            $('#description_polyline').val(description);

            // convert coordinates ke LINESTRING
            var coords = geometry.map(function(coord) {
                return coord[0] + ' ' + coord[1];
            }).join(', ');

            $('#geometry').val(
                `LINESTRING(${coords})`
            );

            // preview image
            if (image && image !== 'null') {

                $('#preview-image')
                    .attr(
                        'src',
                        "{{ asset('storage/images') }}/" + image
                    )
                    .show();

            } else {

                $('#preview-image').hide();
            }

            // tampilkan modal
            var modalEdit = new bootstrap.Modal(
                document.getElementById('modalEdit')
            );

            modalEdit.show();
        }

        // GeoJSON Polyline
        var polylines = L.geoJSON(null, {

            onEachFeature: function(feature, layer) {

                var routeDelete =
                    "{{ route('polylines.delete', ':id') }}";

                routeDelete = routeDelete.replace(
                    ':id',
                    feature.properties.id
                );

                layer.bindPopup(buildPopup(
                    feature,
                    routeDelete
                ));

                layer.feature = feature;

                drawnItems.addLayer(layer);
            }
        });

        fetch("{{ route('geojson.polylines') }}")
            .then(res => res.json())
            .then(data => {
                polylines.clearLayers();
                polylines.addData(data);

                polylines.eachLayer(function(layer) {

                    var feature = layer.feature;

                    var routeDelete =
                        "{{ route('polylines.delete', ':id') }}";

                    routeDelete = routeDelete.replace(
                        ':id',
                        feature.properties.id
                    );

                    layer.bindPopup(
                        buildPopup(feature, routeDelete)
                    );

                    drawnItems.addLayer(layer);
                });

                map.addLayer(polylines);
            });
    </script>
@endsection
