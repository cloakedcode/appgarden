<?php

class OK_Router
{
	function root($params)
	{
		Oak::route('GET /', $params);
	}

	function connect($url, $defaults = array(), $requirements = array())
	{
		Oak::route($url, $defaults, $requirements);
	}

	static function _routeAction($params)
	{
		Oak::$params = $params;

		$controller = Oak::camelize($params['controller']).'Controller';
		$action = $params['action'];

		$class = new $controller;

		if (empty($class) || $class->callAction($action) === false)
		{
			Oak::error(404);
		}

	}
}

?>
