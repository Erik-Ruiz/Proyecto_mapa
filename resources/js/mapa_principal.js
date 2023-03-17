const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
// L.Control.geocoder().addTo(map);
var marker, circle, lat, long, accuracy, waypoints, Routing, layer;




//Filtros del mapa
var csrf_token = token.content;
filtro_nombre.addEventListener('keyup', () => {
    filtrar('')
})

filtro_etiqueta.addEventListener('change', () => {
    filtrar('')
})
filtro_opinion.addEventListener('change', () => {
    filtrar('')
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
            if (data[0].color == null) {
                var color = 'black';
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
filtrar('');

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
                            
            <div id="ModalDetalles" class="modal" style="width: 400px; height: 500px; margin-top: 50px; margin-left: 10px;">

                <div class="modal-content" style="align-items: center; width:400px">
                    <div class="modal-header" style="width: 100%; display: inline;">
                        <span class="close">&times;</span>
                        <h2 style=" margin-right: 20%;">${data.nombre}</h2>
                    </div>
                    <div class="modal-body">
                        <div id="form" style="width: 23rem;">
                
                
                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">${data.descripcion}</h5>
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


function routae(id) {
    var ajax = new XMLHttpRequest();
    let formdata = new FormData;
    formdata.append("_token", csrf_token);
    formdata.append("id", id);
    ajax.open('POST', "recoger_datos_etiqueta");
    ajax.onload = function() {
        data = JSON.parse(ajax.responseText);
        navigator.geolocation.getCurrentPosition(getPosition);
        routeControl = L.Routing.control({
            waypoints: [
                L.latLng(lat, long),
                L.latLng(data.latitud, data.longitud)
            ],
            router: new L.Routing.osrmv1({
                language: 'en',
                profile: 'foot'
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
        }, 5000);
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
var fav = 0;

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


function getPosition(position) {
    lat = position.coords.latitude
    long = position.coords.longitude
    accuracy = position.coords.accuracy

    if (marker) {
        map.removeLayer(marker)
    }

    marker = L.marker([lat, long])

    var featureGroup = L.featureGroup([marker]).addTo(map)

    map.fitBounds(featureGroup.getBounds())
}