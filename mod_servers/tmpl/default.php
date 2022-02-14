<?php
/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.core');
HTMLHelper::_('script', 'mod_servers/mod_servers.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
?>

<svg class="hidden" xmlns="http://www.w3.org/2000/svg"><symbol id="heart" viewBox="0 0 512 512"><path fill="currentColor" d="M462.3 62.7c-54.5-46.4-136-38.7-186.6 13.5L256 96.6l-19.7-20.3C195.5 34.1 113.2 8.7 49.7 62.7c-62.8 53.6-66.1 149.8-9.9 207.8l193.5 199.8c6.2 6.4 14.4 9.7 22.6 9.7 8.2 0 16.4-3.2 22.6-9.7L472 270.5c56.4-58 53.1-154.2-9.7-207.8zm-13.1 185.6L256.4 448.1 62.8 248.3c-38.4-39.6-46.4-115.1 7.7-161.2 54.8-46.8 119.2-12.9 142.8 11.5l42.7 44.1 42.7-44.1c23.2-24 88.2-58 142.8-11.5 54 46 46.1 121.5 7.7 161.2z"/></symbol></svg>

<svg class="hidden" xmlns="http://www.w3.org/2000/svg"><symbol id="eye" viewBox="0 0 576 512"><path fill="currentColor" d="M288 288a64 64 0 0 0 0-128c-1 0-1.88.24-2.85.29a47.5 47.5 0 0 1-60.86 60.86c0 1-.29 1.88-.29 2.85a64 64 0 0 0 64 64zm284.52-46.6C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 96a128 128 0 1 1-128 128A128.14 128.14 0 0 1 288 96zm0 320c-107.36 0-205.46-61.31-256-160a294.78 294.78 0 0 1 129.78-129.33C140.91 153.69 128 187.17 128 224a160 160 0 0 0 320 0c0-36.83-12.91-70.31-33.78-97.33A294.78 294.78 0 0 1 544 256c-50.53 98.69-148.64 160-256 160z"/></symbol></svg>

<svg class="hidden" xmlns="http://www.w3.org/2000/svg"><symbol id="users" viewBox="0 0 640 512"><path fill="currentColor" d="M480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm0-160c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zM192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm0-192c44.1 0 80 35.9 80 80s-35.9 80-80 80-80-35.9-80-80 35.9-80 80-80zm80.1 212c-33.4 0-41.7 12-80.1 12-38.4 0-46.7-12-80.1-12-36.3 0-71.6 16.2-92.3 46.9C7.2 341.3 0 363.4 0 387.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c0-23.8-7.2-45.9-19.6-64.3-20.7-30.7-56-46.9-92.3-46.9zM352 432c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16v-44.8c0-16.6 4.9-32.7 14.1-46.4 13.8-20.5 38.4-32.8 65.7-32.8 27.4 0 37.2 12 80.2 12s52.8-12 80.1-12c27.3 0 51.9 12.3 65.7 32.8 9.2 13.7 14.1 29.8 14.1 46.4V432zm271.7-114.9C606.4 291.5 577 278 546.8 278c-27.8 0-34.8 10-66.8 10s-39-10-66.8-10c-13.2 0-26.1 3-38.1 8.1 15.2 15.4 18.5 23.6 20.2 26.6 5.7-1.6 11.6-2.6 17.9-2.6 21.8 0 30 10 66.8 10s45-10 66.8-10c21 0 39.8 9.3 50.4 25 7.1 10.5 10.9 22.9 10.9 35.7V408c0 4.4-3.6 8-8 8H416c0 17.7.3 22.5-1.6 32H600c22.1 0 40-17.9 40-40v-37.3c0-19.9-6-38.3-16.3-53.6z"/></symbol></svg>

<svg class="hidden" xmlns="http://www.w3.org/2000/svg"><symbol id="sign-in" viewBox="0 0 512 512"><path fill="currentColor" d="M184 83.5l164.5 164c4.7 4.7 4.7 12.3 0 17L184 428.5c-4.7 4.7-12.3 4.7-17 0l-7.1-7.1c-4.7-4.7-4.7-12.3 0-17l132-131.4H12c-6.6 0-12-5.4-12-12v-10c0-6.6 5.4-12 12-12h279.9L160 107.6c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.6-4.7 12.2-4.7 16.9 0zM512 400V112c0-26.5-21.5-48-48-48H332c-6.6 0-12 5.4-12 12v8c0 6.6 5.4 12 12 12h132c8.8 0 16 7.2 16 16v288c0 8.8-7.2 16-16 16H332c-6.6 0-12 5.4-12 12v8c0 6.6 5.4 12 12 12h132c26.5 0 48-21.5 48-48z"/></symbol></svg>

<svg class="hidden" xmlns="http://www.w3.org/2000/svg"><symbol id="lock" viewBox="0 0 448 512"><path fill="currentColor" d="M224 420c-11 0-20-9-20-20v-64c0-11 9-20 20-20s20 9 20 20v64c0 11-9 20-20 20zm224-148v192c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V272c0-26.5 21.5-48 48-48h16v-64C64 71.6 136-.3 224.5 0 312.9.3 384 73.1 384 161.5V224h16c26.5 0 48 21.5 48 48zM96 224h256v-64c0-70.6-57.4-128-128-128S96 89.4 96 160v64zm320 240V272c0-8.8-7.2-16-16-16H48c-8.8 0-16 7.2-16 16v192c0 8.8 7.2 16 16 16h352c8.8 0 16-7.2 16-16z"/></symbol></svg>

<svg class="hidden" xmlns="http://www.w3.org/2000/svg"><symbol id="loading" viewBox="0 0 512 512"><path fill="currentColor" d="M288 32c0 17.673-14.327 32-32 32s-32-14.327-32-32 14.327-32 32-32 32 14.327 32 32zm-32 416c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm256-192c0-17.673-14.327-32-32-32s-32 14.327-32 32 14.327 32 32 32 32-14.327 32-32zm-448 0c0-17.673-14.327-32-32-32S0 238.327 0 256s14.327 32 32 32 32-14.327 32-32zm33.608 126.392c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zm316.784 0c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32zM97.608 65.608c-17.673 0-32 14.327-32 32 0 17.673 14.327 32 32 32s32-14.327 32-32c0-17.673-14.327-32-32-32z"/><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 7.5 7.5" to="360 7.5 7.5" dur="1.5s" additive="sum" repeatCount="indefinite" /></symbol></svg>

<table id="tm_server">
	<thead>
		<tr>
			<th>Server</th>
			<th style="width:100px">Players</th>
			<th class="hidden-small">Current Map</th>
			<th class="hidden-small">Next Map</th>
			<th class="hidden-small" style="width:160px">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($servers as $server) : ?>
			<?php $login = $server->login; ?>
			<?php if ($login === 'bcseslspeed' || ($private === 0 && $login === 'bcsrace')) : ?>
				<?php continue; ?>
			<?php else : ?>
				<?php
					$id       = $server->id;
					$nickname = $cp->toHTML($server->nickname);
					$current  = $server->currentmap ?? '';
					$next     = $server->nextmap ?? '';
					$players  = $helper->getPlayers($id);
				?>
				<tr>
					<td>
						<?php echo $nickname; ?>
						<?php if ($login === 'bcsrace') :  ?>
							<svg width="15" height="15"><use xlink:href="#lock"></use></svg>
						<?php endif; ?>
					</td>
					<td>
						<span id="count_<?php echo $id; ?>"><?php echo $server->playercount; ?></span> / <?php echo $server->maxplayers; ?>
						<svg width="15" height="15" class="icon-spin hidden"><use xlink:href="#loading"></use></svg>
					</td>
					<td class="hidden-small"><span id="currentmap_<?php echo $id; ?>"><?php echo $cp->toHTML($current, true); ?></span></td>
					<td class="hidden-small"><span id="nextmap_<?php echo $id; ?>"><?php echo $cp->toHTML($next, true); ?></span></td>
					<td class="hidden-small" class="server-actions">
						<div class="flex justify-content-between">
							<a href="#" id="<?php echo $login; ?>" data-bs-toggle="modal" data-bs-target="#players_modal_<?php echo $id; ?>" class="show-players" title="Players"><svg width="25" height="25"><use xlink:href="#users"></use></svg></a>	
							<a class="hidden-small" href="maniaplanet://#join=<?php echo $login . '@' . $server->title; ?>" target="_blank" title="Join"><svg width="25" height="25"><use xlink:href="#sign-in"></use></svg></a>
							<a class="hidden-small" href="maniaplanet://#spectate=<?php echo $login; ?>" target="_blank" title="Spectate"><svg width="25" height="25"><use xlink:href="#eye"></use></svg></a>
							<a class="hidden-small" href="maniaplanet://#addfavorite=<?php echo $login; ?>" target="_blank" title="Add to favourites"><svg width="25" height="25"><use xlink:href="#heart"></use></svg></a>
						</div>
					</td>
				</tr>
			<?php endif; ?>
			<?php
				echo HTMLHelper::_(
				'bootstrap.renderModal',
				'players_modal_' . $id,
				[
					'title'  => 'Players on <span class="server-name">' . $nickname . '</span>',
					'height' => '100%',
					'width'  => '100%',
					'modalWidth'  => '50',
					'bodyHeight'  => '40',
					'footer' => '<button type="button" data-bs-dismiss="modal" aria-hidden="true">'
						. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>',
				],
				'<ul class="list-unstyled text-center player-list"></ul>',
			);
			?>
		<?php endforeach; ?>
	</tbody>
</table>

<?php
Factory::getApplication()->getDocument()->addScriptOptions(
	'servers',
	[
		'refresh' => $refresh,
		'isAdmin' => $isAdmin,
		'img'     => Uri::root() . 'modules/mod_servers/maniaplanet.png',
		'guest'   => $user->guest,
	]
);
