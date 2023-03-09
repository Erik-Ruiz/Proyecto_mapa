<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <!-- Token -->
  <meta name='csrf-token' content="{{ csrf_token() }}" id="token" />

  <!-- CSS -->
  <link rel="stylesheet" href="../resources/css/mapa_principal.css">

  <!-- MAPA -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>


  <!-- BOOSTRAPP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  <!-- ICONOS -->
  <script src="https://kit.fontawesome.com/8d74b7c7c2.js" crossorigin="anonymous"></script>

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
          <button type="button" class="btn" style="background-color: #B8E0C3; margin-right: 1%;">Iniciar Gincana</button>
          <button type="button" class="btn" style="background-color: #B8E0C3">LogOut</button>

        </div>
      </div>
    </nav>
  </div>


  <!-- FILTROS -->

  <div class="zona_mapa">


    <!-- MAPA -->

    <div id="map">
      <div class="buscador">
        <div class="filtros">
          <input type="text" autocomplete="off" name="text" class="filtro_nombre"  id="filtro_nombre" placeholder="Restaurante" aria-label="Username">
        </div>

        <div class="filtros1">

          <select class="select_etiquetas" name="id_genero" id="filtro_etiqueta">
            <option value="NO" content="NO" ></option>
            @foreach ($etiquetas as $etiqueta)
                <option value="{{$etiqueta->id}}" >{{$etiqueta->nombre}}</option>
            @endforeach
          </select>
          <select class="select_personal" id="filtro_opinion">
            <option value="NO" content="NO" ></option>
            <option value="personal">Personal</option>
          </select>
          <button type="button" id="likes" class="btn activo" style=" margin-left:5%;"><i style="color: rgb(255, 255, 255);"; class="fa-solid fa-heart"></i></button>

          <style>
              #likes {
                cursor: pointer;
              }

              #likes.activo {
                background-color: green;
              }

              #likes.desactivo {
                background-color: red;
              }

          </style>

<script>
	const boton = document.getElementById("likes");

boton.addEventListener("click", function() {
  if (boton.classList.contains("activo")) {
    boton.classList.remove("activo");
    boton.classList.add("desactivo");
  } else {
    boton.classList.remove("desactivo");
    boton.classList.add("activo");
  }
});
</script>
        </div>

      </div>

    </div>
  </div>

<script type="text/javascript" src="../resources/js/mapa_principal.js"></script>
</body>


</html>