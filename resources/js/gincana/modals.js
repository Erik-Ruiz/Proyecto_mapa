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
            
            document.getElementById('contenido-modal').innerHTML = 
            
            `<div class="titulo-modal">
                <h1>¿Estas seguro que quieres borrar la partida? </h1>
            </div>
            
            <div class="footer-modal">
                <button onclick="borrarGimcana()">Borrar</button>
            </div>`

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
    document.getElementById('contenido-modal').innerHTML = 
            
    `<div class="titulo-modal">
        <h4>${pruebaActual["texto_pista"]}</h4>
    </div>`

    modal.style.display = "block";
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

