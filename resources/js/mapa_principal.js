const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);







function filtrar() {
    var ajax = new XMLHttpRequest();
    let formdata = new FormData;

    ajax.open('POST', "filtro_mapa_principal");

    ajax.onload = function() {
        data = JSON.parse(ajax.responseText)
        console.log(ajax.responseText);

    }
    ajax.send(formdata);

}