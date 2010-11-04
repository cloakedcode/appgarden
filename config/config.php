<?php

// Set the environment.
$config['env'] = 'debug';

// Set-up a whole bunch of database configurations.
$databases = array(
	'debug' => array(
		'adapter' =>'mysql',
		'host' =>'localhost',
		'database' => 'appgarden',
		'user' => 'root',
		'password' => 'beer'
		)
);

// Set database config based on current environment. Allows for multiple database configurations like RoR.
$config['database'] = $databases[$config['env']];

if ($config['env'] === 'debug')
{
	ini_set('display_errors', true);
	error_reporting(E_ALL);
}

?>
