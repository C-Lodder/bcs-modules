<?php
/**
 * @package    BCS_Standings
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class ModStandingsHelper
{
	public function getMatchStandings()
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true)->select(['a.MapId', 'a.Id', 'a.PlayerId', 'a.Score', 'b.Id', 'b.Name', 'b.Author', 'c.Id', 'c.NickName'])
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
		$return = [];

		foreach($array as $v)
		{
			$return[$v[$key]][] = $v;
		}

		return $return;
	}

	public function getServerRanks()
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)->select(array('*'))
			->from($db->qn('match_ranks'))
			->order($db->qn('Id') . ' ASC');
		$db->setQuery($query);

		$results = $db->loadObjectList();
		
		if ($db->getErrorNum())
		{
			throw new RuntimeException($db->getErrorMsg(), $db->getErrorNum());
		}

		return $results;
	}
}
