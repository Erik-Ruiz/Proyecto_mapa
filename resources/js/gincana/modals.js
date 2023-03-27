var estatus = 0;
var gimcanaPrueba;
var pruebaActual;
var pruebasTotales;
var csrf_token = token.content
var marker;
var lat = 41.391;
var long = 2.183;


var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

//const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
const map = L.map("map").setView([lat, long], 15);
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
            //document.getElementById("btn-localizacion").disabled = false;
            //document.getElementById("btn-localizacion").onclick = checkPosition;
            
            document.getElementById('contenido-modal').innerHTML = 
            `<div class="titulo-modal">
                <h1>¿Estas seguro que quieres borrar la partida? </h1>
            </div>
            
            <div class="footer-modal">
                <button class="btn delete_btn" style="background-color: #B8E0C3;" onclick="borrarGimcana()">Borrar</button>
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
            document.getElementById("btn-localizacion").disabled = true;
        } else {
            document.getElementById('btn-gimcana').innerHTML = "Ver pista";
            document.getElementById('btn-gimcana').onclick = verPista;
            //document.getElementById("btn-localizacion").disabled = false;
            //document.getElementById("btn-localizacion").onclick = checkPosition;
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
            document.getElementById("btn-localizacion").disabled = false;
            document.getElementById("btn-localizacion").onclick = checkPosition;
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

function checkPosition(){
    navigator.geolocation.getCurrentPosition(e => {
            //posicionActualX = e.coords.latitude;
            //posicionActualY = e.coords.longitude;
            posicionActualX = 41.34884;
            posicionActualY = 2.10777;
            // posicionActualX = 41.3887;
            // posicionActualY = 2.183;
			puntoX = parseFloat(pruebaActual.latitud);
			puntoY = parseFloat(pruebaActual.longitud);
            rango = 0.00085;
            minLat =  puntoY - rango;
            minLong = puntoX - rango;
            maxLat = puntoY + rango;
            maxLong = puntoX + rango;
            console.log(minLat < posicionActualY && maxLat > posicionActualY)
            if( (minLat < posicionActualY && maxLat > posicionActualY) && (minLong < posicionActualX && maxLong > posicionActualX) )     {
                document.getElementById('contenido-modal').innerHTML = 
            
                `<div class="titulo-modal">
                    <h4>${pruebaActual["texto_pregunta"]}</h4>
                    <input type="text" id="inputRespuesta">
                    <button onclick="checkRespuesta()" type="button" class="btn gim-btn" style="background-color: #B8E0C3;">Enviar</button>
                </div>`
            
                modal.style.display = "block";
            }else{
                document.getElementById('contenido-modal').innerHTML = 
            
                `<div class="titulo-modal">
                    <h4>No estás dentro del rango</h4>
                </div>`
            
                modal.style.display = "block";
            }
            

    })           
}

function checkRespuesta(){
    respuesta = document.getElementById("inputRespuesta").value 
    respuesta = respuesta.toUpperCase();
    var ajax = new XMLHttpRequest();
    if(pruebasTotales == pruebaActual.id){
        ajax.open('POST', "insertarRegistroFinal");
    }else{
        ajax.open('POST', "pasoDePrueba");
    }
    var form = new FormData();
    form.append("_token", csrf_token)
    form.append("respuesta", respuesta)
    form.append("prueba", pruebaActual.id)
    ajax.onload = function(){
        modal.style.display = "none";
        if(ajax.responseText == "OK"){
            document.getElementById("btn-localizacion").disabled = true;
            document.getElementById("btn-localizacion").onclick = null;
            if(pruebasTotales == pruebaActual.id){
                textModal = "Felicidades, has completado la gimcana"
            }else{
                textModal = 'Respuesta correcta';
            }
            getStatusGincana();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: textModal,
                showConfirmButton: false,
                timer: 1500
            })
        }else if(ajax.responseText == "FALLO"){
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Respuesta errónea',
                showConfirmButton: false,
                showConfirmButton: true,
            })
        }else{
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Hubo un error inesperado',
                showConfirmButton: false,
                showConfirmButton: true,
            })
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

function getPosition() {
    navigator.geolocation.getCurrentPosition(e => {
        map.removeLayer(marker);
        marker = L.marker([e.coords.latitude, e.coords.longitude]).addTo(map);
    })


}

function getFirstPosition() {
    navigator.geolocation.getCurrentPosition(e => {
        marker = L.marker([e.coords.latitude,e.coords.longitude]).addTo(map);
    })
}
//endregion

window.onload = function() {
    navigator.geolocation.getCurrentPosition( e => {
        lat = e.coords.latitude
        long = e.coords.longitude
        map.setView([lat,long],17);
    })
    getStatusGincanaStart();
    getFirstPosition();
    setInterval(getPosition,2000);
}

