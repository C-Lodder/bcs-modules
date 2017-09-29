<?php
/**
* @package    BCS_Matches
* @author     Lodder
* @copyright  Copyright (C) 2017 Lodder. All Rights Reserved
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

defined('_JEXEC') or die('Restricted access');

class ModMatchesHelper
{
	public function getMatchStandings()
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)->select(array('a.MapId', 'a.Id', 'a.PlayerId', 'a.Score', 'b.Id', 'b.Name', 'b.Author', 'c.Id', 'c.NickName'))
			->from($db->qn('match_records', 'a'))
			->join('INNER', $db->qn('match_maps', 'b') . ' ON (' . $db->qn('a.MapId') . ' = ' . $db->qn('b.Id') . ')')
			->join('INNER', $db->qn('match_players', 'c') . ' ON (' . $db->qn('a.PlayerId') . ' = ' . $db->qn('c.Id') . ')')
			->order($db->qn('a.Score') . ' ASC');
		$db->setQuery($query);

		$results = $db->loadAssocList();
		
		if ($db->getErrorNum())
		{
			throw new RuntimeException($db->getErrorMsg(), $db->getErrorNum());
		}

		$grouped = $this->groupAssoc($results, 'MapId');

		return $grouped;
	}

	public function groupAssoc($array, $key)
	{
		$return = array();

		foreach($array as $v)
		{
			$return[$v[$key]][] = $v;
		}

		return $return;
	}
}
