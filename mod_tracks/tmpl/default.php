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
HTMLHelper::_('stylesheet', 'mod_tracks/mod_tracks.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'mod_tracks/mod_tracks.js', ['version' => 'auto', 'relative' => true]);
?>

<div id="bcstracks" class="uk-slidenav-position bcstracks" data-uk-slider="{infinite: false}">
	<div class="uk-slider-container">
		<ul id="bcstracks-slider" class="uk-slider uk-grid uk-grid-width-medium-1-4 uk-grid-medium">
			<li class="placeholder">
				<div class="list-inner uk-flex uk-flex-middle uk-flex-center">
					<svg width="266px" height="220px"></svg>
					<span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span>
				</div>
			</li>
			<li class="placeholder">
				<div class="list-inner uk-flex uk-flex-middle uk-flex-center">
					<svg width="266px" height="220px"></svg>
					<span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span>
				</div>
			</li>
			<li class="placeholder">
				<div class="list-inner uk-flex uk-flex-middle uk-flex-center">
					<svg width="266px" height="220px"></svg>
					<span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span>
				</div>
			</li>
			<li class="placeholder">
				<div class="list-inner uk-flex uk-flex-middle uk-flex-center">
					<svg width="266px" height="220px"></svg>
					<span class="uk-icon-spinner uk-icon-spin" aria-hidden="true"></span>
				</div>
			</li>
		</ul>
	</div>
	<a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slider-item="previous"></a>
	<a href="" class="uk-slidenav uk-slidenav-next" data-uk-slider-item="next"></a>
</div>

<?php
	Factory::getDocument()->addScriptOptions(
		'bcs-tracks',
		[
			'authors' => $params->get('authors'),
		]
	);
?>
