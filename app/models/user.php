<?php

class User extends AN_Model
{
	static function hashPassword($str)
	{
		return sha1($str.'a very long and complicated hash salt');
	}

	static function loggedInUser()
	{
		static $user = null;

		if ($user === null)
		{
			if (empty($_SESSION['user_id']) === false && $_SESSION['ip'] === self::ip())
			{
				$users = self::query('SELECT * FROM #table WHERE id=? LIMIT 1', $_SESSION['user_id']);

				$user = (empty($users)) ? false : $users[0];
			}
			else
			{
				$user = false;
			}
		}

		return $user;
	}

	static function loginWithCredentials($username, $password)
	{
		$user = self::query('SELECT id FROM #table WHERE username=? AND password=? LIMIT 1', $username, self::hashPassword($password));
		return (empty($user[0])) ? false : self::loginUser($user[0]->id);
	}

	static function loginUser($id)
	{
		$_SESSION['user_id'] = $id;
		$_SESSION['ip'] = self::ip();

		return true;
	}

	static function logout()
	{
		session_destroy();
	}

	static private function ip()
	{
		return $_SERVER['REMOTE_ADDR'];
	}		
}

?>
