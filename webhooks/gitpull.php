<?php
$sh_out = exec('git pull origin master');
$data   = array("response" => true, "sh" => $sh_out);

echo json_encode($data);

//test
