<?= render_partial('seeds/vote', null, compact('seed')) ?>
<h2>
	<a href='<?= Oak::url('seeds#'.$seed->slug) ?>'><?= $seed->title ?></a>
</h2>
<p>
	Created on <?= human_seed_date($seed) ?>.
	<? if (empty($seed->category_slug) === false)
	{
		echo "<br/>\nCategory: ".category_link($seed);
	} ?>
</p>

