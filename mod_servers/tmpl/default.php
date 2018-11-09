<?php
/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

$img = JUri::root() . 'modules/mod_servers/maniaplanet.png';
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
					<td class="spinner">
						<?php echo $nickname; ?>
						<?php if ($login === 'bcsrace') :  ?>
							<span class="uk-icon-lock" aria-hidden="true"></span>
						<?php endif; ?>
					</td>
					<td><span id="count_<?php echo $id; ?>"><?php echo $server->playercount; ?></span> / <?php echo $server->maxplayers; ?></td>
					<td class="uk-hidden-small"><span id="currentmap_<?php echo $id; ?>"><?php echo $cp->toHTML($current, true); ?></span></td>
					<td class="uk-visible-large"><span id="nextmap_<?php echo $id; ?>"><?php echo $cp->toHTML($next, true); ?></span></td>
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
			var isAdmin  = '<?php echo $isAdmin; ?>';
			var instance = document.getElementById('tm_server');
			var spinners = instance.querySelectorAll('.spinner');
			var players  = {};

			function notify(server) {
				if ('Notification' in window) {
					// Let's check whether notification permissions have already been granted
					if (Notification.permission === 'granted') {
						// If it's okay let's create a notification
						var options = {
							body: 'New player joined ' + server,
							icon: '<?php echo $img; ?>'
						};
						var notification = new Notification('New Player!', options);
					}
				}
			}

			function getServerData(itemId, instance) {
				// Assemble variables to submit
				var request = {
					option : 'com_ajax',
					module : 'servers',
					method : 'getServerData',
					format : 'json',
				};

				// If there is an active menu item then we need to add it to the request.
				if (itemId !== null) {
					request['Itemid'] = itemId;
				}

				// AJAX request
				jQuery.ajax({
					type: 'POST',
					data: request,
					beforeSend: function() {
						for (var i = 0; i < spinners.length; i++) {
							var spinner = document.createElement('span');
							spinner.classList.add('uk-icon-spinner');
							spinner.classList.add('uk-icon-spin');

							spinners[i].appendChild(spinner);
						}
					},
					success: function(response) {
						var data = response.data;
						if (response.success) {
							// Remove the spinners
							for (var i = 0; i < spinners.length; i++) {
								spinners[i].removeChild(spinners[i].lastChild);
							}

							// Loop through results
							for (var prop in data) {
								// Skip loop if the property is from prototype
								if (!data.hasOwnProperty(prop)) continue;

								var item        = data[prop];
								var playercount = instance.querySelector('#count_' + item.id);
								var currentmap  = instance.querySelector('#currentmap_' + item.id);
								var nextmap     = instance.querySelector('#nextmap_' + item.id);

								// Update player count
								if (playercount) {
									// Check if the new player count is bigger than the current player count
									if (players.login !== undefined && item.playercount > playercount.innerText) {
										notify(item.raw);
									}
									// Update player count for notifications
									players.login = item.playercount;

									playercount.innerHTML = item.playercount;
								}

								// Update current map
								if (currentmap) {
									currentmap.innerHTML = item.currentmap;
								}

								// Update next map
								if (nextmap) {
									nextmap.innerHTML = item.nextmap;
								}
							}
						}
					}
				});

				return false;
			}

			function getPlayersNames(itemId, instance) {
				// Assemble variables to submit
				var request = {
					option         : 'com_ajax',
					module         : 'servers',
					method         : 'getPlayersNames',
					format         : 'json',
					'data[server]' : instance,
				};

				// If there is an active menu item then we need to add it to the request.
				if (itemId !== null) {
					request['Itemid'] = itemId;
				}

				var playerList = document.getElementById(instance).querySelector('.player_list');

				jQuery.ajax({
					type: 'POST',
					data: request,
					beforeSend: function() {
						playerList.innerHTML = '';
						playerList.innerHTML = '<li><span class="uk-icon-spinner uk-icon-spin uk-icon-large" aria-hidden="true"></span></li>';
					},
					success: function(response) {
						if (response.success) {
							var results = response.data;
							if (response.data != '') {
								playerList.innerHTML = '';

								for (var l = 0; l < results.length; l++) {
									var login = isAdmin == 1 ? ' <span class="uk-text-muted uk-text-small">(' + results[l].login + ')</span>' : '';
									var listItem = '<li>' + results[l].nickname + login + '</li>';
									playerList.insertAdjacentHTML('beforeend', listItem);
								}
							}
							else {
								playerList.innerHTML = '<li class="uk-text-danger">No players online</li>';
							}
						}
					}
				});

				return false;
			}

			jQuery('.players_modal').on({
				'show.uk.modal': function() {
					var instance = jQuery(this).attr('id');
					var itemId   = '<?php echo $Itemid; ?>';

					getPlayersNames(itemId, instance);
				}
			});

			<?php if (!$user->guest) : ?>
			setInterval(function() {
				var itemId = '<?php echo $Itemid; ?>';
				getServerData(itemId, instance);
			}, refresh);
			<?php endif; ?>

		});
	})();
</script>
