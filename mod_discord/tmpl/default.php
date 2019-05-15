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

<div id="bcs-discord-count" class="bcs-discord-count"></div>

<ul id="bcs-discord" class="bcs-discord uk-list uk-list-line"></ul>

<a href="#" id="bcs-discord-connect" class="uk-button uk-button-primary uk-button-small uk-float-right" target="_blank" rel="noopener noreferrer">Connect</a>

<?php
	Factory::getDocument()->addScriptOptions(
		'discord',
		[
			'server' => $params->get('server'),
			'root'   => $root
		]
	);
?>
