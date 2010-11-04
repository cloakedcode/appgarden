<?php

class Seed extends Base
{
	function validate()
	{
		if (empty($this->created_on))
		{
			$this->created_on = date('Y-m-d H:i:s');
		}

		if (empty($this->user_id) && User::loggedInUser() !== false)
		{
			$this->user_id = User::loggedInUser()->id;
		}

		if (empty($this->slug))
		{
			$this->slug = $this->toSlug($this->title);
		}

		if (isset($this->category))
		{
			$cat = Category::query('SELECT id FROM #table WHERE id = ?', $this->category);

			if (isset($cat[0]))
			{
				$this->category_id = $this->category;
			}
			else
			{
				if (empty($this->category_id))
				{
					$this->category_id = -1;
				}

				$this->errors['category'] = array('Invalid category.');
			}
		}

		parent::validate();
	}

	function category()
	{
		$cat = Category::query('SELECT * FROM #table WHERE id = ?', $this->category_id);

		return (empty($cat) || empty($cat[0])) ? null : $cat[0];
	}

	function usersVote()
	{
		if (empty($this->users_vote) && $this->users_vote !== false)
		{
			$vote = false;
			$user = User::loggedInUser();

			if (empty($user) === false)
			{
				$votes = Vote::query("SELECT vote FROM #table WHERE seed_id = ? AND user_id = ? LIMIT 1", $this->id, $user->id);
				if (empty($votes[0]) === false && $votes[0] !== null)
				{
					$vote = $votes[0]->vote;
				}
			}

			$this->users_vote = $vote;
		}

		return $this->users_vote;
	}

	static function vote($seed_slug, $vote)
	{
		$user = User::loggedInUser();

		if (empty($user))
		{
			return false;
		}

		$seeds = self::query('SELECT id FROM #table WHERE slug = ? AND user_id != ?', $seed_slug, $user->id);

		if (empty($seeds[0]) === false)
		{
			$seed = $seeds[0];
			$vote = ($vote > 0) ? 1 : (($vote < 0) ? -1 : 0);

			if ($vote === 0)
			{
				Vote::query("DELETE FROM #table WHERE seed_id = ? AND user_id = ? LIMIT 1", $seed->id, $user->id);
			}
			else
			{
				$votes = Vote::query("SELECT id FROM #table WHERE seed_id = ? AND user_id = ? LIMIT 1", $seed->id, $user->id);

				if (empty($votes[0]))
				{
					Vote::create(array('vote' => $vote, 'seed_id' => $seed->id, 'user_id' => $user->id));
				}
				else
				{
					$vote_obj = $votes[0];

					$vote_obj->vote = $vote;
					$vote_obj->save(false);
				}
			}

			self::query('UPDATE #table SET vote_count = (SELECT SUM(vote) FROM `votes` WHERE seed_id = ?) WHERE id = ?', $seed->id, $seed->id);
			
			return true;
		}

		return false;
	}

	static function seedsWithCategory($order = '')
	{
		if (empty($order))
		{
			return self::query('SELECT #table.*, categorys.name FROM #table INNER JOIN categorys ON #table.category_id = categorys.id');
		}

		return self::query('SELECT #table.*, categorys.name AS category_name, categorys.slug AS category_slug FROM #table INNER JOIN categorys ON #table.category_id = categorys.id ORDER BY '.$order);
	}

	static function seedsInCategory($cat_slug, $order = '')
	{
		if (empty($order))
		{
			return self::query('SELECT #table.* FROM #table INNER JOIN categorys ON categorys.slug = ? AND #table.category_id = categorys.id', $cat_slug);
		}

		return self::query('SELECT #table.* FROM #table INNER JOIN categorys ON #table.category_id = categorys.id WHERE categorys.slug = ? ORDER BY '.$order, $cat_slug);
	}
}

?>
