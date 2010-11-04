<?= render_partial('seeds/vote', null, compact('seed')) ?>
<h2>
	<a href='<?= Oak::url('seeds#'.$seed->slug) ?>'><?= $seed->title ?></a>
</h2>
<p>
	Planted <?= human_seed_date($seed) ?><? if (empty($seed->category_slug) === false) : ?> as a <?= category_link($seed) ?> app<? endif ?>.
</p>

