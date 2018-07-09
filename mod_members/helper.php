<?php
/**
 * @package    BCS_Members
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

class ModMembersHelper
{
	public function getMembersList()
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('a.id as value, a.username as username, a.lastvisitDate as lastvisitDate')
			->from($db->quoteName('#__users') . ' as a')
			->join('INNER', '#__user_usergroup_map as b ON b.user_id = a.id AND b.group_id = 9')
			->order('a.id DESC');
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public function timeElapsed($datetime)
	{
		$now  = Factory::getDate();
		$ago  = Factory::getDate($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = [
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		];

		$return = [];
		$return['limit'] = false;

		foreach ($string as $k => &$v)
		{
			if ($diff->$k)
			{
				$translated = Text::_($v);

				if ($diff->$k > 1)
				{
					$translated = Text::_($v . 's');
				}

				if (($diff->$k > 7 && $v === 'month') || $v === 'year')
				{
					$return['limit'] = true;
				}

				$v = $diff->$k . ' ' . $translated;
			}
			else
			{
				unset($string[$k]);
			}
		}

		$string    = array_slice($string, 0, 1);
		$separator = explode(' ', implode(', ', $string));

		if ($separator[0] != '')
		{
			$translated = Text::_('BCSMEMBERS_TIME_' . strtoupper($separator[1]));

			$return['time'] = Text::sprintf('BCSMEMBERS_TIME_FINAL', (int)$separator[0], $translated, Text::_('BCSMEMBERS_TIME_AGO'));

			return $return;
		}

		$return['time'] = Text::_('BCSMEMBERS_TIME_JUST_NOW');

		return $return;
	}
}
