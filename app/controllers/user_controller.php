<?php

class UserController extends OK_Controller
{
	function beforeAction($action)
	{
		if ($action !== 'login' && User::loggedInUser() === false)
		{
			return 'login';
		}
		else if ($action === 'login' && User::loggedInUser())
		{
			return 'index';
		}

		return $action;
	}

	function index()
	{
		header('Location: '.Oak::url('seeds#index'));
		exit;
	}
	
	function login()
	{
		if (session_id() == null)
		{
			session_start();
		}

		if (isset($_POST['username']) && isset($_POST['password']))
		{
			if (User::loginWithCredentials($_POST['username'], $_POST['password']))
			{
				header('Location: '.Oak::url('seeds#index'));
				exit;
			}
			else
			{
				$this->msg = 'Username/Password incorrect.';
			}
		}
	}

	function logout()
	{
		User::logout();

		header('Location: '.Oak::url('#login'));
		exit;
	}

}

?>
