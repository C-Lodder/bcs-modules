<?php
/**
* @package    Trackmania Server Stats
* @author     Charlie Lodder
* @copyright  Copyright (C) 2017 Charlie Lodder. All Rights Reserved
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC')  or die('Restricted access');

$showPrivateServer = false;
?>

<table id="tm_server" class="uk-table">
	<tr>
		<th>Server</th>
		<th style="width:100px">Players</th>
		<th class="uk-hidden-small">Current Map</th>
		<th class="uk-visible-large">Next Map</th>
		<th class="uk-hidden-small" style="width:160px">Actions</th>
	</tr>
	<?php 
		foreach ($servers as $server)
		{
			$id       = $server->id;
			$login    = $server->login;
			$nickname = $cp->toHTML($server->nickname);
			$current  = isset($server->currentmap) ? $server->currentmap : '';
			$next     = isset($server->nextmap) ? $server->nextmap : '';

			if ($login == 'bcseslspeed')
			{
				echo '';
			}
			else
			{
				echo '<tr>';
				echo '<td>';
				echo $nickname;
				if ($login == 'bcsrace')
				{
					echo ' <i class="uk-icon-lock"></i>';
				}
				echo '</td>';
	
				echo '<td class="update"><span class="spinner count_' . $id . '">' . $server->playercount . '</span><i class="uk-icon-spinner uk-icon-spin" style="display:none"></i> / ' . $server->maxplayers . '</td>';
				echo '<td class="update uk-hidden-small"><span class="spinner currentmap_' . $id . '">' . $cp->toHTML($current, true) . '</span><i class="uk-icon-spinner uk-icon-spin" style="display:none"></i></td>';
				echo '<td class="update uk-visible-large"><span class="spinner nextmap_' . $id . '">' . $cp->toHTML($next, true) . '</span><i class="uk-icon-spinner uk-icon-spin" style="display:none"></i></td>';
				echo '<td class="uk-hidden-small server-actions">
						<a class="uk-icon-users" href="#' . $login . '" class="' . $login . '" data-uk-modal data-uk-tooltip title="Players"></a>	
						<a class="uk-icon-sign-in" href="maniaplanet://#join=' . $login . '@' . $server->title . '" target="_blank" data-uk-tooltip title="Join"></a>
						<a class="uk-icon-eye" href="maniaplanet://#spectate=' . $login . '" target="_blank" data-uk-tooltip title="Spectate"></a>
						<a class="uk-icon-heart-o" href="maniaplanet://#addfavorite=' . $login . '" target="_blank" data-uk-tooltip title="Add to favourites"></a>
					  </td>';
				echo '</tr>';
	
				echo '<div id="' . $login . '" class="uk-modal players_modal">
						<div class="uk-modal-dialog">
							<a class="uk-modal-close uk-close"></a>
							<div class="uk-modal-header"><h2>Players on - ' . $nickname . '</h2></div>
							<ul class="uk-list uk-list-line uk-text-center uk-text-large player_list">';
	
							$players = $helper->getPlayers($id);
	
							if (!empty($players))
							{
								foreach ($players as $player)
								{
									echo $cp->toHTML($player);
								}
							}
							else
							{
								echo '<li class="uk-text-danger">No players online</li>';
							}

				echo '</ul></div></div>';
			}
		} 
	?>
</table>

<script>
	(function() {
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {

			var BCS_Itemid   = <?php echo $Itemid ? $Itemid : 'null'; ?>,
			    BCS_instance = document.getElementById('tm_server');

			function getPlayers(BCS_title, BCS_Itemid, BCS_instance)
			{
				// Assemble variables to submit
				var request = {
					'option'      : 'com_ajax',
					'module'      : 'servers',
					'method'      : 'getPlayers',
					'format'      : 'json',
					'data[title]' : BCS_title,
				};

				// If there is an active menu item then we need to add it to the request.
				if (BCS_Itemid !== null)
				{
					request['Itemid'] = BCS_Itemid;
				}

				// AJAX request
				jQuery.ajax({
					type: 'POST',
					data: request,
					beforeSend: function() 
					{
						var spinners = BCS_instance.querySelectorAll('.spinner'),
						    update   = BCS_instance.querySelectorAll('.update .uk-icon-spinner');

						for (var i = 0; i < spinners.length; i++)
						{
							spinners[i].innerHTML = '';
						}

						for (var i = 0; i < update.length; i++)
						{
							update[i].style.diaplay = 'block';
						}
					},
					success: function(response)
					{
						if (response.success)
						{
							var spinners = BCS_instance.querySelectorAll('.update .uk-icon-spinner');
							for (var i = 0; i < spinners.length; i++)
							{
								spinners[i].style.diaplay = 'block';
							}

							// Update players
							BCS_instance.querySelector('.count_2').innerHTML = response.data.bcsrace.playercount;
							BCS_instance.querySelector('.count_3').innerHTML = response.data.bcslol.playercount;
							BCS_instance.querySelector('.count_4').innerHTML = response.data.bcstech.playercount;
							BCS_instance.querySelector('.count_5').innerHTML = response.data.bcsmanic.playercount;
							BCS_instance.querySelector('.count_8').innerHTML = response.data.bcsrpg.playercount;

							// Update current map
							BCS_instance.querySelector('.currentmap_2').innerHTML = response.data.bcsrace.currentmap;
							BCS_instance.querySelector('.currentmap_3').innerHTML = response.data.bcslol.currentmap;
							BCS_instance.querySelector('.currentmap_4').innerHTML = response.data.bcstech.currentmap;
							BCS_instance.querySelector('.currentmap_5').innerHTML = response.data.bcsmanic.currentmap;
							BCS_instance.querySelector('.currentmap_8').innerHTML = response.data.bcsrpg.currentmap;

							// Update next map
							BCS_instance.querySelector('.nextmap_2').innerHTML = response.data.bcsrace.nextmap;
							BCS_instance.querySelector('.nextmap_3').innerHTML = response.data.bcslol.nextmap;
							BCS_instance.querySelector('.nextmap_4').innerHTML = response.data.bcstech.nextmap;
							BCS_instance.querySelector('.nextmap_5').innerHTML = response.data.bcsmanic.nextmap;
							BCS_instance.querySelector('.nextmap_8').innerHTML = response.data.bcsrpg.nextmap;
						}
					}
				});

				return false;
			}

			function getPlayersNames(BCS_title, BCS_Itemid, BCS_instance)
			{
				// Assemble variables to submit
				var request = {
					'option'       : 'com_ajax',
					'module'       : 'servers',
					'method'       : 'getPlayersNames',
					'format'       : 'json',
					'data[title]'  : BCS_title,
					'data[server]' : BCS_instance,
				};

				// If there is an active menu item then we need to add it to the request.
				if (BCS_Itemid !== null)
				{
					request['Itemid'] = BCS_Itemid;
				}

				var playerList = document.getElementById(BCS_instance).querySelector('.player_list');

				jQuery.ajax({
					type: 'POST',
					data: request,
					beforeSend: function()
					{
						playerList.innerHTML = '';
						playerList.innerHTML = '<li><i class="uk-icon-spinner uk-icon-spin uk-icon-large"></i></li>';
					},
					success: function(response)
					{
						if (response.success)
						{
							if (response.data != '')
							{
								playerList.innerHTML = '';

								var results = response.data;
								for (var i = 0; i < results.length; i++)
								{
									playerList.insertAdjacentHTML('beforeend', results[i]);
								}
							}
							else
							{
								playerList.innerHTML = '<li class="uk-text-danger">No players online</li>';
							}
						}
					}
				});

				return false;
			}

			jQuery('.players_modal').on({
				'show.uk.modal': function(){

					var BCS_instance = jQuery(this).attr('id'),
						BCS_Itemid   = '<?php echo $Itemid; ?>';

					getPlayersNames('<?php echo $title; ?>', BCS_Itemid, BCS_instance);
				}
			});

			<?php if (!$user->guest) : ?>
			setInterval(function()
			{
				var BCS_Itemid = '<?php echo $Itemid; ?>';
				getPlayers('<?php echo $title; ?>', BCS_Itemid, BCS_instance);
			}, 10000);
			<?php endif; ?>

		});
	})();
</script>
