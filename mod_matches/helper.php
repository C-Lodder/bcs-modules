<?php
/**
 * @package    BCS_Matches
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

class ModMatchesHelper
{
	public function groupByKey($array) 
	{
		$result = [];
		$array  = json_decode($array, true);

		foreach ($array as $sub) 
		{
			foreach ($sub as $k => $v) 
			{
				$result[$k][] = $v;
			}
		}
		return $result;
	}
}
