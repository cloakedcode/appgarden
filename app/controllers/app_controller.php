<?php

class AppController extends OK_Controller
{
	function __construct()
	{
		if (session_id() == null)
		{
			session_start();
		}
	}

	function beforeAction($action)
	{
		if (method_exists($this, $action) === false && method_exists($this, 'view'))
		{
			Oak::$params['id'] = $action;
			$action = 'view';
			Oak::$params['action'] = $action;
		}

		return $action;
	}
}

?>
