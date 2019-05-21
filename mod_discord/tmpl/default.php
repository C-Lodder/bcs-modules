<?php
/**
 * @package    BCS_Discord
 * @author     Lodder
 * @copyright  Copyright (C) 2019 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('stylesheet', 'mod_discord/mod_discord.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'mod_discord/mod_discord.js', ['version' => 'auto', 'relative' => true]);

$root = JUri::root();
?>

<h3 class="uk-panel-title"><img src="<?php echo $root . 'media/mod_discord/images/logo.svg'; ?>" alt=""> Discord</h3>

<?php if (isset($server)) : ?>
	<?php if ($membersCount == 1) : ?>
		<div id="bcs-discord-count" class="bcs-discord-count"></div>
	<?php endif; ?>

	<?php if (isset($height)) : ?>
		<div class="uk-overflow-container uk-margin" style="height:<?php echo $height; ?>px">
	<?php else : ?>
		<div class="uk-margin">
	<?php endif; ?>

		<ul id="bcs-discord" class="bcs-discord uk-list uk-list-line"></ul>

		<?php if ($members == 1) : ?>
			<h5>Members</h5>
			<ul id="bcs-discord-members" class="bcs-discord-members uk-list"></ul>
		<?php endif; ?>

	</div>

	<?php if ($connect == 1) : ?>
		<a href="#" id="bcs-discord-connect" class="uk-button uk-button-primary uk-button-small uk-float-right" target="_blank" rel="noopener noreferrer">Connect</a>
	<?php endif; ?>
<?php else : ?>
	<p>Please enter a Server ID</p>
<?php endif; ?>

<?php
	Factory::getDocument()->addScriptOptions(
		'discord',
		[
			'server'       => $server,
			'members'      => $members,
			'membersCount' => $membersCount,
			'connect'      => $connect
		]
	);
?>
