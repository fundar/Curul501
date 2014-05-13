<?php

$sh_out = shell_exec('cd /var/www/curul501 | git pull origin master');
$data   = array("response" => true, "sh" => $sh_out);

echo json_encode($data);

