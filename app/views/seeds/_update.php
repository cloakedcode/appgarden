<? if (isset($errors)) : ?>
<ul>
<? foreach ($errors as $e) :
	foreach ($e as $error) : ?>
	<li><?= $error ?></li>
<? 	endforeach;
endforeach?>
</ul>
<? endif ?>

<form method='post'>
	<label>Title:</label>
	<br/>
	<input type='string' name='title' size=97 value='<?= (isset($seed->title)) ? $seed->title : '' ?>' />
	<br/>

	<label>Category:</label>
	<br/>
	<select name='category'>
	<? foreach ($categories as $c) : ?>
		<option value='<?= $c->id ?>'<? if (isset($seed->category_id) && $c->id == $seed->category_id) echo ' selected ' ?>><?= $c->name ?></option>
	<? endforeach ?>
	</select>
	<br/>

	<label>Description:</label>
	<br/>
	<textarea name='description' cols=70 rows=17><?= (isset($seed->description)) ? $seed->description : '' ?></textarea>
	<br/>
	
	<input type='submit' value='<?= ucwords($button) ?>' name='<?= $button ?>' />&nbsp;or&nbsp;
	<a href='<?= Oak::url('user#index') ?>' onclick='history.go(-1); return false'>Cancel</a>

	<div class="wmd-preview"></div>
</form>

<script type="text/javascript">
	wmd_options = { output : 'Markdown' };
</script>
<script type="text/javascript" src="<?= ACORN_URL ?>wmd/wmd.js"></script>
