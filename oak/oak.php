<?php

spl_autoload_register('oak_autoload');

define('OAK_DIR', dirname(__FILE__));

require(OAK_DIR.'/acorn.php');
include(OAK_DIR.'/router.php');

function oak_autoload($class)
{
	if ($class === 'OK_Controller')
	{
		return include(OAK_DIR.'/controller.php');
	}
	else if (substr($class, -10) === 'Controller')
	{
		return Oak::load('controller', substr($class, 0, -10));
	}

	return Oak::load('model', $class);
}

class Oak extends Acorn
{
	static public $router;
	static public $config = array();
	static public $params = array();

	static function _bootstrap()
	{
		static $strapped = false;

		if ($strapped === false)
		{
			$strapped = true;

			$router = new OK_Router;

			include(ROOT_DIR.'/config/routes.php');

			self::$router = $router;
			self::$cache_path = ROOT_DIR."/cache";
			self::$include_paths = array(ROOT_DIR."/app");

			AN_Event::addCallback('acorn.file_path', array('Oak', 'file_path'));
			AN_Event::addCallback('acorn.database', array('Oak', '_database'));
			AN_Event::addCallback('acorn.will_route_params', array('Oak', '_add_controller_to_params'));
			AN_Event::addCallback('acorn.did_load_file', array('Oak', '_load_controller_helper'));
			AN_Event::addCallback('acorn.will_route_params', array('Oak', '_to_url'));

			parent::_bootstrap();
		}
	}

	static function config($key, $file = 'config')
	{
		if (isset(self::$config[$file]) === false)
		{
			$config = array();

			include(ROOT_DIR."/config/{$file}.php");

			self::$config[$file] = $config;
			unset($config);
		}

		return (empty(self::$config[$file][$key])) ? null : self::$config[$file][$key];
	}

	static function _database(&$db)
	{
		static $database = null;

		if (empty($database))
		{
			$database = new AN_Database(self::config('database'));
		}

		$db = $database;

		return false;
	}

	static function file_path(&$params)
	{
		extract($params);

		if ($type === 'controller')
		{
			$name .= '_controller';
		}
		else if ($type === 'helper')
		{
			$name .= '_helpers';
		}

		if ($type === 'layout')
		{
			$filename = 'views/'.$type.'s/'.self::underscore($name).'.php';
		}
		else
		{
			$filename = $type.'s/'.self::underscore($name).'.php';
		}

		$path = parent::pathForFile($filename);

		if ($path !== false)
		{
			$params['path'] = $path;
			return false;
		}

		return true;
	}
	
	static function route($url, $defaults = array(), $regex = array())
	{
		$defaults = self::_route_defaults_to_array($defaults);
		$callback = array('OK_Router', '_routeAction');

		parent::route($url, $callback, $defaults, $regex);
	}

	static function _to_url(&$data)
	{
		$data['params'] = self::_route_defaults_to_array($data['params']);

		return true;
	}

	static function _add_controller_to_params(&$data)
	{
		if (empty($data['params']['controller']))
		{
			$data['params']['controller'] = self::$params['controller'];
		}
	}

	static function _load_controller_helper($file_path)
	{
		if (basename(dirname($file_path)) === 'controllers')
		{
			$name = substr(basename($file_path), 0, strlen('_controller.php') * -1);

			self::load('helper', $name);
		}
	}
	
	static function _route_defaults_to_array($defaults)
	{
		if (is_string($defaults) && strpos($defaults, '#') !== false)
		{
			$bits = explode('#', $defaults);

			if ($defaults{0} === '#')
			{
				$defaults = array('action' => $bits[1]);
			}
			else if ($defaults{strlen($defaults) - 1} === '#')
			{
				$defaults = array('controller' => $bits[0]);
			}
			else
			{
				$defaults = array('controller' => $bits[0], 'action' => $bits[1]);
			}
		}

		return (array)$defaults;
	}
}

Oak::_bootstrap();

?>
