@extends('layouts.template')

@section('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;

            background:
                linear-gradient(rgba(255, 240, 246, 0.35),
                    rgba(255, 227, 241, 0.35)),
                url('https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1974&auto=format&fit=crop');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(90deg, #ff4da6, #ff80bf) !important;
            box-shadow: 0 4px 15px rgba(255, 77, 166, 0.3);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            margin-left: 10px;
            transition: 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: white;
            color: #ff4da6 !important;
            border-radius: 10px;
            padding: 6px 14px;
        }

        /* HERO SECTION */
        .hero-card {
            background: white;
            border-radius: 25px;
            padding: 50px;
            margin-top: 40px;
            box-shadow: 0 10px 30px rgba(255, 77, 166, 0.15);
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 77, 166, 0.08);
            border-radius: 50%;
            top: -120px;
            right: -100px;
        }

        .hero-card::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255, 128, 191, 0.08);
            border-radius: 50%;
            bottom: -100px;
            left: -80px;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            color: #ff4da6;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .hero-text {
            font-size: 17px;
            line-height: 1.9;
            color: #555;
            text-align: justify;
            position: relative;
            z-index: 2;
        }

        /* FEATURE CARD */
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(255, 77, 166, 0.2);
        }

        .feature-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: 20px;
            font-weight: 600;
            color: #ff4da6;
        }

        .feature-desc {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }

        /* BUTTON */
        .btn-custom {
            background: linear-gradient(90deg, #ff4da6, #ff80bf);
            border: none;
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, #ff338f, #ff66b3);
            color: white;
            transform: scale(1.05);
        }

        /* GLASS EFFECT */
        .hero-card,
        .feature-card,
        .stats-card {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            border: 1px solid rgba(255, 255, 255, 0.35);
        }

        /* STATS CARD */
        .stats-card {
            border-radius: 24px;
            padding: 28px;
            display: flex;
            align-items: center;
            gap: 18px;
            overflow: hidden;
            position: relative;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            background: rgba(255, 77, 166, 0.08);
            border-radius: 50%;
            top: -40px;
            right: -40px;
        }

        .stats-icon {
            min-width: 85px;
            min-height: 85px;

            font-size: 42px;

            background: linear-gradient(135deg, #ff4da6, #ff80bf);

            border-radius: 22px;

            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow: 0 8px 18px rgba(255, 77, 166, 0.3);
        }

        .stats-title {
            font-size: 16px;
            color: #777;
            margin-bottom: 4px;
        }

        .stats-number {
            font-size: 42px;
            font-weight: 700;
            color: #ff4da6;
            line-height: 1;
        }
    </style>
@endsection

@section('content')
    <div class="container">

        {{-- HERO SECTION --}}
        <div class="hero-card">

            <h1 class="hero-title">
                🗺️🌸 Geospatial CRUD Application 🌸🗺️
            </h1>

            <p class="hero-text">
                This application was developed to fulfill the assignment for the
                <b>Advanced Web Geospatial Programming Practicum (PGWL)</b> in the 4th semester. ✨
                <br><br>

                The application is designed to display geospatial data in the form of
                interactive maps and tables, while also providing features to manage and
                edit the data. It uses <b>Laravel</b> as the backend framework and
                <b>Leaflet</b> as the interactive mapping library. 💻📍
                <br><br>

                The data used in this application consists of location point data stored in
                <b>GeoJSON</b> format. Users can view the data in table form, explore it
                through the interactive map interface, and edit the data using the provided features. 📝🌐
                <br><br>

                In addition, the application is equipped with a navigation system that makes it easier
                for users to move between the Home, Map, and Table pages. 🚀💕
            </p>

            <div class="mt-4">
                <a href="{{ route('peta') }}" class="btn-custom">
                    🌍 Open Map
                </a>
            </div>
        </div>

        {{-- FEATURE SECTION --}}
        <div class="row mt-5 mb-5">

            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">📍</div>
                    <div class="feature-title">Interactive Map</div>
                    <div class="feature-desc">
                        Display geospatial data interactively using Leaflet maps.
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <div class="feature-title">CRUD Features</div>
                    <div class="feature-desc">
                        Create, update, edit, and delete geospatial data easily.
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <div class="feature-title">Data Table</div>
                    <div class="feature-desc">
                        Display spatial data in structured and organized tables.
                    </div>
                </div>
            </div>

        </div>

        {{-- STATISTICS SECTION --}}
        <div class="row mt-4 mb-5 justify-content-center">

            {{-- TOTAL POINTS --}}
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">📍</div>
                    <div>
                        <div class="stats-title">Total Points</div>
                        <div class="stats-number">{{ $totalPoints }}</div>
                    </div>
                </div>
            </div>

            {{-- TOTAL POLYLINES --}}
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">🛣️</div>
                    <div>
                        <div class="stats-title">Total Polylines</div>
                        <div class="stats-number">{{ $totalPolylines }}</div>
                    </div>
                </div>
            </div>

            {{-- TOTAL POLYGONS --}}
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">🗺️</div>
                    <div>
                        <div class="stats-title">Total Polygons</div>
                        <div class="stats-number">{{ $totalPolygons }}</div>
                    </div>
                </div>
            </div>

            {{-- TOTAL USERS --}}
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">👤</div>
                    <div>
                        <div class="stats-title">Total Users</div>
                        <div class="stats-number">{{ $totalUsers }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
