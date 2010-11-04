<h2>Welcome <?= User::loggedInUser()->username ?>!</h2>

<? if (empty($seeds)) : ?>
<p>You have not created any seeds. <a href='<?= Oak::url('seeds#create') ?>'>Start a seed.</a></p>
<? else : ?>
<p><a href='<?php echo Oak::url('seeds#create') ?>'>Create a Seed</a></p>

<p>Your seeds are listed below</p>

<table>
<tr>
	<th>Title</th>
	<th>Date</th>
	<th>Actions</th>
</tr>
<?
	foreach ($seeds as $p)
	{
		$date = $p->human_date();
		$edit_url = Oak::url(array('controller' => 'seeds', 'action' => 'edit', 'id' => $p->id));
		echo <<<EOD
	<tr>
		<td>{$p->title}</td>
		<td>{$date}</td>
		<td>
		<a href='{$edit_url}'>Edit</a>
		</td>
	</tr>
EOD;
	}
?>
</table>
<? endif ?>
