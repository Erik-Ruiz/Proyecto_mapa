var estatus = 0;
var gimcanaPrueba;
var pruebaActual;
var pruebasTotales;
var csrf_token = token.content

var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var circle = L.circle([41.38710079433486, 2.183035577913213], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 500
}).addTo(map);

function getStatusGincanaStart () {
    
    var ajax = new XMLHttpRequest();
    ajax.open('GET', "getStatusGincana");

    ajax.onload = function() {

        gimcanaPrueba = JSON.parse(ajax.responseText)[0];
        pruebaActual = JSON.parse(ajax.responseText)[1];
        pruebasTotales = JSON.parse(ajax.responseText)[2];

        if(gimcanaPrueba == 0) {

            document.getElementById('btn-gimcana').innerHTML = "Empezar gimcana";
            document.getElementById('btn-gimcana').onclick = empezarGimcana;

        } else {
            document.getElementById('btn-gimcana').innerHTML = "Ver pista";
            document.getElementById('btn-gimcana').onclick = verPista;
            
<<<<<<< HEAD
            document.getElementById('contenido-modal').innerHTML = 
            `<div class="titulo-modal">
=======
            document.getElementById('contenido-modal').innerHTML = `
            
            <div class="modal-header">
>>>>>>> f7603ac3c7898f3562e9bac8a45a31c0f09d6bc8
                <h1>¿Estas seguro que quieres borrar la partida? </h1>
            </div>
            
            <div class="footer-modal">
                <button onclick="borrarGimcana()">Borrar</button>
            </div>

            `
            modal.style.display = "block";
        }

    }
    ajax.send();
}

function getStatusGincana () {
    var ajax = new XMLHttpRequest();
    ajax.open('GET', "getStatusGincana");
    ajax.onload = function() {
        gimcanaPrueba = JSON.parse(ajax.responseText)[0];
        pruebaActual = JSON.parse(ajax.responseText)[1];
        pruebasTotales = JSON.parse(ajax.responseText)[2];
        if(gimcanaPrueba == 0) {
            document.getElementById('btn-gimcana').innerHTML = "Empezar gimcana";
            document.getElementById('btn-gimcana').onclick = empezarGimcana;
        } else {
            document.getElementById('btn-gimcana').innerHTML = "Ver pista";
            document.getElementById('btn-gimcana').onclick = verPista;
        }
    }
    ajax.send();
}

function empezarGimcana() {
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "insertarRegistro");
    var form = new FormData();
    form.append("_token", csrf_token)
    ajax.onload = function(){
        if(ajax.responseText == "OK"){
            getStatusGincana();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Gincana creada correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        }else if(ajax.responseText == "notGrupo"){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Para crear una gimcana tienes que tener un grupo asignado',
                showConfirmButton: false,
                showConfirmButton: true,
            })
        }
    }
    ajax.send(form)
}

function borrarGimcana() {
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "eliminarRegistro");
    var form = new FormData();
    form.append("_token", csrf_token)
    form.append("_method", "DELETE")
    ajax.onload = function(){
        if(ajax.responseText == "OK"){
            getStatusGincana();
            modal.style.display = "none";
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Gimcana eliminada correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        }
    }
    ajax.send(form)
}

function verPista() {
    var ajax = new XMLHttpRequest();
    ajax.open('POST', "checkPassToRound");
    var form = new FormData();
    form.append("_token", csrf_token)
    form.append("prueba", pruebaActual.id)
    ajax.onload = function(){
        console.log(ajax.responseText)
        if(ajax.responseText){
            if(
                
            ){

            }
            
            document.getElementById('contenido-modal').innerHTML = 
            
            `<div class="titulo-modal">
                <h4>${pruebaActual["texto_pista"]}</h4>
            </div>`
        
            modal.style.display = "block";
        }else{
            if(pruebaActual == 1){
                text = "Para empezar todos los usuarios de este grupo tienen que iniciar la gimcana";
            }else{
                text = "Todos los integrantes del grupo debeis estar en la misma prueba";
            }
            document.getElementById('contenido-modal').innerHTML = 
            
            `<div class="titulo-modal">
                <h4>${text}</h4>
            </div>`
        
            modal.style.display = "block";
        }
    }
    ajax.send(form)

}


//#region Modal

span.onclick = function() {
    modal.style.display = "none";
}

// Cuando el usuario hace clic en cualquier parte fuera del modal, cerrarlo
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
//endregion

window.onload = function() {
    getStatusGincanaStart();
}

