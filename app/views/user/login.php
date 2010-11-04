<?php if (isset($msg))
{
echo <<<EOD
<p>
	{$msg}
</p>
EOD;
}
?>

<form method='post'>
	<label>Username:</label>
	<input type='text' name='username' />
	<br/>
	<label>Password:</label>
	<input type='password' name='password' />
	<br/>
	<input type='submit' value='Login' />
</form>
