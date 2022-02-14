<?php
/**
 * @package    BCS_Standings
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class ModStandingsHelper
{
	public $db = null;

	public function __construct()
	{
		$this->db = Factory::getContainer()->get('DatabaseDriver');
	}

	public function getMatchStandings()
	{
		$query = $this->db->getQuery(true)->select(['a.MapId', 'a.Id', 'a.PlayerId', 'a.Score', 'b.Id', 'b.Name', 'b.Author', 'c.Id', 'c.NickName'])
			->from($this->db->qn('match_records', 'a'))
			->join('INNER', $this->db->qn('match_maps', 'b') . ' ON (' . $this->db->qn('a.MapId') . ' = ' . $this->db->qn('b.Id') . ')')
			->join('INNER', $this->db->qn('match_players', 'c') . ' ON (' . $this->db->qn('a.PlayerId') . ' = ' . $this->db->qn('c.Id') . ')')
			->order($this->db->qn('a.Score') . ' ASC');

		try
		{
			$results = $this->db->setQuery($query)->loadAssocList();
		}
		catch (Exception $exc)
		{
			return false;
		}

		return $this->groupAssoc($results, 'MapId');
	}

	public function groupAssoc($array, $key)
	{
		$return = [];

		foreach ($array as $v)
		{
			$return[$v[$key]][] = $v;
		}

		return $return;
	}

	public function getServerRanks()
	{
		$query = $this->db->getQuery(true)->select(['*'])
			->from($this->db->qn('match_ranks'))
			->order($this->db->qn('Id') . ' ASC');

		try
		{
			$results = $this->db->setQuery($query)->loadObjectList();
		}
		catch (Exception $exc)
		{
			return false;
		}

		return $results;
	}

	public function formatTime($MwTime, $tsec = true)
	{
		if ($MwTime > 0)
		{
			$tseconds = strlen($MwTime) > 3 ? substr($MwTime, strlen($MwTime) - 3) : $MwTime;
			$MwTime   = floor($MwTime / 1000);
			$hours    = floor($MwTime / 3600);
			$MwTime   = $MwTime - ($hours * 3600);
			$minutes  = floor($MwTime / 60);
			$MwTime   = $MwTime - ($minutes * 60);
			$seconds  = floor($MwTime);

			if ($tsec)
			{
				if ($hours)
				{
					return sprintf('%d:%02d:%02d.%03d', $hours, $minutes, $seconds, $tseconds);
				}

				return sprintf('%d:%02d.%03d', $minutes, $seconds, $tseconds);
			}
			else
			{
				if ($hours)
				{
					return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
				}

				return sprintf('%d:%02d', $minutes, $seconds);
			}
		}

		return '0:00:000';
	}
}
