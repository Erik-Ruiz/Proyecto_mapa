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
            
            document.getElementById('contenido-modal').innerHTML = 
            
            `<div class="titulo-modal">
                <h1>¿Estas seguro que quieres borrar la partida? </h1>
            </div>
            
            <div class="footer-modal">
                <button id="delete_registro">Borrar</button>
            </div>`

            modal.style.display = "block";
        }

    }
    ajax.send();
}

function empezarGimcana() {
    
    var ajax = new XMLHttpRequest();

    ajax.open('POST', "insertarRegistro");
    ajax.onload = function(){
        if(ajax.responseText == "OK"){
            
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Gincana Creada Correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        }
    }
}

function verPista() {
    console.log("a")
}


//#region Modal

// delete_registro.onclick = function() {

// }

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

