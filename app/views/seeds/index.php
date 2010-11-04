<? if (empty($seeds)) : ?>
<p>
	There are no seeds.
	<? if (User::loggedInUser()) : ?>
	<a href='<?= Oak::url('seeds#create') ?>'>Create the first seed.</a>
	<? else : ?>
	<a href='<?= Oak::url('user#login') ?>'>Login</a> and then create the first seed.
	<? endif ?>
</p>
<? else : ?>
<small>
	<? if (empty($_GET['order'])) : ?>
	<a href='<?= ACORN_URL ?>?order=vote'>Voted Highest First</a>
	&nbsp;|&nbsp;
	Newest First
	<? else : ?>
	Voted Highest First
	&nbsp;|&nbsp;
	<a href='<?= ACORN_URL ?>'>Newest First</a>
	<? endif ?>
</small>
<? if (User::loggedInUser()) : ?>
<p>
	<a href='<?= Oak::url('seeds#create') ?>'>Create a Seed</a>
	-
	<a href='<?= Oak::url('user#logout') ?>'>Logout</a>
</p>
<? endif ?>
<hr/>
<? foreach ($seeds as $seed)
{
	echo render_partial('seed', $seed);
	echo '<hr/>';
}
endif ?>
