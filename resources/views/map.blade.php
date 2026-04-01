@extends('layouts.template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <style>
        /* Background halaman */
        body {
            background: #fff0f6;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #ff4da6, #ff80bf);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Brand */
        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 22px;
        }

        /* Menu navbar */
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            margin-right: 10px;
            transition: 0.3s;
        }

        /* Hover menu */
        .navbar-nav .nav-link:hover {
            background: white;
            color: #ff4da6 !important;
            border-radius: 8px;
            padding: 6px 12px;
        }

        /* Container peta */
        #map {
            height: 80vh;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            margin-top: 20px;
        }

        /* Card container */
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

    <div class="modal" tabindex="-1" id="modalInputPoint">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('points.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"
                        placeholder="Add description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="geometry_point" class="form-label">Geometry</label>
                        <textarea class="form-control" id="geometry_point" name="geometry_point"
                        placeholder="Add geometry" rows="3"></textarea>
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

    // modal input polyline
    <div class="modal" tabindex="-1" id="modalInputPolyline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polyline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('polylines.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"
                        placeholder="Add description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="geometry_polyline" class="form-label">Geometry</label>
                        <textarea class="form-control" id="geometry_polyline" name="geometry_polyline"
                        placeholder="Add geometry" rows="3"></textarea>
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

    // modal input polygon
    <div class="modal" tabindex="-1" id="modalInputPolygon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polygon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('polygons.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"
                        placeholder="Add description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="geometry_polygon" class="form-label">Geometry</label>
                        <textarea class="form-control" id="geometry_polygon" name="geometry_polygon"
                        placeholder="Add geometry" rows="3"></textarea>
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

            console.log(type);

            var drawnJSONObject = layer.toGeoJSON();

            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(drawnJSONObject);
            console.log(objectGeometry);

            if (type === 'polyline') {
                // Set geometry to textarea
                $('#geometry_polyline').val(objectGeometry);
                // Show modal input polyline
                $('#modalInputPolyline').modal('show');
                // Modal dismiss reload page
                $('#modalInputPolyline').on('hidden.bs.modal', function () {
                    location.reload();
                });
            } else if (type === 'polygon' || type === 'rectangle') {
                // Set geometry to textarea
                $('#geometry_polygon').val(objectGeometry);
                // Show modal input polygon
                $('#modalInputPolygon').modal('show');
                // Modal dismiss reload page
                $('#modalInputPolygon').on('hidden.bs.modal', function () {
                    location.reload();
                });
            } else if (type === 'marker') {
                console.log("Create " + type);
                // Set geometry to textarea
                $('#geometry_point').val(objectGeometry);
                // Show modal input point
                $('#modalInputPoint').modal('show');
                // Modal dismiss reload page
                $('#modalInputPoint').on('hidden.bs.modal', function () {
                    location.reload();
                });
            } else {
                console.log('__undefined__');
            }

            drawnItems.addLayer(layer);
        });
    </script>
@endsection
