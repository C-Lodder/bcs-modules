<?php
/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

$showPrivateServer = false;

?>

<table id="tm_server" class="uk-table">
	<thead>
		<tr>
			<th>Server</th>
			<th style="width:100px">Players</th>
			<th class="uk-hidden-small">Current Map</th>
			<th class="uk-visible-large">Next Map</th>
			<th class="uk-hidden-small" style="width:160px">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($servers as $server) : ?>
			<?php
				$login = $server->login;
			?>
			<?php if ($login === 'bcseslspeed' || ($private == 0 && $login === 'bcsrace')) : ?>
				<?php continue; ?>
			<?php else : ?>
				<?php
					$id       = $server->id;
					$nickname = $cp->toHTML($server->nickname);
					$current  = isset($server->currentmap) ? $server->currentmap : '';
					$next     = isset($server->nextmap) ? $server->nextmap : '';
					$players  = $helper->getPlayers($id);
				?>
				<tr>
					<td>
						<?php echo $nickname; ?>
						<?php if ($login === 'bcsrace') :  ?>
							<span class="uk-icon-lock" aria-hidden="true"></span>
						<?php endif; ?>
					</td>
					<td class="update"><span class="spinner count_<?php echo $id; ?>"><?php echo $server->playercount; ?></span> / <?php echo $server->maxplayers; ?></td>
					<td class="update uk-hidden-small"><span class="spinner currentmap_<?php echo $id; ?>"><?php echo $cp->toHTML($current, true); ?></span></td>
					<td class="update uk-visible-large"><span class="spinner nextmap_<?php echo $id; ?>"><?php echo $cp->toHTML($next, true); ?></span></td>
					<td class="uk-hidden-small server-actions">
						<a class="uk-icon-users" href="#<?php echo $login; ?>" class="<?php echo $login; ?>" data-uk-modal data-uk-tooltip title="Players"></a>	
						<a class="uk-icon-sign-in" href="maniaplanet://#join=<?php echo $login . '@' . $server->title; ?>" target="_blank" data-uk-tooltip title="Join"></a>
						<a class="uk-icon-eye" href="maniaplanet://#spectate=<?php echo $login; ?>" target="_blank" data-uk-tooltip title="Spectate"></a>
						<a class="uk-icon-heart-o" href="maniaplanet://#addfavorite=<?php echo $login; ?>" target="_blank" data-uk-tooltip title="Add to favourites"></a>
					</td>
					<td>
						<div id="<?php echo $login; ?>" class="uk-modal players_modal">
							<div class="uk-modal-dialog">
								<a class="uk-modal-close uk-close"></a>
								<div class="uk-modal-header"><h2>Players on - <?php echo $nickname; ?></h2></div>
								<ul class="uk-list uk-list-line uk-text-center uk-text-large player_list">
									<?php if (!empty($players)) : ?>
										<?php foreach ($players as $player) : ?>
											<?php echo $cp->toHTML($player); ?>
										<?php endforeach; ?>
									<?php else : ?>
										<li class="uk-text-danger">No players online</li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>

<script>
	(function() {
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {

			var itemId   = <?php echo $Itemid ? $Itemid : 'null'; ?>;
			var refresh  = '<?php echo $refresh; ?>';
			var instance = document.getElementById('tm_server');
			var spinners = instance.querySelectorAll('.spinner');

			function getServerData(itemId, instance)
			{
				// Assemble variables to submit
				var request = {
					option : 'com_ajax',
					module : 'servers',
					method : 'getServerData',
					format : 'json',
				};

				// If there is an active menu item then we need to add it to the request.
				if (itemId !== null)
				{
					request['Itemid'] = itemId;
				}

				// AJAX request
				jQuery.ajax({
					type: 'POST',
					data: request,
					beforeSend: function() 
					{
						for (var i = 0; i < spinners.length; i++)
						{
							spinners[i].innerHTML = '<span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span>';
						}
					},
					success: function(response)
					{
						if (response.success)
						{
							// Update players
							instance.querySelector('.count_2').innerHTML = response.data.bcsrace.playercount;
							instance.querySelector('.count_3').innerHTML = response.data.bcslol.playercount;
							instance.querySelector('.count_4').innerHTML = response.data.bcstech.playercount;
							instance.querySelector('.count_5').innerHTML = response.data.bcsmanic.playercount;
							instance.querySelector('.count_8').innerHTML = response.data.bcsrpg.playercount;

							// Update current map
							instance.querySelector('.currentmap_2').innerHTML = response.data.bcsrace.currentmap;
							instance.querySelector('.currentmap_3').innerHTML = response.data.bcslol.currentmap;
							instance.querySelector('.currentmap_4').innerHTML = response.data.bcstech.currentmap;
							instance.querySelector('.currentmap_5').innerHTML = response.data.bcsmanic.currentmap;
							instance.querySelector('.currentmap_8').innerHTML = response.data.bcsrpg.currentmap;

							// Update next map
							instance.querySelector('.nextmap_2').innerHTML = response.data.bcsrace.nextmap;
							instance.querySelector('.nextmap_3').innerHTML = response.data.bcslol.nextmap;
							instance.querySelector('.nextmap_4').innerHTML = response.data.bcstech.nextmap;
							instance.querySelector('.nextmap_5').innerHTML = response.data.bcsmanic.nextmap;
							instance.querySelector('.nextmap_8').innerHTML = response.data.bcsrpg.nextmap;
						}
					}
				});

				return false;
			}

			function getPlayersNames(itemId, instance)
			{
				// Assemble variables to submit
				var request = {
					option         : 'com_ajax',
					module         : 'servers',
					method         : 'getPlayersNames',
					format         : 'json',
					'data[server]' : instance,
				};

				// If there is an active menu item then we need to add it to the request.
				if (itemId !== null)
				{
					request['Itemid'] = itemId;
				}

				var playerList = document.getElementById(instance).querySelector('.player_list');

				jQuery.ajax({
					type: 'POST',
					data: request,
					beforeSend: function()
					{
						playerList.innerHTML = '';
						playerList.innerHTML = '<li><span class="uk-icon-spinner uk-icon-spin uk-icon-large" aria-hidden="true"></span></li>';
					},
					success: function(response)
					{
						if (response.success)
						{
							if (response.data != '')
							{
								playerList.innerHTML = '';

								var results = response.data;
								for (var l = 0; l < results.length; l++)
								{
									var listItem = '<li>' + results[l] + '</li>';
									playerList.insertAdjacentHTML('beforeend', listItem);
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

					var instance = jQuery(this).attr('id');
					var itemId   = '<?php echo $Itemid; ?>';

					getPlayersNames(itemId, instance);
				}
			});

			<?php if (!$user->guest) : ?>
			setInterval(function()
			{
				var itemId = '<?php echo $Itemid; ?>';
				getServerData(itemId, instance);
			}, refresh);
			<?php endif; ?>

		});
	})();
</script>
