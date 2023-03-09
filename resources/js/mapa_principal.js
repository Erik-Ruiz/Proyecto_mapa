const map = L.map('map').setView([41.38710079433486, 2.183035577913213], 15);
var layerGroup = L.layerGroup().addTo(map);
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

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
        console.log(data);
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

function modal(id){

    var resultado= document.getElementById('datos_modal');

    var ajax = new XMLHttpRequest();

    let formdata = new FormData;
    formdata.append("_token", csrf_token);
    formdata.append("id", id);

    ajax.open('POST', "recoger_datos_etiqueta");

    ajax.onload = function() {
        // console.log(ajax.responseText);
        data = JSON.parse(ajax.responseText)
        console.log(data);
        
            var modal1=``;


            modal1 += `
                        
                <div id="ModalDetalles" class="modal">

                    <div class="modal-content" style="align-items: center; width:500px">
                    <div class="modal-header" style="width: 100%;">
                        <span class="close">&times;</span>
                        <h2 style=" margin-right: 50%;">${data.nombre}</h2>
                    </div>
                    <div class="modal-body">
                        <div id="form" style="width: 23rem;">
                
                
                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Correo</h3>
                
                        <button style="width: 100%" class="btn btn-success" id="form_correo_btn" ><i class="fa-solid fa-envelope"></i></button>
                
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


    
