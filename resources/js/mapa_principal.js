const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
// L.Control.geocoder().addTo(map);
var marker, circle, lat, long, accuracy, waypoints, Routing, layer, color, fav;
fav = 0;
//Filtros del mapa
var csrf_token = token.content;
filtro_nombre.addEventListener('keyup', () => {
    if (fav == 1) {
        filtrar(fav)
    } else {
        filtrar('')
    }
})

filtro_etiqueta.addEventListener('change', () => {
    if (fav == 1) {
        filtrar(fav)
    } else {
        filtrar('')
    }
})
filtro_opinion.addEventListener('change', () => {
    if (fav == 1) {
        filtrar(fav)
    } else {
        filtrar('')
    }
})


function filtrar(fav) {
    var ajax = new XMLHttpRequest();
    let formdata = new FormData;
    formdata.append("_token", csrf_token);
    formdata.append('filtro_nombre', filtro_nombre.value)
    formdata.append('filtro_etiqueta', filtro_etiqueta.value)
    formdata.append('filtro_opinion', filtro_opinion.value)
    formdata.append('filtro_favorito', fav)
    ajax.open('POST', "filtro_mapa_principal");

    ajax.onload = function() {
        data = JSON.parse(ajax.responseText)
        layerGroup.clearLayers();
        try {
            if (data[0].color == null && fav !== 1) {
                color = 'black';
            } else if (fav == 1) {
                color = 'gold';
            } else {
                color = data[0].color
            }
            var icones = new L.Icon({
                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${color}.png`,
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var mymarker = L.marker([element.latitud, element.longitud], { icon: icones }).addTo(layerGroup);

                mymarker.bindPopup("<b>" + element.nombre + "</b> <input type='button' onclick=modal(" + (element.id) + ") value='Detalles' id='VerDetalles'>");
            }

        } catch (e) {
            console.log(e);
        }


    }
    ajax.send(formdata);
}
if (fav == 1) {
    filtrar(fav)
} else {
    filtrar('')
}

function modal(id) {

    var datos_modal = document.getElementById('datos_modal');

    var ajax = new XMLHttpRequest();

    let formdata = new FormData;
    formdata.append("_token", csrf_token);
    formdata.append("id", id);

    ajax.open('POST', "recoger_datos_etiqueta");

    ajax.onload = function() {
        data = JSON.parse(ajax.responseText)
        var modal1 = ``;
        modal1 += `
                            
            <div id="ModalDetalles" class="modal" style="width: auto; height: auto; margin-top: 7vh; margin-left: 1vh;">

                <div class="modal-content" id="modal-content" style="align-items: center; width:400px">
                    <div class="modal-header" style="width: 100%; display: inline;">
                        <span class="close">&times;</span>
                        <h2 style=" margin-right: 20%;">${data.nombre}</h2>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <div class="info" id="form" style="width: 23rem;">
                
                
                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">${data.descripcion}</h5>
                        <div style="display: flex; justify-content: space-between;">
                            <h4 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Opinión: </h4>
                            <h4 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">`
        if (data.etiquetas == null) { modal1 += `-` } else { modal1 += data.etiquetas }
        modal1 += `</h4>
                        </div>
                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; display: flex; justify-content: space-between;">Danos tu opinión!!<button style="width: 40%" class="btn btn-warning" onclick=opinion(${data.id})><i class="fa-solid fa-message"></i></button></h5>
                            <div style="display: flex; justify-content: space-between;">
                                <button style="width: 40%" class="btn btn-success" id="btnRuta" onclick=routae(${data.id})  ><i class="fa-solid fa-location-dot"></i></button>
                                <button onclick=favoritos(${data.id}) style="width: 40%" class="btn btn-success" id="btnFavorito" ><i class="fa-solid fa-heart"></i></button>
                            </div>
                        </div>
                
                    </div>
            
                </div>
            
            </div>

        `


        datos_modal.innerHTML = modal1;


        var modal = document.getElementById("ModalDetalles");

        var btn = document.getElementById("VerDetalles");

        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";

            var x = window.matchMedia("(max-width: 700px)")
            myFunction(x) // Call listener function at run time
            x.addListener(myFunction)

            function myFunction(x) {
                if (x.matches) { // If media query matches
                    // console.log(document.getElementById('modalsi'));

                    document.getElementById('modal-content').style.width = '46vh';
                    document.getElementById('ModalDetalles').style.width = '95%';
                    document.getElementById('form').style.width = '100%';
                }
            }
        }
        btn.click();
        span.onclick = function() {
            modal.style.display = "none";
        }
        if (data.punto == data.id) {
            document.getElementById("btnFavorito").classList.add("btn-danger");
        } else {
            // document.getElementById("btnFavorito").classList.add("btn-alert");
        }

    }
    ajax.send(formdata);

}





function getPosition(position) {
    lat = position.coords.latitude
    long = position.coords.longitude
    map.panTo([lat, long]);
    // if (marker) {
    //     map.removeLayer(marker)
    // }

    // marker = L.marker([lat, long])

    // var featureGroup = L.featureGroup([marker]).addTo(map)

    // map.fitBounds(featureGroup.getBounds())
}

function routae(id) {
    var modal = document.getElementById("ModalDetalles");
    var ajax = new XMLHttpRequest();
    let formdata = new FormData;
    formdata.append("_token", csrf_token);
    formdata.append("id", id);
    ajax.open('POST', "recoger_datos_etiqueta");
    ajax.onload = function() {
        data = JSON.parse(ajax.responseText);
        modal.style.display = "none";
        navigator.geolocation.getCurrentPosition(getPosition);
        routeControl = L.Routing.control({
            waypoints: [
                L.latLng(lat, long),
                L.latLng(data.latitud, data.longitud)
            ],
            router: osrRouter,
            profile: routingprofile,
            router: new L.Routing.osrmv1({
                language: 'en',
                profile: 'foot-walking',
            }),

        }).addTo(map);

        setInterval(() => {
            navigator.geolocation.getCurrentPosition(getPosition);
            var newLat = lat;
            var newLng = long;
            routeControl.setWaypoints([
                L.latLng(newLat, newLng),
                routeControl.options.waypoints[1]
            ]);
        }, 1000);
    }
    ajax.send(formdata);
}




function favoritos(id) {
    var ajax = new XMLHttpRequest();
    let formdata = new FormData;
    formdata.append("id_punt", id);
    formdata.append("_token", csrf_token);
    ajax.open('POST', "darFavorito");
    ajax.onload = function() {

        if (ajax.responseText == "delete") {
            document.getElementById("btnFavorito").classList.remove("btn-danger");
        } else if (ajax.responseText == "saved") {
            document.getElementById("btnFavorito").classList.add("btn-danger");
        }
    }
    ajax.send(formdata);
}

const boton = document.getElementById("likes");

boton.addEventListener("click", function() {
    if (boton.classList.contains("activo")) {
        boton.classList.remove("activo");
        boton.classList.add("desactivo");
        fav = 0;
        filtrar(fav);
    } else {
        boton.classList.remove("desactivo");
        boton.classList.add("activo");
        fav = 1;
        filtrar(fav);
    }
})

//Usuario introducido (Register)
function registradocorrect() {
    Swal.fire({
        icon: 'success',
        title: 'Usuario registrado y logueado!',
        showConfirmButton: false,
        timer: 1500
    })
}

function opinion(id) {
    Swal.fire({
        title: 'Danos tu opinión!!!',
        html: `<input type="text" id="login" class="swal2-input" placeholder="Encantado!!">`,
        confirmButtonText: 'Guardar',
        focusConfirm: false,
        preConfirm: () => {
            const login = Swal.getPopup().querySelector('#login').value
            if (!login) {
                Swal.showValidationMessage(`Porfavor opina`)
            }
            return { login: login }
        }
    }).then((result) => {
        Swal.fire(`
          Opinión: ${result.value.login}
        `.trim())

        var ajax = new XMLHttpRequest();
        let formdata = new FormData;

        formdata.append("opinion", result.value.login);
        formdata.append("id_punt", id);
        formdata.append("_token", csrf_token);

        ajax.open('POST', "darOpinion");
        ajax.onload = function() {
            window.location.reload();
        }
        ajax.send(formdata);
    })

}