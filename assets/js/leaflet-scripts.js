var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Control listings'
    }),
    latlng = L.latLng(defaultaddressPoints[0], defaultaddressPoints[1]);

var map = L.map('controlListingsMap', {center: latlng, zoom: 8, layers: [tiles]});

var markers = L.markerClusterGroup({
    maxClusterRadius: 120,
    singleMarkerMode: false
});

for (var i = 0; i < addressPoints.length; i++) {
    var a = addressPoints[i];
    var title = a[2];   

    var listingIcon = L.divIcon({
        html: a.marker,
        iconSize: [50, 50],
        iconAnchor: [18, 32],
        popupAnchor: [130, -25],
        className: 'ctrl-listings-marker-icon'
    });
    var marker = L.marker(new L.LatLng(a[0], a[1]), { title: title, icon: listingIcon }); 
    
    marker.bindPopup(a.content);
    markers.addLayer(marker);
}


map.addLayer(markers);


