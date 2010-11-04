<div class='vote'>
	<?= ($seed->usersVote() == 1) ? seed_vote_link($seed, 'None', 'none') : seed_vote_link($seed, 'Up', 'up') ?>
	<div class='count'><?= (int)$seed->vote_count ?></div>
	<?= ($seed->usersVote() == -1) ? seed_vote_link($seed, 'None', 'none') : seed_vote_link($seed, 'Down', 'down') ?>
</div>
