crudData = 1;
pagAct = 0;
cantPag = 1;
cantTotal = 0;
textSearch = "";
csrf_token = token.content;

window.onload = start;


function start(){
    getTotalData();
}


function getTotalData(){
    const formdata = new FormData();
    formdata.append('_token', csrf_token);
    formdata.append("pagAct", pagAct * cantPag);
    formdata.append("crudData", crudData);
    formdata.append("buscar", textSearch);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../totalData");
    ajax.onload = function() {
        if(ajax.responseText == -1){
            cantTotal = 0;
        }else{
            cantTotal = ajax.responseText;
        }
        getData()
    }
    ajax.send(formdata);

}

function clickChange(id){
    crudData = id;
    pagAct = 0;
    document.getElementById("mostrarPag").innerHTML = "1";
    if(id == 1)
        document.getElementById("btnAdd").disabled = true;
    else
        document.getElementById("btnAdd").disabled = false;

    getTotalData();
}

function getData(){
    const formdata = new FormData();
    formdata.append('_token', csrf_token);
    formdata.append("pagAct", pagAct * cantPag);
    formdata.append("crudData", crudData);
    formdata.append("buscar", textSearch);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../getData");
    ajax.onload = function() {
        data = JSON.parse(ajax.responseText);
        if(crudData == 1){
            tableContent = "<tr><th>Username</th><th>Nombre</th><th>Correo</th><th>Grupo</th><th>Acciones</th></tr>"
        }else if(crudData == 2){
            tableContent = "<tr><th>Foto</th><th>Nombre</th><th>Descripción</th><th>Coordenadas</th><th>Usuario</th><th>Acciones</th></tr>"
        }else if(crudData == 3){
            tableContent = "<tr><th>Nombre</th><th>Pregunta</th><th>Pista</th><th>Respuesta</th><th>Coordenadas</th><th>Acciones</th></tr>"
        }else{
            tableContent = ""
        }
        data.forEach(element => {
            if(crudData == 1){
                tableContent += `<tr><th>${element.username}</th><th>${element.nombre} ${element.apellidos}</th><th>${element.correo}</th><th>${element.grupo}</th><th><button onclick=eliminar(1,${element.id})>Eliminar</button></th></th></tr>`
            }else if(crudData == 2){
                tableContent += `<tr><th><img src='../storage/img/${element.id}.jpg'></th><th>${element.nombre}</th><th>${element.descripcion} </th><th>${element.latitud},${element.longitud}</th><th>${element.username}</th><th><button onclick=modificar(2,${element.id})>Modificar</button><button onclick=eliminar(2,${element.id})>Eliminar</button></th></th></tr>`
            }else if(crudData == 3){
                tableContent += `<tr><th>${element.nombre}</th><th>${element.texto_pregunta}</th><th>${element.texto_pista}</th><th>${element.respuesta}</th><th>${element.latitud},${element.longitud}</th><th><button onclick=modificar(3,${element.id})>Modificar</button><button onclick=eliminar(3,${element.id})>Eliminar</button></th></tr>`
            }
        });
        document.getElementById("tableData").innerHTML = tableContent;
    }
    ajax.send(formdata);
}

function cambiarDataBuscar(){
    textSearch = event.target.value
    pagAct = 0;
    document.getElementById("mostrarPag").innerHTML = "1";
    getTotalData();
}

function modificar(crudId, id){
    const formdata = new FormData();
    formdata.append('_token', csrf_token);
    formdata.append("crudData", crudId);
    formdata.append("id", id);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../getDataById");
    ajax.onload = function(){
        modRegistar(JSON.parse(ajax.responseText)[0])
    }
    ajax.send(formdata);
}

