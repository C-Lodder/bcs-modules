<?php
/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2019 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

// Get the helper file
\JLoader::register('ModServersHelper', __DIR__ . '/helper.php');
\JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

$app 	= Factory::getApplication();
$active = $app->getMenu()->getActive();
$Itemid = is_null($active) ? null : $active->id;
$title 	= $module->title;

$private = $params->get('private', 0);
$refresh = $params->get('refresh', 10) * 1000;

$user    = Factory::getUser();
$isAdmin = $user->authorise('core.admin');

$helper = new ModServersHelper;
$cp 	= new TMFColorParser();
$cp->replaceHex('#eeeeee', '#333333');

$servers = $helper->getServers();

require ModuleHelper::getLayoutPath('mod_servers');
