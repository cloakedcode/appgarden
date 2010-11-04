<h2>Seeds in <?= $category->name ?></h2>
<p><?= $category->description ?></p>
<? if (empty($seeds)) : ?>
<p>
	There are no seeds in this category.
	<? if (User::loggedInUser()) : ?>
	<a href='<?= Oak::url('seeds#create') ?>'>Create the first seed.</a>
	<? else : ?>
	<a href='<?= Oak::url('user#login') ?>'>Login</a> and then create the first seed.
	<? endif ?>
</p>
<? else : ?>
<small>
	<? if (empty($_GET['order']) || $_GET['order'] !== 'vote') : ?>
	<a href='?order=vote'>Voted Highest First</a>
	&nbsp;|&nbsp;
	Newest First
	<? else : ?>
	Voted Highest First
	&nbsp;|&nbsp;
	<a href='?order=date'>Newest First</a>
	<? endif ?>
</small>
<hr/>
<? foreach ($seeds as $seed)
{
	echo render_partial('seeds/seed', $seed);
	echo '<hr/>';
}
endif ?>
