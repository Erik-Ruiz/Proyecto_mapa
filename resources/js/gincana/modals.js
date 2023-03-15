var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

// Cuando el usuario hace clic en cualquier parte fuera del modal, cerrarlo
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function getPuntosInteres(){

    var ajax = new XMLHttpRequest();
    ajax.open('GET', "pagina_gincana");
    ajax.onload = function() {
        var data = JSON.parse(ajax.responseText);

        for (let index = 0; index < data.length; index++) {

            const element = data[index];
            var mymarker = L.marker([(element.latitud), (element.longitud)]).addTo(map);

            mymarker.bindPopup("<b>" + element.nombre + "</b>");
        }

        document.getElementsByClassName("leaflet-routing-container")[0].style.display = "none";

    }
    ajax.send();
}

L.Routing.control({
    waypoints: [
        L.latLng(41.38211, 2.18548) ,
        L.latLng(41.38211, 2.18548)
    ],
    routeWhileDragging: true

}).addTo(map);

//#endregion

map.on("click", function (e) {

    L.Routing.control({
        waypoints: [
            L.latLng(41.38458, 2.18128),
            L.latLng((e.latlng.lat), (e.latlng.lng))
        ],
        routeWhileDragging: true
    }).addTo(map);

    console.log(map);
});

getPuntosInteres();

//#region no abrir
