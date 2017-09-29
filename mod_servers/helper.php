<?php
/**
* @package    BCS_Servers
* @author     Lodder
* @copyright  Copyright (C) 2015 Lodder. All Rights Reserved
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

defined('_JEXEC') or die('Restricted access');

JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

class ModServersHelper
{
	public $ajax = false;

	public function getServers($login = null)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select(array('*'));
		$query->from($db->quoteName('servers'));

		if ($login != '')
		{
			$query->where($db->quoteName('login') . ' = ' . $db->quote($login));
		}

		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getPlayersAjax()
	{
		$cp           = new TMFColorParser();
		$helper       = new ModServersHelper();
		$helper->ajax = true;
		$servers      = $helper->getServers();
		$output       = [];

		foreach ($servers as $server)
		{
			$output[$server->login] = $server;
			$output[$server->login]->currentmap = $cp->toHTML($output[$server->login]->currentmap, true);
			$output[$server->login]->nextmap    = $cp->toHTML($output[$server->login]->nextmap, true);
		}

		return $output;
	}

	public static function getPlayersNamesAjax()
	{
		$cp = new TMFColorParser();
		$cp->autoContrastColor('#ffffff');

		$helper       = new ModServersHelper();
		$helper->ajax = true;
		$array        = JFactory::getApplication()->input->post->getArray(array());
		$servers      = $helper->getServers($array['data']['server']);

		$htmlOutput = '';

		foreach ($servers as $server)
		{
			$players = $helper->getPlayers($server->id);

			foreach ($players as $player)
			{
				$htmlOutput[] .= $cp->toHTML($player);
			}
		} 

		return $htmlOutput;
	}

	public function getPlayers($id)
	{
		$players = $this->getPlayersData($id);
		$rows    = [];

		foreach ($players as $player) 
		{
			$rows[] = '<li>' . $player->nickname . '</li>';
		}

		return $rows;
	}

	public function getPlayersData($id)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select(array('*'))
			  ->from($db->quoteName('players'))
			  ->where($db->quoteName('server_id') . ' = ' . $id);
		$db->setQuery($query);

		return $db->loadObjectList();
	}
}