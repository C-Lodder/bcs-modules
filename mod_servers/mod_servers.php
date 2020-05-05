<?php
/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

// Get the helper file
\JLoader::register('ModServersHelper', __DIR__ . '/helper.php');
\JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

$private = (int)$params->get('private', 0);
$refresh = (int)$params->get('refresh', 10) * 1000;

$user    = Factory::getUser();
$isAdmin = $user->authorise('core.admin');

$cp = new TMFColorParser;
$cp->replaceHex('#eeeeee', '#333333');

$helper = new ModServersHelper;
$servers = $helper->getServers();

require ModuleHelper::getLayoutPath('mod_servers');
