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
		if(document.getElementById('map')) {
			var map = L.mapbox.map('map', 'examples.map-20v6611k').setView([19.43268648150198, -99.13318455219269], 6);

			var marker = L.marker(new L.LatLng(19.43268648150198, -99.13318455219269), {
				icon: L.mapbox.marker.icon({'marker-color': 'CC0033'}),
				draggable: true
			});

			marker.bindPopup('Mueve el marcador para ubicar al representante');
			marker.addTo(map);
		}
	</script>
</body>
</html>
