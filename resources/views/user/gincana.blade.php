<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>


    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />

    <link rel="stylesheet" href="../resources/css/gincana.css">
    {{-- <link rel="stylesheet" href="../resources/css/mapa_principal.css"> --}}

    <!-- BOOSTRAPP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

     <!-- ICONOS -->
     <script src="https://kit.fontawesome.com/8d74b7c7c2.js" crossorigin="anonymous"></script>

    <title>Gincana</title>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navs">
        <nav class="navbar navbar-expand-lg" style="background-color: #34A853">
            <div class="container-fluid">
                <img src="../resources/img/logo.jpg" style=" height:50px; width:50px;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    </ul>

                    <a class="navbar-brand" href="{{ route('perfil') }}">

                        <button type="button" class="btn" style="background-color: #B8E0C3">Perfil</button>

                    </a>
                    <button type="button" onclick="cerrarSesion()" class="btn" style="background-color: #B8E0C3">LogOut</button>
                </div>
            </div>
        </nav>
    </div>

    <div class="zona_mapa">
        <div class="containerBtnGim">
            <button id="btn-gimcana" type="button" class="btn gim-btn" style="background-color: #B8E0C3; margin-left: 5%; margin-top: 2%;">Iniciar Gincana</button>
            <button id="btn-preguntaGim" type="button" class="btn gim-btn" style="background-color: #B8E0C3; margin-left: 1%; margin-top: 2%;">Ver Pregunta</button>
        </div>
        <div id="map" style="width:100%; height: 100vh; z-index: -1;"> 
            
        </div>    
    </div>
    
   

    {{-- <button id="btn-gimcana" class="my-btn"></button>
    <button id="btn-localizacion" class="my-btn" disabled>Ver pregunta</button> --}}

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <!-- <p>Contenido del modal aquí.</p> -->
            <div class="modal-body" id="contenido-modal">

            </div>
        </div>
    </div>

    <!--  <script src="../resources/js/gincana/ubicacionActual.js"></script> -->
    <script src="../resources/js/gincana/modals.js"></script>
    <!-- <script src="../resources/js/gincana/RouteService.js"></script> -->

    <div class="main-container">
        <nav class="navigation">
            <ul>
                <li>
                    <i class="fa-solid fa-gamepad"></i>
                </li>
                <li onclick="perfil()">
                    <i class="fa-solid fa-user"></i>
                </li>
                <li onclick="cerrarSesion()">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </li>
    
    
            </ul>
        </nav>
    </div>

    <script>

        function cerrarSesion() {
            location.href = "logout";
        }
        function perfil() {
            location.href = "admin/perfil";
        }
    </script>

</body>
</html>
