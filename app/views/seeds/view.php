<? if (empty($seed)) : ?>
<p>
	There is no seed with that id.
</p>
<? else : ?>
<?= render_partial('vote', null, compact('seed')) ?>
<h2>
	<? $being_viewed = (isset(Oak::$params['id']) && Oak::$params['id'] == $seed->slug);
	if ($being_viewed)
	{
		echo $seed->title;
	}
	else
	{
		echo "<a href='".Oak::url(array('action' => 'view', 'id' => $seed->slug))."'>{$seed->title}</a>";
	} ?>
</h2>
<p>
<small>Planted <?= human_seed_date($seed) ?> as a <a href='<?= Oak::url(array('controller' => 'categories', 'action' => 'view', 'id' => $seed->category_slug)) ?>'><?= $seed->category_name ?></a> app.</small>
<br/>
<?= ($being_viewed) ? $seed->description : truncate_text($seed->description, 100, '.', " <a href='".Oak::url(array('action' => 'view', 'id' => $seed->slug))."'>more...</a>") ?>
</p>

<a href='<?= Oak::url('#index') ?>'>Back to listing</a>
<? if (User::loggedInUser() && User::loggedInUser()->id == $seed->user_id) : ?>
|
<a href='<?= Oak::url(array('action' => 'edit', 'id' => $seed->slug)) ?>'>Edit</a>
<? endif // if editable ?>
<? endif // if empty?>
