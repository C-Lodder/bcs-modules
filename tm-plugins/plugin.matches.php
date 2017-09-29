<?php
/**
 * @copyright Alphaleon
 */

$_PLUGIN = new PluginMatches();

class PluginMatches extends Plugin
{
    public $config = [
        'url' => 'https://bcsmania.co.uk/standingscrawler.php' 
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
        $this->registerEvent('onBeginMap', 'syncStandings');
    }

    public function syncStandings($aseco, $player)
	{
		// Check if there are any players on the server
		if (count(array_filter($aseco->server->players->player_list)) == 0)
		{
			return;
		}

        $players = [];
        $records = [];
        $maps    = [];

		// Get the players
        $query1 = "SELECT * FROM `%prefix%players`";
		$result1 = $aseco->db->query($query1);
		if ($result1)
		{
			if ($result1->num_rows > 0)
			{
				while ($row = $result1->fetch_array(MYSQLI_ASSOC))
				{
					$player = array_map('htmlentities', $row);
					$players[] = $player;
				}
			}
			$result1->free_result();
		}

		// Get the records
		$query2 = "SELECT * FROM `%prefix%records`";
		$result2 = $aseco->db->query($query2);
		if ($result2)
		{
			if ($result2->num_rows > 0)
			{
				while ($row = $result2->fetch_array(MYSQLI_ASSOC))
				{
					$record = array_map('htmlentities', $row);
					$records[] = $record;
				}
			}
			$result2->free_result();
		}

		// Get the maps
		$query3 = "SELECT * FROM `%prefix%maps`";
		$result3 = $aseco->db->query($query3);
		if ($result3)
		{
			if ($result3->num_rows > 0)
			{
				while ($row = $result3->fetch_array(MYSQLI_ASSOC))
				{
					$map = array_map('htmlentities', $row);
					$maps[] = $map;
				}
			}
			$result3->free_result();
		}

        $stats = [
			'records' => $records,
			'players' => $players,
			'maps'    => $maps,
        ];

        $curl = curl_init($this->config['url']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, array('json' => json_encode($stats)));

        $result = curl_exec($curl);

        curl_close($curl);

        $aseco->console('Standings have been synced');
    }
}
