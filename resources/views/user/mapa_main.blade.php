<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

  <!-- MAPA -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
        

  <!-- BOOSTRAPP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>   

</head>

<body>

  <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg" style="background-color: #34A853">
        <div class="container-fluid">
          <img src="../../img/logo.jpg" style=" height:50px; width:50px;">
          <a class="navbar-brand" href="#">AUJE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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

  <!-- FILTROS -->


<div class="zona_mapa">
    <div class="filtros">

      <div class="buscador">
        <input type="text" class="form-control input_filtro" id="filtro_nombre" placeholder="Restaurante" aria-label="Username" aria-describedby="basic-addon1">
      </div>

      <select class="select_etiquetas">
        <option value="r">Rojo</option>
        <option value="a">Azul</option>
        <option value="v">Verde</option>
      </select>

      <select class="select_personal">
        <option value="r">Rojo</option>
        <option value="a">Azul</option>
        <option value="v">Verde</option>
      </select>

    </div>

  <!-- MAPA -->
    <div class="mapa" id="mapa">
              
          <script>


              const map = L.map('mapa').setView([41.38710079433486, 2.183035577913213], 15);

              var layerGroup = L.layerGroup().addTo(map);
              const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  maxZoom: 19,
                  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
              }).addTo(map);
              
            </script>


    </div>
  </div> 

</body>


<style>


.zona_mapa{
  position: relative;
}

.buscador{
  margin-right: 10%;
  width: 400px;
}
.filtros{
  position: absolute;
  display: flex;
  flex-direction: row;
  margin: 10px;
  margin-left: 35%;
  z-index: 2;
  align-items: center;
}

.mapa{
  position: absolute;;
  width:100%; 
  height:550px;
  z-index: 1;
}

.select_etiquetas{
  border-radius: 5px;
  margin-right: 5%;
  
}

.select_personal{
  border-radius: 5px;
}

</style>

</html>