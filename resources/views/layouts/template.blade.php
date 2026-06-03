<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet Map</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @yield('styles')

</head>

<body>
    @include('components.navbar')

    @yield('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('scripts')

    @include('components.toast')

</body>

<style>
    /* LOGIN BUTTON */
    .btn-login {
        background: rgba(255, 255, 255, 0.2);
        color: white !important;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 10px;
        padding: 8px 16px !important;
        font-weight: 600;
        transition: 0.3s;
        margin-left: 10px;
        backdrop-filter: blur(5px);
    }

    .btn-login:hover {
        background: white;
        color: #ff4da6 !important;
        transform: translateY(-2px);
    }

    /* LOGOUT BUTTON */
    .btn-logout {
        background: #ff338f;
        color: white !important;
        border-radius: 10px;
        padding: 8px 16px !important;
        font-weight: 600;
        transition: 0.3s;
        margin-left: 10px;
    }

    .btn-logout:hover {
        background: #ff1f7a;
        color: white !important;
        transform: translateY(-2px);
    }
</style>

</html>
