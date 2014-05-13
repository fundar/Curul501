<?php
$sh_out  = exec('git pull origin master');
$sh_out2 = exec('git pull');
$data    = array("response" => true, "sh" => $sh_out, "sh2" => $sh_out2);

echo json_encode($data);

//test 123
