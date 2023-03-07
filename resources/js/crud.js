crudData = 1;
pagAct = 0;
cantPag = 8;
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
            tableContent = "<tr><th>Nombre</th><th>Descripción</th><th>Coordenadas</th><th>Usuario</th><th>Acciones</th></tr>"
        }else if(crudData == 3){
            tableContent = "<tr><th>Nombre</th><th>Pregunta</th><th>Pista</th><th>Respuesta</th><th>Coordenadas</th><th>acciones</th></tr>"
        }else{
            tableContent = ""
        }
        data.forEach(element => {
            if(crudData == 1){
                tableContent += `<tr><th>${element.username}</th><th>${element.nombre} ${element.apellidos}</th><th>${element.correo}</th><th>${element.grupo}</th><th>Acciones</th></tr>`
            }else if(crudData == 2){
                tableContent = `<tr><th>Nombre</th><th>Descripción</th><th>Coordenadas</th><th>Usuario</th><th>Acciones</th></tr>`
            }else if(crudData == 3){
                tableContent = `<tr><th>Nombre</th><th>Pregunta</th><th>Pista</th><th>Respuesta</th><th>Coordenadas</th><th>acciones</th></tr>`
            }
        });
        document.getElementById("tableData").innerHTML = tableContent;
    }
    ajax.send(formdata);
}

function cambiarDataBuscar(){
    textSearch = event.target.value
    getTotalData();
}
