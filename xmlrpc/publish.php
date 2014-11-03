<?php
	//include configs
	include_once "config/config.php";
	
	//create instance
	require("IXR_Library.php");
	$client = new IXR_Client($config["url"]);
	
	if(isset($_GET["titulo"]) and isset($_GET["id_initiative"]) and is_numeric($_GET["id_initiative"]) and $_GET["titulo"] != "") {
		//Insert post
		$content['title']         = $_GET["titulo"];
		$content['custom_fields'] = array(array('id_initiative' => $_GET["id_initiative"]));
		
		//$content['categories']    = array("NewCategory", "Nothing");
		//$content['description']   = '<p>Lorem ipsum dolor sit amet</p>';
		//$content['mt_keywords']   = array('foo', 'bar');
		
		if(!$client->query('metaWeblog.newPost','', $config["user"], $config["pass"], $content, true))  {
			die( 'Error while creating a new post' . $client->getErrorCode() . " : " . $client->getErrorMessage());  
		}
		
		$ID = $client->getResponse();
		
		if($ID) {
			echo '<p>Post published with ID:#' . $ID . '<a href="http://curul501-admin.fundarlabs.mx/admin/initiatives_scrapper_true">Regresar</a></p>';
		}
	} else {
		echo '<p>Error al insertar el registro. <a href="http://curul501-admin.fundarlabs.mx/admin/initiatives_scrapper_true">Regresar</a></p>';
	}
	
	
