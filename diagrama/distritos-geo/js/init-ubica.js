var sMarker = false;

function setMap() {
	var map = L.map('map').setView([22.674847351188536, -101.77734374999999], 5);
	
	L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
		maxZoom: 15,
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="http://mapbox.com">Mapbox</a>',
		id: 'examples.map-20v6611k'
	}).addTo(map);

	function onEachFeature(feature, layer) {
		layer.setStyle({
			fillOpacity: 0, opacity: 0.1, weight: 1, color: "#432B4D", fillColor: "#3E2F52"
		});
		
		layer.on('click', function(e) {
			map.removeLayer(sMarker);
			
			sMarker = L.marker([e.latlng.lat, e.latlng.lng], { CVE_ENT : feature.properties.CVE_ENT, NOMBRE : feature.properties.NOMBRE }).addTo(map);
			sMarker.bindPopup("<div class='map-info-representante'>" + feature.properties.NOMBRE + "</div>").openPopup();
			
			getPip(e.latlng.lat, e.latlng.lng);
		});
	}
	
	var geojson = L.geoJson(GeoJson, {
		onEachFeature: onEachFeature
	}).addTo(map);
}


function getPip(lat, lng) {
    var estadosLayer = L.geoJson(GeoJson);
    var resultPip 	 = leafletPip.pointInLayer([lng, lat], estadosLayer);
    
    if(resultPip.length) {
		jQuery.getJSON("js/geojson/estado-" + resultPip[0].feature.properties.CVE_ENT + ".geojson")
		.success(function (distritosGeoJson) {
			var distritosLayer = L.geoJson(distritosGeoJson);
			var resultDisrtPip = leafletPip.pointInLayer([lng, lat], distritosLayer);
			
			if(resultDisrtPip.length) {
				jQuery(".map-info-representante").html("Estado :" +  sMarker.options.NOMBRE +", Distrito: " + resultDisrtPip[0].feature.properties.DISTRITO);
			} else {
				console.log("Asegurate de estar en territorio mexicano");
			}
		});
	} else {
		console.log("Asegurate de estar en territorio mexicano");
	}
}
