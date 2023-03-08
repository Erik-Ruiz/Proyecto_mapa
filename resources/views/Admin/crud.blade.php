<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
    <title>Crud</title>
    <script src="../../resources/js/crud.js"></script>
</head>
<body>
    <button onclick="
        (1)">Usuarios</button>
     <button onclick="clickChange(2)">Puntos Interes</button>
     <button onclick="clickChange(3)">Pruebas Gimcana</button>
     <input type="text" placeholder="buscar" onkeyup="cambiarDataBuscar()">
     <table id="tableData" border="1">

     </table>
</body>
</html>