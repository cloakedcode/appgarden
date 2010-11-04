<?php

class AuthController extends AppController
{
	public $protected_actions = array();

	function beforeAction($action)
	{
		if (session_id() == null)
		{
			session_start();
		}

		if (in_array($action, $this->protected_actions) && User::loggedInUser() === false)
		{
			if (get_class($this) !== 'UserController')
			{
				header("Location: ".Oak::url("user#login"));
				exit;
			}

			$action = 'login';
		}

		return parent::beforeAction($action);
	}	
}

?>
