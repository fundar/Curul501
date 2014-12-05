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
			getPip(e.latlng.lat, e.latlng.lng);
			map.setView(new L.LatLng(e.latlng.lat, e.latlng.lng), map._zoom);
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
			var district = resultDisrtPip[0].feature.properties.DISTRITO;
			var state = parseInt(resultPip[0].feature.properties.CVE_ENT);
			
			if(resultDisrtPip.length) {
				if(primera.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					var circum = "Primera";
				} else if(segunda.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					var circum = "Segunda";
				} else if(tercera.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					var circum = "Tercera";
				} else if(cuarta.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					var circum = "Cuarta";
				} else if(quinta.indexOf(parseInt(resultPip[0].feature.properties.CVE_ENT)) != -1) {
					var circum = "Quinta";
				} else {
					var circum = "";
				}
				
				var results = jQuery(representatives).filter(function (i, value) {
					return (value.clave_estado == state && value.circum == circum) || (value.clave_estado == state && value.district == district);
				});
				
				var html = "";
				
				jQuery.each(results, function( index, value ) {
					html += "<div class='representante-mapa'>";
					html += "<img style='width:50px; height:50px;' src='" + value.avatar_url + "' alt='" + value.name + "'/><br/>";
					html += "<a href='" + value.permalink + "' title='" + value.name + "'>" + value.name + "</a><br/>";
					html += "Tipo de elección: " + value.election_type + "<br/>";
					
					if(value.circum == "") {
						html += "Distrito: " + value.district + "<br/>";
					} else {
						html += "Circunscripción: " + value.circum + "<br/>";
					}
					
					html += "Tipo de elección: " + value.election_type + "<br/>";
					html += "Estado: " + value.zone_state + "<br/>";
					html += "Partido politico: " + value.politicalParty.name + "<br/>";
					html += "<img src='http://curul501.org/wp-content/themes/curul501/images/" + value.politicalParty.url_logo + "' alt='" + value.politicalParty.name + "'/><br/>";
					html += "</div>";
				});
				
				jQuery(".map-info-representante").html(html);
			} else {
				console.log("Asegurate de estar en territorio mexicano");
			}
		});
	} else {
		console.log("Asegurate de estar en territorio mexicano");
	}
}
