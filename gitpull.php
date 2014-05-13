<?php
$sh_out  = exec('git pull origin master');
exec('/usr/bin /var/www/curul501/gitpull.sh');
$data    = array("response" => true, "sh" => $sh_out, "sh2" => $sh_out2);

echo json_encode($data);

//test 123


