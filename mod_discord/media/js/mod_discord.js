/**
 * @package    BCS_Discord
 * @author     Lodder
 * @copyright  Copyright (C) 2019 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
	window.addEventListener('DOMContentLoaded', () => {
		const options = Joomla.getOptions('discord');
		const wrapper = document.getElementById('bcs-discord');
		const connect = document.getElementById('bcs-discord-connect');
		const settings = {
			method: 'GET',
			mode: 'cors',
			cache: 'reload'
		};

		fetch(`https://discordapp.com/api/guilds/${options.server}/widget.json`, settings).then(response => {
			if (response.status != 200) {
				console.log(response.status);
				return;
			}
			response.json().then(data => {
				const users = data.members;

				document.getElementById('bcs-discord-count').innerHTML = `<strong>${users.length}</strong> Members Online`;

				// Set the connect button link
				connect.setAttribute('href', data.instant_invite);

				// Create a new object with the channel_id as the key
				const channels = {};
				data.channels.forEach(({id, position, name}) => {
					channels[id] = {
						position: position,
						name: name,
						members: []
					};
				});

				// Assign members connected to a channel so that specific object
				users.forEach(user => {
					if (user.channel_id !== undefined) {
						channels[user.channel_id].members.push(user);
					}
				});

				// Need to reorder the object by channel.position
				Object.keys(channels).forEach(key => {
					channels[channels[key].position] = channels[key];
					delete channels[key];
				});

				// Loop thorugh the object and display the results
				Object.keys(channels).forEach(key => {
					const channel = channels[key];

					const channelItem = document.createElement('li');
					channelItem.innerText = channel.name;

					const membersList = document.createElement('ul');

					channel.members.forEach(member => {
						const avatar = document.createElement('img');
						avatar.setAttribute('src', member.avatar_url);
						avatar.classList.add('bcs-discord-avatar');

						if (member.status === 'online') {
							avatar.classList.add('bcs-discord-user-online');
						}
						else {
							avatar.classList.add('bcs-discord-user-offline');
						}

						const memberItem = document.createElement('li');
						memberItem.classList.add('bcs-discord-user');

						// Append username to the list item
						const username = document.createElement('span');
						username.innerText = member.nick || member.username;

						let bot;
						if (member.bot) {
							bot = document.createElement('span');
							bot.classList.add('bcs-discord-bot');
							bot.innerText = 'BOT';
						}

						// Append avatar and username to the left Div
						const divLeft = document.createElement('div');
						divLeft.classList.add('bcs-discord-user-left');
						divLeft.appendChild(avatar);
						divLeft.appendChild(username);

						if (member.bot) {
							divLeft.appendChild(bot);
						}

						// Append microphone/headphone icons
						const divRight = document.createElement('div');
						divRight.classList.add('bcs-discord-user-right');
						if (member.self_mute) {
							divRight.insertAdjacentHTML('beforeend', `<img src="${options.root}/media/mod_discord/images/microphone.svg" alt="">`);
						}
						if (member.self_deaf) {
							divRight.insertAdjacentHTML('beforeend', `<img src="${options.root}/media/mod_discord/images/headset.svg" alt="">`);
						}

						memberItem.appendChild(divLeft);
						memberItem.appendChild(divRight);

						// Append to the list
						membersList.appendChild(memberItem);
					});

					channelItem.appendChild(membersList);
					wrapper.appendChild(channelItem);
				});
			})
		}).catch(err => {
			console.log(err)
		})
	});
})();
