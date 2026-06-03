@extends('layouts.template')

@section('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css">

    <style>
        /* BACKGROUND */
        body {
            background:
                linear-gradient(rgba(255, 240, 246, 0.50),
                    rgba(255, 227, 241, 0.82)),
                url('https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1974&auto=format&fit=crop');

            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(90deg, #ff4da6, #ff80bf) !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            background: white;
            color: #ff4da6 !important;
            border-radius: 8px;
            padding: 5px 12px;
        }

        /* SECTION TITLE */
        .section-title {
            font-size: 34px;
            font-weight: 700;
            color: #ff4da6;
            margin-bottom: 25px;
            text-align: center;
        }

        /* TABLE WRAPPER */
        .table-wrapper {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(255, 77, 166, 0.15);
            margin-bottom: 50px;
            backdrop-filter: blur(10px);
        }

        /* TABLE */
        .custom-table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        /* TABLE HEADER */
        .custom-table thead tr {
            background: linear-gradient(90deg, #ff4da6, #ff80bf);
            color: white;
        }

        .custom-table thead th {
            padding: 18px;
            border: none;
            font-size: 15px;
            font-weight: 600;
        }

        .custom-table thead th:first-child {
            border-top-left-radius: 14px;
            border-bottom-left-radius: 14px;
        }

        .custom-table thead th:last-child {
            border-top-right-radius: 14px;
            border-bottom-right-radius: 14px;
        }

        /* TABLE BODY */
        .custom-table tbody tr {
            background: white;
            transition: 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .custom-table tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 77, 166, 0.15);
        }

        .custom-table tbody td {
            padding: 16px;
            vertical-align: middle;
            border: none;
        }

        /* IMAGE */
        .table-img {
            width: 200px;
            height: 120px;
            object-fit: cover;
            border-radius: 14px;
            border: 3px solid #ffe3f1;
        }

        /* BADGE */
        .badge-id {
            background: #ffe3f1;
            color: #ff4da6;
            padding: 8px 14px;
            border-radius: 999px;
            font-weight: 600;
        }

        /* TABLE TITLE */
        .table-title {
            color: #ff4da6;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* DATATABLE */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 10px;
            border: 1px solid #ffb6d9;
            padding: 6px 10px;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 10px;
            border: 1px solid #ffb6d9;
            padding: 4px 8px;
        }
    </style>
@endsection

@section('content')

    <div class="container mt-5">

        <h1 class="section-title">
            📊 Geospatial Data Tables 🌸
        </h1>

        {{-- POINT TABLE --}}
        <div class="table-wrapper">

            <h3 class="table-title">📍 Point Data</h3>

            <div class="table-responsive">

                <table class="table custom-table align-middle" id="tablePoints">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Photo</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($points as $p)
                            <tr>

                                <td>
                                    <span class="badge-id">
                                        #{{ $p->id }}
                                    </span>
                                </td>

                                <td>
                                    <b>{{ $p->name }}</b>
                                </td>

                                <td>
                                    {{ $p->description }}
                                </td>

                                <td>
                                    <img src="{{ asset('storage/images/' . $p->image) }}"
                                        alt="{{ $p->name }}"
                                        class="table-img">
                                </td>

                                <td>
                                    {{ $p->created_at->format('d M Y') }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        {{-- POLYLINE TABLE --}}
        <div class="table-wrapper">

            <h3 class="table-title">🛣️ Polyline Data</h3>

            <div class="table-responsive">

                <table class="table custom-table align-middle" id="tablePolylines">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Photo</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($polylines as $p)
                            <tr>

                                <td>
                                    <span class="badge-id">
                                        #{{ $p->id }}
                                    </span>
                                </td>

                                <td>
                                    <b>{{ $p->name }}</b>
                                </td>

                                <td>
                                    {{ $p->description }}
                                </td>

                                <td>
                                    <img src="{{ asset('storage/images/' . $p->image) }}"
                                        alt="{{ $p->name }}"
                                        class="table-img">
                                </td>

                                <td>
                                    {{ $p->created_at->format('d M Y') }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        {{-- POLYGON TABLE --}}
        <div class="table-wrapper">

            <h3 class="table-title">🗺️ Polygon Data</h3>

            <div class="table-responsive">

                <table class="table custom-table align-middle" id="tablePolygons">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Photo</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($polygons as $p)
                            <tr>

                                <td>
                                    <span class="badge-id">
                                        #{{ $p->id }}
                                    </span>
                                </td>

                                <td>
                                    <b>{{ $p->name }}</b>
                                </td>

                                <td>
                                    {{ $p->description }}
                                </td>

                                <td>
                                    <img src="{{ asset('storage/images/' . $p->image) }}"
                                        alt="{{ $p->name }}"
                                        class="table-img">
                                </td>

                                <td>
                                    {{ $p->created_at->format('d M Y') }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>

    <script>
        // POINT TABLE
        new DataTable('#tablePoints', {
            pageLength: 5
        });

        // POLYLINE TABLE
        new DataTable('#tablePolylines', {
            pageLength: 5
        });

        // POLYGON TABLE
        new DataTable('#tablePolygons', {
            pageLength: 5
        });
    </script>

@endsection
