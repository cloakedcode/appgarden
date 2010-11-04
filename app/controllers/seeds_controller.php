<?php

class SeedsController extends AuthController
{
	var $protected_actions = array('create', 'edit', 'vote_up', 'vote_none', 'vote_down');

	function index()
	{
		$order = 'created_on';

		if (isset($_GET['order']) && $_GET['order'] == 'vote')
		{
			$order = 'vote_count';
		}

		$this->seeds = Seed::seedsWithCategory($order." DESC");
	}

	function view($params)
	{
		if (empty($params['id']))
		{
			$this->seed = null;
		}
		else
		{
			$seeds = Seed::query('SELECT #table.*, categorys.name AS category_name, categorys.slug AS category_slug FROM #table INNER JOIN categorys ON categorys.id = #table.category_id WHERE #table.slug = ?', $params['id']);

			if (empty($seeds[0]) === false)
			{
				$this->seed = $seeds[0];

				include_once('markdown/markdown.php');
				$this->seed->description = Markdown($this->seed->description);
			}
		}
	}

	function vote_up($params)
	{
		Seed::vote($params['id'], 1);

		header('Location: '.Oak::url('seeds#index'));
		exit;
	}

	function vote_none($params)
	{
		Seed::vote($params['id'], 0);

		header('Location: '.Oak::url('seeds#index'));
		exit;
	}

	function vote_down($params)
	{
		Seed::vote($params['id'], -1);

		header('Location: '.Oak::url('seeds#index'));
		exit;
	}

	function create()
	{
		$this->errors = null;
		if (isset($_POST['create']))
		{
			$seed = $this->_updateSeed();

			if (empty($seed->errors))
			{
				header("Location: ".Oak::url(array('action' => 'view', 'id' => $seed->slug)));
			}
			else
			{
				$this->errors = $seed->errors;
			}
		}
		
		$this->categories = $this->_categories();
	}

	function edit($params)
	{
		$id = $params['id'];
		if (empty($id))
		{
			header('Location: '.Oak::url('seeds#index'));
			exit;
		}
		
		$seeds = Seed::query('SELECT * FROM #table WHERE slug = ? AND user_id = ?', $id, User::loggedInUser()->id);

		if (empty($seeds[0]))
		{
			header('Location: '.Oak::url('seeds#index'));
			exit;
		}

		$this->errors = null;
		if (isset($_POST['save']))
		{
			$_POST['created_on'] = $seeds[0]->created_on;
			$_POST['slug'] = $params['id'];
			$seed = $this->_updateSeed($seeds[0]->id);

			if (empty($seed->errors))
			{
				header("Location: ".Oak::url(array('action' => 'view', 'id' => $id)));
				exit;
			}
			else
			{
				$this->errors = $seed->errors;
			}
		}

		$this->seed = $seeds[0];
		$this->categories = $this->_categories();
	}

	private function _updateSeed($id = null)
	{
		$_POST['title'] = html2txt($_POST['title']);
		$_POST['description'] = stackoverflow_strip_tags($_POST['description']);

		if ($id !== null)
		{
			$seed = new Seed($_POST);
			$seed->id = $id;

			$seed->save();
		}
		else
		{
			$seed = Seed::create($_POST);
		}

		if (empty($seed->errors))
		{
			unset($_POST);
			$_POST = array();
		}

		return $seed;
	}

	private function _categories()
	{
		return Category::query('SELECT id,name FROM #table');
	}
}

?>
