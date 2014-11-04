<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pulicación en WP Curul501.org</title>

	<style type="text/css">

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
	
	.red { color:#D89A9A; }
	</style>
</head>
<body>

<div id="container">
	<?php $this->load->view('menu.php'); ?>
	
	<h1>Pulicación en WP Curul501.org</h1>
	
	<div id="body">		
		<?php if(isset($success)) { ?>
			<p>
				Se ha publicado la iniciativa <strong><?php echo $titulo;?></strong> correctamente con el ID: <strong><?php echo $ID;?></strong><br/>
				<a href="http://curul501.org/?p=<?php echo $ID;?>" target="_blank" title="<?php echo $titulo;?>">Ver post en Curul501.org</a>
			</p>
		<?php } ?>
		
		<?php if(isset($error)) { ?>
			<p class="red">
				<?php echo $error;?>
			</p>
		<?php } ?>
	</div>
	
</div>

</body>
</html>
