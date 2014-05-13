<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet' />
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}

#map { position:relative; bottom:0; width:400px; height:400px; float:left; }
</style>
</head>
<body>
	<div>
		<a href='<?php echo site_url('admin/political_parties')?>'>Partidos políticos</a> |
		<a href='<?php echo site_url('admin/legislatures')?>'>Legislaturas</a> |
		<a href='<?php echo site_url('admin/representatives')?>'>Representantes</a> |
		<a href='<?php echo site_url('admin/initiatives')?>'>Iniciativas</a>
	</div>
	
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
    
    <script>
		/*Creaando el mapa de mapbox si esta presenta el div#map y el input#latitude*/
		if(document.getElementById('map')) {
			if(document.getElementById("field-latitude").value == "") {
				var lat = 19.43268648150198;
				var lng = -99.13318455219269;
			} else {
				var lat = document.getElementById("field-latitude").value;
				var lng = document.getElementById("field-longitude").value;
			}
			
			var map = L.mapbox.map('map', 'examples.map-20v6611k').setView([lat, lng], 8);
			
			if(document.getElementById('field-state')) {
				var draggable = false;
			} else {
				var draggable = true;
			}
			
			var marker = L.marker(new L.LatLng(lat, lng), {
				icon: L.mapbox.marker.icon({'marker-color': 'CC0033'}),
				draggable: draggable
			});

			marker.bindPopup('Mueve el marcador para ubicar al representante');
			marker.addTo(map);
			
			marker.on('dragend', function(e){
				document.getElementById("field-latitude").value  = e.target._latlng.lat;
				document.getElementById("field-longitude").value = e.target._latlng.lng;
			});
		}
	</script>
</body>
</html>
