<?php

class Base extends AN_Model
{
	function toSlug($string, $space="-")
	{
		if (function_exists('iconv'))
		{
			$string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		}

		$string = preg_replace("/[^a-zA-Z0-9 -]/", "", $string);
		$string = strtolower($string);
		$string = str_replace(" ", $space, $string);

		$count = 1;
		while ($result = $this->execute('SELECT id FROM #table WHERE slug = ?', $string))
		{
			if (empty($result) || empty($result[0]))
			{
				return $string;
			}

			if ($count > 1)
			{
				$last_count = $count -1;
				$string = substr($string, 0, stripos($string, '-'.$last_count));
			}

			$string .= "-{$count}";
			$count++;
		}
	}	

	function execute()
	{
		return call_user_func_array(array(get_class($this), 'query'), func_get_args());
	}
}

?>
