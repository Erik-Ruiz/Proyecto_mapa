<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
    <title>Crud</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../resources/js/crud.js"></script>
</head>
<body>
    <button onclick="clickChange(1)">Usuarios</button>
     <button onclick="clickChange(2)">Puntos Interes</button>
     <button onclick="clickChange(3)">Pruebas Gimcana</button>
     <button id="btnAdd" onclick="addRegister()" disabled>Añadir</button>
     <input type="text" placeholder="buscar" onkeyup="cambiarDataBuscar()">
     <table id="tableData" border="1">
     </table>
     <button onclick="changePag(false)"><</button>
     <button id="mostrarPag">1</button>
     <button onclick="changePag(true)">></button>
</body>
</html>