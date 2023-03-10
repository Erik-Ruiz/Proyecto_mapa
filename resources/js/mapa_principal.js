const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
L.Control.geocoder().addTo(map);
// if (!navigator.geolocation) {
//     console.log("Your browser doesn't support geolocation feature!")
// } else {
//     setInterval(() => {
//         navigator.geolocation.getCurrentPosition(getPosition)
//     }, 5000);
// };
var marker, circle, lat, long, accuracy;

// function getPosition(position) {
//     // console.log(position)
//     lat = position.coords.latitude
//     long = position.coords.longitude
//     accuracy = position.coords.accuracy

//     if (marker) {
//         map.removeLayer(marker)
//     }

//     if (circle) {
//         map.removeLayer(circle)
//     }

//     marker = L.marker([lat, long])
//     circle = L.circle([lat, long], {
//         radius: accuracy
//     })

//     var featureGroup = L.featureGroup([marker, circle]).addTo(map)

//     map.fitBounds(featureGroup.getBounds())
//         // L.Routing.control({
//         //     waypoints: [
//         //         L.latLng(lat, long),
//         //         L.latLng(57.6792, 11.949)
//         //     ]
//         // }).addTo(map);
//         // console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)
// }

getLocation();

// function getLocation() {
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(showPosition);
//     }
// }

// function showPosition(position) {
//     document.getElementById("lat").value = position.coords.latitude
//     document.getElementById("lon").value = position.coords.longitude;
//     // if (1 == 2) {
//     //     L.Routing.control({
//     //         waypoints: [
//     //             L.latLng(document.getElementById("lat").value, document.getElementById("lon").value),
//     //             L.latLng(57.6792, 11.949)
//     //         ]
//     //     }).addTo(map);
// }



//Filtros del mapa
var csrf_token = token.content;
filtro_nombre.addEventListener('keyup', () => {
    filtrar()
})

filtro_etiqueta.addEventListener('change', () => {
    filtrar()
})
filtro_opinion.addEventListener('change', () => {
    filtrar()
})


function filtrar() {
    var ajax = new XMLHttpRequest();

    let formdata = new FormData;
    formdata.append("_token", csrf_token);

    formdata.append('filtro_nombre', filtro_nombre.value)
    formdata.append('filtro_etiqueta', filtro_etiqueta.value)
    formdata.append('filtro_opinion', filtro_opinion.value)

    ajax.open('POST', "filtro_mapa_principal");

    ajax.onload = function() {
        data = JSON.parse(ajax.responseText)
        layerGroup.clearLayers();
        try {
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var mymarker = L.marker([element.latitud, element.longitud]).addTo(layerGroup);

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

    var resultado = document.getElementById('datos_modal');

    var ajax = new XMLHttpRequest();
}
let formdata = new FormData;
formdata.append("_token", csrf_token);
formdata.append("id", id);

ajax.open('POST', "recoger_datos_etiqueta");

ajax.onload = function() {
    // console.log(ajax.responseText);
    data = JSON.parse(ajax.responseText)
    console.log(data);

    ajax.onload = function() {
        // console.log(ajax.responseText);
        data = JSON.parse(ajax.responseText)
        console.log(data);

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
                                    <button style="width: 40%" class="btn btn-success" id="btnRuta" ><i class="fa-solid fa-location-dot"></i></button>
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

        span.onclick = function() {
            modal.style.display = "none";
        }
    }
    ajax.send(formdata);


}

function favoritos(id){
    var ajax = new XMLHttpRequest();
    let formdata = new FormData;
    formdata.append("id_punt",id);
    formdata.append("_token",csrf_token);
    ajax.open('POST', "darFavorito");
    ajax.onload=function (){
        if(ajax.responseText == "delete"){
            document.getElementById("btnFavorito").classList.remove("btn-warning");
        }else if(ajax.responseText == "saved"){
            document.getElementById("btnFavorito").classList.add("btn-warning");
        }else{
            console.log(ajax.responseText);
        }
    }
    ajax.send(formdata);
}



    
