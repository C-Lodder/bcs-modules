<?php
/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('script', Uri::root() . 'templates/yoo_monday/warp/vendor/uikit/js/components/slider.js', [], ['async' => true]);

$audio = Uri::root() . 'modules/mod_tracks/pussy-cat.mp3';

Factory::getDocument()->addScriptDeclaration("
(function() {
	document.addEventListener('DOMContentLoaded', function() {

		var bcstracks = document.getElementById('bcstracks'),
		    buttons   = bcstracks.querySelectorAll('.uk-slidenav');

		for (var i = 0; i < buttons.length; i++) {
			buttons[i].addEventListener('click', function(event) {
				var audio = new Audio('" . $audio . "');
				audio.play();
			});
		}
	});
})();
");

Factory::getDocument()->addStyleDeclaration('
	.bcstracks a {
		display: block;
	}
	.bcstracks a:hover,
	.bcstracks a:focus {
		text-decoration: none;
	}
	.bcstracks .by {
		display: block;
		font-size: 12px;
		font-style: italic;
		color: #111;
	}
	.bcstracks .magnet {
		display: block;
		font-size: 12px;
		color: #f00;
	}
	.bcstracks img {
		margin-bottom: 5px;
	}

	.uk-slidenav-position .uk-slidenav {
		display: block !important;
		background: rgba(255,255,255,.7);
		color: #222;
		font-size: 40px;
		transform: translateY(-50%);
		border-radius: 3px;
	}
	.uk-slidenav-position .uk-slidenav:hover,
	.uk-slidenav-position .uk-slidenav:focus {
		color: #222;
	}

	.placeholder > div {
		background: #eeeded;
		width: 266px;
		height: 220px;
		text-align: center;
	}
	.placeholder .uk-icon-spinner {
		font-size: 35px;
	}
');
?>

<div id="bcstracks" class="uk-slidenav-position bcstracks" data-uk-slider="{infinite: false}">
	<div class="uk-slider-container">
		<ul id="bcstracks-slider" class="uk-slider uk-grid uk-grid-width-medium-1-4 uk-grid-medium">
			<li class="placeholder">
				<div class="uk-flex uk-flex-middle uk-flex-center"><span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span></div>
			</li>
			<li class="placeholder">
				<div class="uk-flex uk-flex-middle uk-flex-center"><span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span></div>
			</li>
			<li class="placeholder">
				<div class="uk-flex uk-flex-middle uk-flex-center"><span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span></div>
			</li>
			<li class="placeholder">
				<div class="uk-flex uk-flex-middle uk-flex-center"><span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span></div>
			</li>
		</ul>
	</div>
	<a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slider-item="previous"></a>
	<a href="" class="uk-slidenav uk-slidenav-next" data-uk-slider-item="next"></a>
</div>

<script>
	(function() {
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {

			// Assemble variables to submit
			var itemId = '<?php echo $Itemid; ?>';
			var request = {
				option : 'com_ajax',
				module : 'tracks',
				method : 'getAuthorTracks',
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
				success: function(response) {
					if (response.success) {
						var wrapper = document.getElementById('bcstracks-slider');
						wrapper.innerHTML = '';

						Object.keys(response.data).forEach(function(key) {
							var obj = response.data[key];
							var list = document.createElement('li');

							var anchor = document.createElement('a');
							anchor.setAttribute('href', 'https://tm.mania-exchange.com/tracks/' + obj.TrackID);
							anchor.setAttribute('target', '_blank');

							var span = document.createElement('span');
							span.innerHTML = obj.GbxMapName;

							var by = document.createElement('div');
							by.classList.add('by');
							by.innerHTML = 'by ' + obj.Username;

							var by2 = document.createElement('div');
							by2.classList.add('by');
							by2.innerText = 'Uploaded ' + obj.UploadedAt;

							var img = new Image;
							img.addEventListener('load', function() {
								anchor.appendChild(img);
								anchor.appendChild(span);
							}, false);
							img.src = obj.screenshot;

							list.appendChild(anchor);
							list.appendChild(by);
							list.appendChild(by2);

							if (obj.magnets) {
								var magnet = document.createElement('div');
								magnet.classList.add('magnet');
								magnet.innerHTML = '<strong>WARNING</strong>: Contains magnetic blocks!';
								list.appendChild(magnet);
							}

							wrapper.appendChild(list);
						});

						var height = wrapper.querySelector('li').height;
						wrapper.style.minHeight = height + 'px';
					}
				}
			});
		});
	})();
</script>
