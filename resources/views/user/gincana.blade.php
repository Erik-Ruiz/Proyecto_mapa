<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />

    <link rel="stylesheet" href="../resources/css/gincana.css">

    <title>Gincana</title>
</head>
<body>

    <div id="map" style="width:100%; height: 100vh">

    </div>

    <button id="btn-gimcana"></button>
    <button id="btn-location">Location</button>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <!-- <p>Contenido del modal aquí.</p> -->
            <div id="contenido-modal">

            </div>
        </div>
    </div>

    <!--  <script src="../resources/js/gincana/ubicacionActual.js"></script> -->
    <script src="../resources/js/gincana/modals.js"></script>
    <!-- <script src="../resources/js/gincana/RouteService.js"></script> -->



</body>
</html>