function eliminar(crudValue,id){
    const formdata = new FormData();
    formdata.append('_token', csrf_token);
    formdata.append('_method', 'DELETE');
    formdata.append("crudData", crudValue);
    formdata.append("id", id);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../deleteCrud");
    ajax.onload = function(){
        if(ajax.responseText == "OK"){
            if(crudValue == 1){
                alertText = "Usuario eliminado"
            }else if(crudValue == 2){
                alertText = "Punto de interes eliminado"
            }else{
                alertText = "Prueba de la gimcana eliminada"
            }
            pagAct = 0;
            document.getElementById("mostrarPag").innerHTML = "1";
            getTotalData();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: alertText,
                showConfirmButton: false,
                timer: 1500
              })
        }else{
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Ha ocurrido un error inesperado',
              })
            console.log("Error: "+ajax.responseText);
        }
    }
    ajax.send(formdata);
}

function modRegistar(data){
    if(crudData == 2){
        form = `<form onsubmit="modPIData()" enctype= multipart/form-data><input type="hidden" id="firstRowForm" name="id" value="${data.id}"> 
        <label>Nombre</label><br><input type="text" id="firstRowForm" placeholder="Escribe el nombre" value="${data.nombre}" name="nombre" required><br>
        <label>Descripción</label><br><textarea placeholder="Escribe la descripcion" name="descripcion" value="${data.descripcion}"></textarea><br>
        <label>Latitud</label><br><input type="number" placeholder="Escribe la latitud" name="latitud" value="${data.latitud}" required><br>
        <label>Longitud</label><br><input type="number" placeholder="Escribe la longitud" name="longitud" value="${data.longitud}" required><br>
        <label>Imagen</label><br><input type="file" name="imagen"><br>
        <input type="submit" value="Modificar"></form>`
        PopUpFormBasic("Modificar punto de interés", form);
    }else if(crudData == 3){
        form = `<form onsubmit="modPruebaData()"><input type="hidden" id="firstRowForm" name="id" value="${data.id}"> 
        <label>Nombre</label><br><input type="text" id="firstRowForm" placeholder="Escribe el nombre" name="nombre" value="${data.nombre}" required><br>
        <label>Pregunta</label><br><input  type="text" placeholder="Escribe la pregunta" name="pregunta" value="${data.texto_pregunta}" required><br>
        <label>Pista</label><br><input  type="text" placeholder="Escribe la pista" name="pista" value="${data.texto_pista}" required><br>
        <label>Respuesta</label><br><input  type="text" placeholder="Escribe la respuesta" name="respuesta" value="${data.respuesta}" required><br>
        <label>Latitud</label><br><input  type="number" placeholder="Escribe la latitud" name="latitud" value="${data.latitud}" required><br>
        <label>Longitud</label><br><input type="number" placeholder="Escribe la longitud" name="longitud" value="${data.longitud}" required><br>
        <input type="submit" value="Modificar"></form>`
        PopUpFormBasic("Modificar prueba gimcana", form);
    }
}

function addRegister(){
    if(crudData == 2){
        form = '<form onsubmit="insertPIData()" enctype= multipart/form-data>' +
        '<label>Nombre</label><br><input type="text" id="firstRowForm" placeholder="Escribe el nombre" name="nombre" required><br>' +
        '<label>Descripción</label><br><textarea placeholder="Escribe la descripcion" name="descripcion"></textarea><br>' +
        '<label>Latitud</label><br><input type="number" placeholder="Escribe la latitud" name="latitud" required><br>' +
        '<label>Longitud</label><br><input type="number" placeholder="Escribe la longitud" name="longitud" required><br>' +
        '<label>Imagen</label><br><input type="file" name="imagen" required><br>' +
        '<input type="submit" value="Crear"></form>',
        PopUpFormBasic("Añadir punto de interés", form);
    }else if(crudData == 3){
        form = '<form onsubmit="insertPruebaData()">' +
        '<label>Nombre</label><br><input type="text" id="firstRowForm" placeholder="Escribe el nombre" name="nombre" required><br>' +
        '<label>Pregunta</label><br><input  type="text" placeholder="Escribe la pregunta" name="pregunta" required><br>' +
        '<label>Pista</label><br><input  type="text" placeholder="Escribe la pista" name="pista" required><br>' +
        '<label>Respuesta</label><br><input  type="text" placeholder="Escribe la respuesta" name="respuesta" required><br>' +
        '<label>Latitud</label><br><input  type="number" placeholder="Escribe la latitud" name="latitud" required><br>' +
        '<label>Longitud</label><br><input type="number" placeholder="Escribe la longitud" name="longitud" required><br>' +
        '<input type="submit" value="Crear"></form>',
        PopUpFormBasic("Añadir prueba gimcana", form);
    }
}

