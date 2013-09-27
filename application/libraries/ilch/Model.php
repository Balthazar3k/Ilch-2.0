<?php
/**
 * @author Meyer Dominik
 * @copyright Ilch Pluto
 * @package ilch
 */

defined('ACCESS') or die('no direct access');

class Ilch_Model
{
	public function __construct($options = '')
	{
		if(is_array($options))
		{
			foreach($options as $key => $value)
			{
				 $this->$key = $value;
			}
		}
	}

	public function __get($name)
	{
		if(isset($this->$name))
		{
			return $this->$name;
		}

		return null;
	}

	public function __isset($name) 
	{
		return isset($this->$name);
	}

	public function __set($name, $value)
	{
		$this->$name = $value;
	}
}