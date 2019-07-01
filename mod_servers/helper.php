<?php
/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2019 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

\JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

class ModServersHelper
{
	public function getServers($login = null)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select(['*'])
			->from($db->quoteName('servers'));

		if ($login != '')
		{
			$query->where($db->quoteName('login') . ' = ' . $db->quote($login));
		}

		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getServerDataAjax()
	{
		$cp      = new TMFColorParser();
		$helper  = new ModServersHelper();
		$servers = $helper->getServers();
		$output  = [];

		foreach ($servers as $server)
		{
			$output[$server->login]             = $server;
			$output[$server->login]->currentmap = $cp->toHTML($output[$server->login]->currentmap, true);
			$output[$server->login]->nextmap    = $cp->toHTML($output[$server->login]->nextmap, true);
			$output[$server->login]->raw        = html_entity_decode(strip_tags($cp->toHTML($output[$server->login]->nickname, true, true, 'all')));
		}

		return $output;
	}

	public static function getPlayersNamesAjax()
	{
		$helper  = new ModServersHelper();
		$array   = Factory::getApplication()->input->post->getArray([]);
		$servers = $helper->getServers($array['data']['server']);

		$htmlOutput = [];

		foreach ($servers as $server)
		{
			$players = $helper->getPlayers($server->id);

			foreach ($players as $player)
			{
				$htmlOutput[] = $player;
			}
		} 

		return $htmlOutput;
	}

	public function getPlayers($id)
	{
		$cp = new TMFColorParser();
		$cp->autoContrastColor('#ffffff');

		$players = $this->getPlayersData($id);
		$rows    = [];
		$count   = 0;

		foreach ($players as $player) 
		{
			$rows[$count]['nickname'] = $cp->toHTML($player->nickname);
			$rows[$count]['login']    = $player->login;

			$count++;
		}

		return $rows;
	}

	private function getPlayersData($id)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);
		$query->select(['*'])
			  ->from($db->quoteName('players'))
			  ->where($db->quoteName('server_id') . ' = ' . $id);
		$db->setQuery($query);

		return $db->loadObjectList();
	}
}
