<?php
//include configs
include_once "config/config.php";

//create instance
require("IXR_Library.php");
$client = new IXR_Client($config["url"]);

//Insert post
$content['title']         = "asasda";
$content['custom_fields'] = array(
	array('key' => 'id_initiative', 'value' => "asdadssad"),
	array('key' => 'titulo', 'value' => "asdasdda")
);

$content['categories']    = array("NewCategory", "Nothing");
$content['custom_fields'] = array( array('key' => 'my_custom_fied','value'=>'yes') );
$content['description']   = '<p>Lorem ipsum dolor sit amet</p>';
$content['mt_keywords']   = array('foo', 'bar');

if(!$client->query('metaWeblog.newPost', '', $config["user"], $config["pass"], $content, true))  {
	echo '<p>Error while creating a new post ' . $client->getErrorCode() . " : " . $client->getErrorMessage() . ' <a href="http://curul501-admin.fundarlabs.mx/admin/initiatives_scrapper_true">Regresar</a></p>';
	die("");
}

$ID = $client->getResponse();

if($ID) {
	echo '<p>Post published with ID:#' . $ID . ' <a href="http://curul501-admin.fundarlabs.mx/admin/initiatives_scrapper_true">Regresar</a></p>';
} else {
	echo '<p>Error al insertar el registro. <a href="http://curul501-admin.fundarlabs.mx/admin/initiatives_scrapper_true">Regresar</a></p>';
}
