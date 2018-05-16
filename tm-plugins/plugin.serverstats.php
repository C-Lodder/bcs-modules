<?php
/**
 * @copyright Alphaleon
 */

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

		$asecoServer = $aseco->server;
		$asecoClient = $aseco->client;

		// Collect players
		foreach ($aseco->server->players->player_list as $player)
		{
			$players[] = [
				'login' => $player->login, 
				'nickname' => $player->nickname
			];
		}

		// Get current server information
		$server['login']       = $asecoServer->login;
		$server['title']       = $asecoServer->title;
		$server['nickname']    = $asecoServer->name;
		$server['ladder_min']  = $asecoServer->ladder_limit_min;
		$server['ladder_max']  = $asecoServer->ladder_limit_max;
		$server['playercount'] = count($players);
		$server['maxplayers']  = $asecoServer->options['CurrentMaxPlayers'];

		$next_index = $asecoClient->query("GetNextMapIndex");
		// Do GetChallengeList and send it the next index, this way you avoid looping through data to find the right one later
		$nextchallenge = $asecoClient->query("GetMapList", 1, $next_index);

		$next_index = $asecoClient->query("GetCurrentMapIndex");
		// Do GetChallengeList and send it the next index, this way you avoid looping through data to find the right one later
		$currentchallenge = $asecoClient->query("GetMapList", 1, $next_index);

		$maps[] = $currentchallenge;
		$maps[] = $nextchallenge;

		$stats = [
			'server'  => $server,
			'players' => $players,
			'maps'    => $maps,
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

		$aseco->console('Server stats have been synced');
	}
}
