<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
    <title>Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/54cbb11825.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../resources/js/crud.js"></script>
    <link rel="stylesheet" href="../../resources/css/crud.css">
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
      <div class="centradoboton">
        <div class="frame">
          <button class="custom-btn btn-2" onclick="clickChange(1)">Usuarios</button>
          <button class="custom-btn btn-2" onclick="clickChange(2)">Interes</button>
          <button class="custom-btn btn-2" onclick="clickChange(3)">Gimcana</button>
          <input type="text" class="inpbuscar" style="margin-left:6vw;" placeholder="buscar" onkeyup="cambiarDataBuscar()">
          <button class="btn btn-dark" style="width: 100px; margin-top:-5px;" id="btnAdd" onclick="addRegister()" disabled>Añadir</button>
        </div>
      </div>
      <br>

      <div class="tablacrud">
          <table id="tableData"  class="table">
          </table>
      </div>

      <div class="centrado">
        <div class="frame2">
          <button class="custom-btn2 btn-2" onclick="changePag(false)"><</button>
          <button class="custom-btn2 btn-2" id="mostrarPag">1</button>
          <button class="custom-btn2 btn-2" onclick="changePag(true)">></button>
        </div>
      </div>

</body>
</html>