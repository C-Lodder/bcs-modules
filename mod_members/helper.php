<?php
/**
 * @package    BCS_Members
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

class ModMembersHelper
{
	public function getMembersList($groupId)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('a.id as value, a.username as username')
			->from($db->quoteName('#__users') . ' as a')
			->join('INNER', '#__user_usergroup_map as b ON b.user_id = a.id AND b.group_id = ' . $groupId)
			->order('a.id');
		$db->setQuery($query);

		return $db->loadObjectList();
	}
}
