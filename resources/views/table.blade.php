@extends('layouts.template')

@section('styles')
<style>

/* background halaman */
body{
    background:#fff0f6;
}

/* NAVBAR PINK (override bootstrap) */
.navbar{
    background:linear-gradient(90deg,#ff4da6,#ff80bf) !important;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

/* brand navbar */
.navbar-brand{
    color:white !important;
    font-weight:600;
}

/* menu navbar */
.navbar-nav .nav-link{
    color:white !important;
    font-weight:500;
}

/* hover menu */
.navbar-nav .nav-link:hover{
    background:white;
    color:#ff4da6 !important;
    border-radius:8px;
    padding:5px 12px;
}

/* menu aktif */
.navbar-nav .nav-link.active{
    background:white;
    color:#ff4da6 !important;
    border-radius:8px;
    padding:5px 12px;
}

/* container tabel */
.table-wrapper{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 6px 15px rgba(0,0,0,0.1);
}

/* header tabel */
.table thead{
    background:#ff4da6;
    color:white;
}

/* hover tabel */
.table tbody tr:hover{
    background:#ffe3f1;
}

</style>
@endsection


@section('content')

<div class="container mt-4">

    <div class="table-wrapper">

        <h3 class="mb-4">Data Table</h3>

        <table class="table table-bordered table-striped table-hover">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Bundaran UGM</td>
                    <td>Jalan Pancasila</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Tugu</td>
                    <td>Adalah pokonya</td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Malioboro Jogja</td>
                    <td>Disanalah pokonya</td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>Titik Nol</td>
                    <td>Di depan kantor pos</td>
                </tr>

                <tr>
                    <td>5</td>
                    <td>Alun-alun Kidul</td>
                    <td>Kepo</td>
                </tr>
            </tbody>

        </table>

    </div>

</div>

@endsection
