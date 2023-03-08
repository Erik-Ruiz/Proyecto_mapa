const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var csrf_token = token.content;


filtro_nombre.addEventListener('keyup',()=>{
    filtrar()
})


filtro_etiqueta.addEventListener('change',()=>{
    filtrar()
})

filtro_opinion.addEventListener('change',()=>{
    filtrar()
})



function filtrar() {
    var ajax = new XMLHttpRequest();

    let formdata = new FormData;
    formdata.append("_token", csrf_token);

    formdata.append('filtro_nombre',filtro_nombre.value)
    formdata.append('filtro_etiqueta',filtro_etiqueta.value)
    formdata.append('filtro_opinion',filtro_opinion.value)

    ajax.open('POST', "filtro_mapa_principal");

    ajax.onload = function() {
        // console.log(ajax.responseText);
        data = JSON.parse(ajax.responseText)

        layerGroup.clearLayers();
        try {

            for (let index = 0; index < data.length; index++) {
                const element = data[index];

               var mymarker = L.marker([element.coordenadas.split(",")[0], element.coordenadas.split(",")[1]]).addTo(layerGroup);

                mymarker.bindPopup("<b>" + element.nombre + "</b>");

            }
        } catch (e) {
            console.log(e);
        }
    }
    ajax.send(formdata);

}
filtrar('');