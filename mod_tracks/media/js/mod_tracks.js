/**
 * @package    BCS_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2019 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
	document.addEventListener('DOMContentLoaded', () => {
		// Assemble variables to submit
		const options = Joomla.getOptions('bcs-tracks');
		const itemId = options.itemId;
		const request = {
			option : 'com_ajax',
			module : 'tracks',
			method : 'getAuthorTracks',
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
			success({success, data}) {
				if (success) {
					const wrapper = document.getElementById('bcstracks-slider');

					Object.keys(data).forEach(key => {
						const obj = data[key];
						const list = document.createElement('li');

						const anchor = document.createElement('a');
						anchor.setAttribute('href', `https://tm.mania-exchange.com/tracks/${obj.TrackID}`);
						anchor.setAttribute('target', '_blank');

						const span = document.createElement('span');
						span.innerHTML = obj.GbxMapName;

						const by = document.createElement('div');
						by.classList.add('by');
						by.innerHTML = `by ${obj.Username}`;

						const by2 = document.createElement('div');
						by2.classList.add('by');
						by2.innerText = `Uploaded ${obj.UploadedAt}`;

						const img = new Image;
						img.addEventListener('load', () => {
							anchor.appendChild(img);
							anchor.appendChild(span);
						}, false);
						img.src = obj.screenshot;

						list.appendChild(anchor);
						list.appendChild(by);
						list.appendChild(by2);

						if (obj.magnets) {
							const magnet = document.createElement('div');
							magnet.classList.add('magnet');
							magnet.innerHTML = '<strong>WARNING</strong>: Contains magnetic blocks!';
							list.appendChild(magnet);
						}

						wrapper.insertBefore(list, wrapper.firstChild);
					});

					const placeholders = wrapper.getElementsByClassName('placeholder');
					while (placeholders.length > 0) {
						placeholders[0].parentNode.removeChild(placeholders[0]);
					}

					const height = wrapper.querySelector('li').height;
					wrapper.style.minHeight = `${height}px`;
				}
			}
		});
	});
})();
