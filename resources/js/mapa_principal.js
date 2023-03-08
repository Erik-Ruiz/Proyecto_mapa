const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var csrf_token = token.content;






function filtrar() {
    var ajax = new XMLHttpRequest();

    let formdata = new FormData;
    formdata.append("_token", csrf_token);

    ajax.open('POST', "filtro_mapa_principal");

    ajax.onload = function() {
        // console.log(ajax.responseText);
        data = JSON.parse(ajax.responseText)

        layerGroup.clearLayers();
        try {

            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                console.log(element);

               var mymarker = L.marker([element.coordenadas.split(",")[0], element.coordenadas.split(",")[1]]).addTo(layerGroup);
               console.log(element.coordenadas.split(",")[0]+'..'+'..'+element.coordenadas.split(",")[1]);

                mymarker.bindPopup("<b>" + element.nombre + "</b>");

            }
        } catch (e) {
            console.log(e);
        }
    }
    ajax.send(formdata);

}
filtrar('');