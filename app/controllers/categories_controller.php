<?php

class CategoriesController extends AppController
{
	function view($params)
	{
		$cat = Category::query('SELECT name, description FROM #table WHERE slug = ?', $params['id']);

		if (empty($cat[0]) === false)
		{
			$order = 'created_on';

			if (isset($_GET['order']) && $_GET['order'] == 'vote')
			{
				$order = 'vote_count';
			}
			
			$this->seeds = Seed::seedsInCategory($params['id'], $order.' DESC');
			$this->category = $cat[0];
		}
		else
		{
			Oak::error(404);
			exit;
		}
	}
}

?>
