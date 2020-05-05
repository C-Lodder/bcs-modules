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
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.core');
HTMLHelper::_('script', 'mod_servers/mod_servers.js', ['version' => 'auto', 'relative' => true]);
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
							<span class="uk-icon-lock" aria-hidden="true"></span>
						<?php endif; ?>
					</td>
					<td>
						<span id="count_<?php echo $id; ?>"><?php echo $server->playercount; ?></span> / <?php echo $server->maxplayers; ?>
						<span class="uk-icon-spinner uk-icon-spin uk-hidden" aria-hidden="true"></span>
					</td>
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
								<ul class="uk-list uk-list-line uk-text-center uk-text-large player_list"></ul>
							</div>
						</div>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>

<?php
	Factory::getDocument()->addScriptOptions(
		'servers',
		[
			'refresh' => $refresh,
			'isAdmin' => $isAdmin,
			'img'     => Uri::root() . 'modules/mod_servers/maniaplanet.png',
			'guest'   => $user->guest,
		]
	);
?>
