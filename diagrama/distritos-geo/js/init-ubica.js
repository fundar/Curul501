var sMarker = false;
var primera = [2, 3, 8, 10, 14, 18, 25, 26];
var segunda = [1, 5, 11, 19, 22, 24, 28, 32];
var tercera = [4, 7, 20, 23, 27, 30, 31];
var cuarta  = [9, 12, 17, 21, 29];
var quinta  = [6, 13, 15, 16];

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
			fillOpacity: 0, opacity: 0.1, weight: 1.2, color: "#432B4D", fillColor: "#3E2F52"
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
				if(primera.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					console.log("Circunscripción: Primera");
				} else if(segunda.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					console.log("Circunscripción: Segunda");
				} else if(tercera.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					console.log("Circunscripción: Tercera");
				} else if(cuarta.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					console.log("Circunscripción: Cuarta");
				} else if(quinta.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					console.log("Circunscripción: Quinta");
				}
				
				jQuery(".map-info-representante").html("Estado :" +  sMarker.options.NOMBRE +", Distrito: " + resultDisrtPip[0].feature.properties.DISTRITO);
			} else {
				console.log("Asegurate de estar en territorio mexicano");
			}
		});
	} else {
		console.log("Asegurate de estar en territorio mexicano");
	}
}