function PopUpFormBasic(titulo, formulario){
    Swal.fire({
        title: '<strong>'+titulo+'</strong>',
        html: formulario,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
    })
    document.getElementById("firstRowForm").blur();
}

function insertPruebaData(){
    event.preventDefault();
    const formdata = new FormData(event.target);
    formdata.append('_token', csrf_token);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../insertPruebaCrud");
    ajax.onload = function(){
        if(ajax.responseText == "errorNoSet"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Tienes que rellenar los campos',
              })
        }else if(ajax.responseText == "errorCoordenas"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Las coordenadas no son correctas',
              })
        }else if(ajax.responseText == "OK"){
            getTotalData();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Prueba insertada correctamente',
                showConfirmButton: false,
                timer: 1500
              })
        }else{
            console.log(ajax.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salio mal',
              })
        }
    }
    ajax.send(formdata);
}

function modPruebaData(){
    event.preventDefault();
    const formdata = new FormData(event.target);
    formdata.append('_token', csrf_token);
    formdata.append('_method', "PUT");
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../modPruebaCrud");
    ajax.onload = function(){
        if(ajax.responseText == "errorNoSet"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Tienes que rellenar los campos',
              })
        }else if(ajax.responseText == "errorCoordenas"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Las coordenadas no son correctas',
              })
        }else if(ajax.responseText == "OK"){
            getTotalData();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Prueba modificada correctamente',
                showConfirmButton: false,
                timer: 1500
              })
        }else{
            console.log(ajax.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salio mal',
              })
        }
    }
    ajax.send(formdata);
}

function insertPIData(){
    event.preventDefault();
    const formdata = new FormData(event.target);
    formdata.append('_token', csrf_token);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../insertPICrud");
    ajax.onload = function(){
        if(ajax.responseText == "errorNoSet"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Tienes que rellenar los campos',
              })
        }else if(ajax.responseText == "errorCoordenas"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Las coordenadas no son correctas',
              })
        }else if(ajax.responseText == "OK"){
            getTotalData();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Punto de interés insertado correctamente',
                showConfirmButton: false,
                timer: 1500
              })
        }else{
            console.log(ajax.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salio mal',
              })
        }
    }
    ajax.send(formdata);
}

function modPIData(){
    event.preventDefault();
    const formdata = new FormData(event.target);
    formdata.append('_token', csrf_token);
    formdata.append('_method', "PUT");
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "../modPICrud");
    ajax.onload = function(){
        if(ajax.responseText == "errorNoSet"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Tienes que rellenar los campos',
              })
        }else if(ajax.responseText == "errorCoordenas"){
            Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Las coordenadas no son correctas',
              })
        }else if(ajax.responseText == "OK"){
            getTotalData();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Punto de interés modificado correctamente',
                showConfirmButton: false,
                timer: 1500
              })
        }else{
            console.log(ajax.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo salio mal',
              })
        }
    }
    ajax.send(formdata);
}
function changePag(direction){
    if(direction){
        if(pagAct+1 < cantTotal)
            pagAct ++
    }else{
        if(pagAct > 0)
            pagAct--
    }
    document.getElementById("mostrarPag").innerHTML = pagAct+1;
    getTotalData();
}
