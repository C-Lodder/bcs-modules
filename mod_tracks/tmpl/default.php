<?php
/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2021 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('stylesheet', 'mod_tracks/mod_tracks.min.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'mod_tracks/mod_tracks.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
?>

<div id="bcstracks-slider" class="bcstracks">
	<div class="placeholder">
		<div class="list-inner flex flex-middle flex-center">
			<svg width="266px" height="193px"></svg>
		</div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="flex flex-wrap justify-content-between">
			<a class="button btn-sm" href="#">Download</a>
			<a class="button btn-sm" href="#">Install &amp; Play</a>
		</div>
	</div>
	<div class="placeholder">
		<div class="list-inner flex flex-middle flex-center">
			<svg width="266px" height="193px"></svg>
		</div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="flex flex-wrap justify-content-between">
			<a class="button btn-sm" href="#">Download</a>
			<a class="button btn-sm" href="#">Install &amp; Play</a>
		</div>
	</div>
	<div class="placeholder">
		<div class="list-inner flex flex-middle flex-center">
			<svg width="266px" height="193px"></svg>
		</div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="flex flex-wrap justify-content-between">
			<a class="button btn-sm" href="#">Download</a>
			<a class="button btn-sm" href="#">Install &amp; Play</a>
		</div>
	</div>
	<div class="placeholder">
		<div class="list-inner flex flex-middle flex-center">
			<svg width="266px" height="193px"></svg>
		</div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="placeholder-content"></div>
		<div class="flex flex-wrap justify-content-between">
			<a class="button btn-sm" href="#">Download</a>
			<a class="button btn-sm" href="#">Install &amp; Play</a>
		</div>
	</div>
</div>

<?php
	Factory::getApplication()->getDocument()->addScriptOptions(
		'bcs-tracks',
		[
			'authors' => $params->get('authors'),
		]
	);
?>
