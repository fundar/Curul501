function setMap(state, distritc) {
	var map = L.map('map').setView([22.674847351188536, -101.77734374999999], 5);

	L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
		maxZoom: 12,
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="http://mapbox.com">Mapbox</a>',
		id: 'examples.map-20v6611k'
	}).addTo(map);
	
	function onEachFeature(feature, layer) {
		if(feature.properties.DISTRITO == distritc) {
			layer.setStyle({
				fillOpacity: 0.9, opacity: 0.5, weight: 1.2, color: "#432B4D", fillColor: "#3E2F52"
			});
			
			if(parseInt(state) == 6) map.fitBounds(layer);
		} else {
			layer.setStyle({
				fillOpacity: 0.5, opacity: 0.5, weight: 0.6, color: "#432B4D", fillColor: "#887196"
			});
		}
	}

	var geojson = L.geoJson(distritosGeoJson, {
		onEachFeature: onEachFeature
	}).addTo(map);

	if(parseInt(state) != 6) map.fitBounds(geojson);
}
