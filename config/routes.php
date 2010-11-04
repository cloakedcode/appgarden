<?php

$router->root('seeds#index');

$router->connect('GET|POST /:controller/:action/:id');

// The next two are equivalent but the first is much easier to read and type. Double win!
$router->connect('GET|POST /:controller/:action', '#index');
// $router->connect(':controller/:action', array('action' => 'index'));

?>
