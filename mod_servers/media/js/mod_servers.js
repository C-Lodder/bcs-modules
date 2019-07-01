/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2019 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
	window.addEventListener('DOMContentLoaded', () => {
		const options = Joomla.getOptions('servers');
		const instance = document.getElementById('tm_server');
		const spinners = instance.querySelectorAll('.spinner');
		const players = {};

		const notify = (server) => {
			if ('Notification' in window) {
				// Let's check whether notification permissions have already been granted
				if (Notification.permission === 'granted') {
					// If it's okay let's create a notification
					const settings = {
						body: 'New player joined ' + server,
						icon: options.img,
					};
					const notification = new Notification('New Player!', settings);
				}
			}
		};

		const getServerData = (itemId, element) => {
			// Assemble variables to submit
			const request = {
				option : 'com_ajax',
				module : 'servers',
				method : 'getServerData',
				format : 'json',
			};

			// If there is an active menu item then we need to add it to the request.
			if (itemId !== null) {
				request.Itemid = itemId;
			}

			// AJAX request
			jQuery.ajax({
				type: 'POST',
				data: request,
				beforeSend: () => {
					spinners.forEach((item) => {
						const spinner = document.createElement('span');
						spinner.classList.add('uk-icon-spinner');
						spinner.classList.add('uk-icon-spin');

						item.appendChild(spinner);
					});
				},
				success: (response) => {
					const data = response.data;
					if (response.success) {
						// Remove the spinners
						spinners.forEach((item) => {
							item.removeChild(item.lastChild);
						});

						// Loop through results
						Object.keys(data).forEach((key) => {
							const item = data[key];
							const playercount = element.querySelector('#count_' + item.id);
							const currentmap = element.querySelector('#currentmap_' + item.id);
							const nextmap = element.querySelector('#nextmap_' + item.id);

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
						});
					}
				}
			});

			return false;
		};

		const getPlayersNames = (itemId, element) => {
			// Assemble variables to submit
			const request = {
				option : 'com_ajax',
				module : 'servers',
				method : 'getPlayersNames',
				format : 'json',
				'data[server]' : element,
			};

			// If there is an active menu item then we need to add it to the request.
			if (itemId !== null) {
				request.Itemid = itemId;
			}

			const playerList = document.getElementById(element).querySelector('.player_list');

			jQuery.ajax({
				type: 'POST',
				data: request,
				beforeSend: () => {
					playerList.innerHTML = '';
					playerList.innerHTML = '<li><span class="uk-icon-spinner uk-icon-spin uk-icon-large" aria-hidden="true"></span></li>';
				},
				success: (response) => {
					if (response.success) {
						const results = response.data;
						if (response.data != '') {
							playerList.innerHTML = '';

							Object.keys(results).forEach((key) => {
								const result = results[key];
								const login = options.isAdmin == 1 ? ' <span class="uk-text-muted uk-text-small">(' + result.login + ')</span>' : '';
								const listItem = '<li>' + result.nickname + login + '</li>';
								playerList.insertAdjacentHTML('beforeend', listItem);
							});
						}
						else {
							playerList.innerHTML = '<li class="uk-text-danger">No players online</li>';
						}
					}
				}
			});

			return false;
		};

		jQuery('.players_modal').on({
			'show.uk.modal': function() {
				getPlayersNames(options.itemId, jQuery(this).attr('id'));
			}
		});

		if (!options.guest) {
			setInterval(() => {
				getServerData(options.itemId, instance);
			}, options.refresh);
		}
	});
})();
