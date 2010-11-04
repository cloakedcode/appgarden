<?php

ini_set('session.save_path', 'sessions');

ini_set('date.timezone', 'America/New_York');
define('ROOT_DIR', dirname(__FILE__));

require('oak/oak.php');

$time = microtime(true);
Oak::run();
$duration = microtime(true) - $time;

echo "<!-- {$duration} -->";

?>
