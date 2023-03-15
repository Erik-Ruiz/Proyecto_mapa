var estatus = 0;
var gimcanaPrueba;
var pruebasTotales;

var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

function getStatusGincana () {
    var ajax = new XMLHttpRequest();
    ajax.open('GET', "getStatusGincana");

    ajax.onload = function() {
        gimcanaPrueba = JSON.parse(ajax.responseText)[0];
        pruebasTotales = JSON.parse(ajax.responseText)[1];

        if(gimcanaPrueba == 0) {
            document.getElementById('btn-gimcana').innerHTML = "Empezar gimcana";
            document.getElementById('btn-gimcana').onclick = empezarGimcana;
        } else {
            document.getElementById('btn-gimcana').innerHTML = "Ver pista";
            document.getElementById('btn-gimcana').onclick = verPista;
            document.getElementById('contenido-modal').innerHTML = "Quieres borrar la partida?"
            modal.style.display = "block";
        }



    }
    ajax.send();
}

function empezarGimcana() {
    console.log("e")
}

function verPista() {
    console.log("a")
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
    getStatusGincana();
}

