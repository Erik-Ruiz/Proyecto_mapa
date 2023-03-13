var map = L.map('map');
var latitud = 200;
var longitud = 200;


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

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
            L.latLng((e.latlng.lat), (e.latlng.lng)),
            L.latLng(41.38458, 2.18128)
        ],
        routeWhileDragging: true
    }).addTo(map);
    
    console.log(map);
});

getPuntosInteres();

//#region no abrir