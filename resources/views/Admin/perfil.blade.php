<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/54cbb11825.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="../../resources/js/crud.js"></script> -->
    <link rel="stylesheet" href="../../resources/css/perfil.css">
    <script src="../../resources/js/perfil.js"></script>
</head>
<body class="cuerpo">
    <nav class="navbar navbar-expand-lg" style="background-color: #34A853">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <img width="50px" height="50px" src="../../resources/img/logo.jpg" alt="">
                    </li>
                </ul>
                <button class="btn btn-light" type="button" onclick="cerrarSesion()" ><i class="fa-solid fa-right-from-bracket"></i></button>
                <a  href="{{'../mapa_principal'}}">
                <button class="btn btn-light" ><i class="fa-solid fa-location-dot" style="color: #34a853;"></i></button>
                </a>
            </div>
    </nav>

    <div class="c100">
                <div class="c35">
                    <div class="cont-35 flex">
                        <img src="{{asset('../resources/img/imagen-usuarios.png')}}" alt="imgusuario">
                    </div>
                    <div class="lugares flex">
                        @foreach ($usuario as $usu)
                            <h2 id="usernameInFoto">{{$usu->username}}<h2>
                        @endforeach
                    </div>
                    <div class="container35">
                        <div class="lugares flex">
                                <h1>Lugares favoritos</h1>
                            </div>
                            <div class="contenido-35">
                            @foreach ($favoritos as $fav)
                                <p><i class="fa-solid fa-location-dot" style="color: #34a853;"></i>{{$fav->nombre}} </p>
                            @endforeach
                        </div>
                    </div>

                    
                </div>
                <div class="c65">
                    <div class="container65">
                    <div class="flex">
                            <h1>Perfil</h1><br>
                            <div class="flex">
                                <button class="btn btn-light" onclick="changeStatusForm()"><i class="fa-solid fa-pen-to-square" style="color: #34A853;"></i></button>
                            </div>
                        </div>

                        <div class="contenido-65">
                        @foreach ($usuario as $usu)
                            <p>Nombre Usuario: <br><input id="usernameForm" type="text" value="{{$usu->username}}" disabled></p><br>
                            <p>Nombre: <br><input id="nameForm" type="text" value="{{$usu->nombre}}" disabled></p><br>
                            <p>Apellidos: <br><input id="surnameForm" type="text" value="{{$usu->apellidos}}" disabled></p><br>
                            <p>Correo: <br><input id="mailForm" type="mail" value="{{$usu->correo}}" disabled></p>
                        @endforeach

                            <p></p>
                        </div>
                    </div>
                    <div class="container65">
                        <div class="flex">
                            <h1>Etiquetas</h1><br>
                        </div>
                        <div class="contenido-65">
                            <p>Tus etiquetas:</p><br>
                        @foreach ($etiquetas as $eti)
                            <p>{{$eti->nombre}}</p><br>
                        @endforeach
                        
                        </div>
                    </div>
                    <div class="container65">
                        <div class="flex">
                            <h1>Histórico pruebas</h1><br>
                        </div>
                        <div class="contenido-65">
                            <p>Prueba:</p><br>
                            <p>Tiempo:</p><br>
                        </div>
                    </div>
                </div>
    </div>

    <script>

        function cerrarSesion() {
            location.href = "logout";
        }

    </script>
</body>
</html>