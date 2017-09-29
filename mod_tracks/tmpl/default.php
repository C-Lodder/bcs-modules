<?php

/**
* @package    BCS_Latest_Tracks
* @copyright  Copyright (C) 2016 BCS. All rights reserved.
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

defined('_JEXEC') or die('Restricted access');

JHtml::_('script', JUri::root() . 'templates/yoo_monday/warp/vendor/uikit/js/components/slider.js', array(), array('async' => true));

$audio = JUri::root() . 'modules/mod_tracks/pussy-cat.mp3';

JFactory::getDocument()->addScriptDeclaration("
(function() {
	document.addEventListener('DOMContentLoaded', function() {

		var bcstracks = document.getElementById('bcstracks'),
		    buttons   = bcstracks.querySelectorAll('.uk-slidenav');

		for (var i = 0; i < buttons.length; i++)
		{
			buttons[i].addEventListener('click', function(event) {
				var audio = new Audio('" . $audio . "');
				audio.play();
			});
		}
	});
})();
");

JFactory::getDocument()->addStyleDeclaration('
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
');
?>

<div id="bcstracks" class="uk-slidenav-position bcstracks" data-uk-slider="{infinite:false}">
	<div class="uk-slider-container">
		<ul class="uk-slider uk-grid uk-grid-width-medium-1-4 uk-grid-medium">
			<?php
			$i = 0;

			foreach ($tracks as $track)
			{
				if ($i < 9)
				{
					$html  = '<li>';
					$html .= '<a href="https://tm.mania-exchange.com/tracks/' . $track['TrackID'] . '" target="_blank">';
					$html .= '<img src="' . $track['screenshot'] . '" alt="">';
					$html .= $cp->toHTML($track['GbxMapName']);
					$html .= '</a>';
					$html .= '<div class="by">by ' . $cp->toHTML($track['Username']) . '</div>';
					$html .= '<div class="by">Uploaded ' . $track['UploadedAt'] . '</div>';
					$html .= '</li>';
					echo $html;
				}
				$i++;
			}
			?>
		</ul>
	</div>

	<a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slider-item="previous"></a>
	<a href="" class="uk-slidenav uk-slidenav-next" data-uk-slider-item="next"></a>

</div>
