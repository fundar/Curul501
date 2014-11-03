<?php
	//include configs
	include_once "config/config.php";
	
	//create instance
	require("IXR_Library.php");
	$client = new IXR_Client($config["url"]);
	
	//Insert post
	$content['title']         = 'Test title' . mt_rand();
	$content['categories']    = array("NewCategory", "Nothing");
	$content['description']   = '<p>Lorem ipsum dolor sit amet</p>';
	$content['custom_fields'] = array(array('key' => 'my_custom_fied', 'value'=>'yes'));
	$content['mt_keywords']   = array('foo', 'bar');
	
	if(!$client->query('metaWeblog.newPost','', $config["user"], $config["pass"], $content, true))  {
		die( 'Error while creating a new post' . $client->getErrorCode() . " : " . $client->getErrorMessage());  
	}
	
	$ID = $client->getResponse();
	
	if($ID) {
		echo 'Post published with ID:#'.$ID;
	}
