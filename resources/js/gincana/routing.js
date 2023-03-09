/* var map = L.map('map');

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

L.Routing.control({
    waypoints: [
        L.latLng(41.38254349956717, 2.186150194834897),
        L.latLng(41.3842652269854, 2.1811850599740614)
    ],
    routeWhileDragging: true
}).addTo(map); */

var map = L.map('map');

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

L.Routing.control({
    waypoints: [
        L.latLng(41.38211, 2.18548) ,
        L.latLng(41.38458, 2.18128)
    ],
    routeWhileDragging: true
}).addTo(map);
