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

    {{-- ✅ FIX: modal input point — hapus duplikat id preview-image-point --}}
    <div class="modal" tabindex="-1" id="modalInputPoint">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('points.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_point" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name_point" name="name"
                                placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label for="description_point" class="form-label">Description</label>
                            <textarea class="form-control" id="description_point" name="description" placeholder="Add description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry_point" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_point" name="geometry_point" placeholder="Add geometry" rows="3"
                                readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_point" class="form-label">Image</label>
                            {{-- ✅ FIX: id unik untuk input & preview --}}
                            <input class="form-control" type="file" id="image_point" name="image"
                                onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-point" class="img-thumbnail mt-2"
                                width="400" style="display:none;">
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

    {{-- ✅ FIX: modal input polyline — perbaiki struktur tag form yang salah --}}
    <div class="modal" tabindex="-1" id="modalInputPolyline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polyline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polylines.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
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
                            <label for="geometry_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polyline" name="geometry_polyline" placeholder="Add geometry"
                                rows="3" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_polyline" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image_polyline" name="image"
                                onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polyline" class="img-thumbnail mt-2"
                                width="400" style="display:none;">
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

    {{-- modal input polygon --}}
    <div class="modal" tabindex="-1" id="modalInputPolygon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polygon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polygons.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_polygon" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name_polygon" name="name"
                                placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label for="description_polygon" class="form-label">Description</label>
                            <textarea class="form-control" id="description_polygon" name="description" placeholder="Add description"
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry_polygon" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polygon" name="geometry_polygon" placeholder="Add geometry"
                                rows="3" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_polygon" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image_polygon" name="image"
                                onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polygon" class="img-thumbnail mt-2"
                                width="400" style="display:none;">
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
            draw: {
                position: 'topleft',
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });

        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            var drawnJSONObject = layer.toGeoJSON();
            // ✅ FIX: kirim WKT dari GeoJSON geometry (bukan seluruh feature)
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(type, objectGeometry);

            if (type === 'polyline') {
                $('#geometry_polyline').val(objectGeometry);
                var modalPolyline = new bootstrap.Modal(document.getElementById('modalInputPolyline'));
                modalPolyline.show();
                $('#modalInputPolyline').on('hidden.bs.modal', function() {
                    location.reload();
                });
            } else if (type === 'polygon' || type === 'rectangle') {
                $('#geometry_polygon').val(objectGeometry);
                var modalPolygon = new bootstrap.Modal(document.getElementById('modalInputPolygon'));
                modalPolygon.show();
                $('#modalInputPolygon').on('hidden.bs.modal', function() {
                    location.reload();
                });
            } else if (type === 'marker') {
                $('#geometry_point').val(objectGeometry);
                var modalPoint = new bootstrap.Modal(document.getElementById('modalInputPoint'));
                modalPoint.show();
                $('#modalInputPoint').on('hidden.bs.modal', function() {
                    location.reload();
                });
            }

            drawnItems.addLayer(layer);
        });

        // ✅ FIX: show preview image saat file dipilih (show element yg tersembunyi)
        document.getElementById('image_point').addEventListener('change', function() {
            var preview = document.getElementById('preview-image-point');
            preview.src = window.URL.createObjectURL(this.files[0]);
            preview.style.display = 'block';
        });
        document.getElementById('image_polyline').addEventListener('change', function() {
            var preview = document.getElementById('preview-image-polyline');
            preview.src = window.URL.createObjectURL(this.files[0]);
            preview.style.display = 'block';
        });
        document.getElementById('image_polygon').addEventListener('change', function() {
            var preview = document.getElementById('preview-image-polygon');
            preview.src = window.URL.createObjectURL(this.files[0]);
            preview.style.display = 'block';
        });

        // ✅ FIX: helper untuk build popup content dengan path image yang benar
        function buildPopup(feature, deleteRoute) {
            var img = feature.properties.image && feature.properties.image !== 'null' && feature.properties.image !== null ?
                `<img src="{{ asset('storage/images') }}/${feature.properties.image}" class="img-thumbnail" width="300">` :
                '<em>No Image</em>';

            return `
        <b>Name:</b> ${feature.properties.name}<br>
        <b>Description:</b> ${feature.properties.description}<br>
        <b>Created:</b> ${feature.properties.created_at}<br>
        <b>Image:</b><br>${img}<br>
        <b>Updated:</b> ${feature.properties.updated_at}<br><br>
        <button
            class="btn btn-danger btn-sm" title='Delete'
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

        // GeoJSON Point
        var points = L.geoJSON(null, {
            onEachFeature: function(feature, layer) {
                var routeDelete = "{{ route('points.delete', ':id') }}";
                routeDelete = routeDelete.replace(':id', feature.properties.id); // ← sudah benar
                layer.bindPopup(buildPopup(feature, routeDelete)); // ← tambah routeDelete di sini
            }
        });

        // GeoJSON Polyline
        var polylines = L.geoJSON(null, {
            onEachFeature: function(feature, layer) {
                var routeDelete = "{{ route('polylines.delete', ':id') }}";
                routeDelete = routeDelete.replace(':id', feature.properties.id); // ← sudah benar
                layer.bindPopup(buildPopup(feature, routeDelete)); // ← tambah routeDelete di sini
            }
        });

        // GeoJSON Polygons
        var polygons = L.geoJSON(null, {
            onEachFeature: function(feature, layer) {
                var routeDelete = "{{ route('polygons.delete', ':id') }}";
                routeDelete = routeDelete.replace(':id', feature.properties.id); // ← sudah benar
                layer.bindPopup(buildPopup(feature, routeDelete)); // ← tambah routeDelete di sini
            }
        });

        fetch("{{ route('geojson.points') }}")
            .then(res => res.json())
            .then(data => {
                points.clearLayers();
                points.addData(data);
                map.addLayer(points);
            });

        fetch("{{ route('geojson.polylines') }}")
            .then(res => res.json())
            .then(data => {
                polylines.clearLayers();
                polylines.addData(data);
                map.addLayer(polylines);
            });

        fetch("{{ route('geojson.polygons') }}")
            .then(res => res.json())
            .then(data => {
                polygons.clearLayers();
                polygons.addData(data);
                map.addLayer(polygons);
            });

        // Control Layer
        var overlayMaps = {
            "Points": points,
            "Polyline": polylines,
            "Polygon": polygons,
        };

        L.control.layers({}, overlayMaps).addTo(map);
    </script>
@endsection
