<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/54cbb11825.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="../../resources/js/crud.js"></script> -->
    <link rel="stylesheet" href="../../resources/css/perfil.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #34A853">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <img width="50px" height="50px" src="../../resources/img/logo.jpg" alt="">
                    </li>
                </ul>
                <button class="btn btn-light"  type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
            </div>
    </nav>

    <div class="c100">
                <div class="c35">
                    <div class="cont-35 flex">
                        <img src="{{asset('../resources/img/imagen-usuarios.png')}}" alt="imgusuario">
                    </div>
                    <div class="lugares flex">
                        <h2>Nombre usuario</h2>
                    </div>
                    <div class="lugares flex">
                        <h1>Lugares favoritos</h1>
                    </div>
                    <div class="contenido-35">
                        <p><i class="fa-solid fa-location-dot" style="color: #34a853;"></i> Parc de la serp Num. 100 numero XX hola</p>
                        <p><i class="fa-solid fa-location-dot" style="color: #34a853;"></i> Calle Leonardo Da Vinci numero XX hola que tal bien que si que estoy bien</p>
                        <p><i class="fa-solid fa-location-dot" style="color: #34a853;"></i> Parc de la serp Num. 100 numero XX hola</p>
                        <p><i class="fa-solid fa-location-dot" style="color: #34a853;"></i> Parc de la serp Num. 100</p>
                    </div>
                </div>
                <div class="c65">
                    <div class="container65">
                        <div class="flex">
                            <h1>Perfil</h1><br>
                        </div>
                        <div class="contenido-65">
                            <h2>Nombre Usuario: Yeray Llorca</h2><br>
                            <p>Nombre: Yeray</p><br>
                            <p>Apellidos: Llorca Carrera</p><br>
                            <p>Correo: yeray@gmail.com</p>
                            <p></p>
                        </div>
                    </div>
                    <div class="container65">
                        <div class="flex">
                            <h1>Etiquetas</h1><br>
                        </div>
                        <div class="contenido-65">
                            <p>Nombre:</p><br>
                            <p>Descripción:</p><br>
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
</body>
</html>