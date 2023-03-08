const apiKey = "YOUR_API_KEY";
const map = L.map("map").setView([40.725, -73.985], 13);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);


map.on("click", function (e) {
    L.esri.Geocoding
        .reverseGeocode({
            apikey: apiKey
        })
        .latlng(e.latlng)
        .run(function (error, result) {
            if (error) {
                return;
            }

            L.marker(result.latlng).addTo(map).bindPopup(result.address.Match_addr).openPopup();
        });
});
