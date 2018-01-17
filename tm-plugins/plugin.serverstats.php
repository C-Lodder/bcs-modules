<?php
/*
 * Plugin: PLUGIN_NAME
 * ~~~~~~~~~~~~~~~~~~~
 * » PLUGIN_DESCRIPTION
 *
 * ----------------------------------------------------------------------------------
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ----------------------------------------------------------------------------------
 *
 */

// Start the plugin
$_PLUGIN = new PluginServerstats();

class PluginServerstats extends Plugin
{
    public $config = [
        'url' => 'https://bcsmania.co.uk/statscrawler.php' 
    ];

    public function __construct()
	{
        // Describe the Plugin
        $this->setVersion('1.0');
        $this->setBuild('1.0');
        $this->setAuthor('Alpha');
        $this->setCopyright('none');
        $this->setDescription('none');

        // Register events to interact on
        $this->registerEvent('onPlayerConnect', 'syncStats');
        $this->registerEvent('onPlayerDisconnect', 'syncStats');
		$this->registerEvent('onBeginMap', 'syncStats');
    }

    public function syncStats($aseco, $player)
	{
		$players = [];
		$server  = [];
		$maps    = [];

		// Collect players
		foreach ($aseco->server->players->player_list as $player)
		{
			$players[] = [
				'login' => $player->login, 
				'nickname' => $player->nickname
			];
		}

		// Get current server information
		$server['login']    = $aseco->server->login;
		$server['title']    = $aseco->server->title;
		$server['nickname'] = $aseco->server->name;

		$server['ladder_min']  = $aseco->server->ladder_limit_min;
		$server['ladder_max']  = $aseco->server->ladder_limit_max;
		$server['playercount'] = count($players);
		$server['maxplayers']  = $aseco->server->options['CurrentMaxPlayers'];

		$next_index = $aseco->client->query("GetNextMapIndex");
		// Do GetChallengeList and send it the next index, this way you avoid looping through data to find the right one later
		$nextchallenge = $aseco->client->query("GetMapList", 1, $next_index);

		$next_index = $aseco->client->query("GetCurrentMapIndex");
		// Do GetChallengeList and send it the next index, this way you avoid looping through data to find the right one later
		$currentchallenge = $aseco->client->query("GetMapList", 1, $next_index);

		$maps[] = $currentchallenge;
		$maps[] = $nextchallenge;

		$stats = [
		  'server' => $server,
		  'players' => $players,
		  'maps' => $maps,
		];

		$curl = curl_init($this->config['url']);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: multipart/form-data"]);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, ['json' => json_encode($stats)]);

		$result = curl_exec($curl);

		curl_close($curl);

		$aseco->console('synced');
    }
}
