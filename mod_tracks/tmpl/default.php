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

HTMLHelper::_('script', 'mod_tracks/mod_tracks.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
// HTMLHelper::_('stylesheet', 'mod_tracks/mod_tracks.min.css', ['version' => 'auto', 'relative' => true]);

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

try
{
	$css = file_get_contents(JPATH_ROOT . '/media/mod_tracks/css/mod_tracks.min.css');
	$wa->addInlineStyle($css);
}
catch (Exception $e)
{
	// Nothing
}
?>

<div id="bcstracks" class="bcstracks">
	<a href="#" data-slide-move="prev" class="hidden"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="var(--hiq-text-color)" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"/></svg></a>
	<a href="#" data-slide-move="next" class="hidden"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="var(--hiq-text-color)" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"/></svg></a>
	<div id="bcstracks-slider" class="bcstracks-slider">
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
</div>

<?php
	Factory::getApplication()->getDocument()->addScriptOptions(
		'bcs-tracks',
		[
			'authors' => $params->get('authors'),
		]
	);
