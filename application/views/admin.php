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
	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}

#map { position:relative; bottom:0; width:400px; height:400px; float:left; }
</style>
</head>
<body>
	<div id="container">
		<?php $this->load->view('menu.php', $output); ?>
		<div style='height:20px;'></div>  
		<div>
			<?php echo $output; ?>
		</div>
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
