<?php
/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

// Get the helper file
JLoader::register('ModServersHelper', __DIR__ . '/helper.php');
JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

$app 	= JFactory::getApplication();
$active = $app->getMenu()->getActive();
$Itemid = is_null($active) ? null : $active->id;
$title 	= $module->title;

$user = JFactory::getUser();

$helper = new ModServersHelper;
$cp 	= new TMFColorParser();
$cp->replaceHex('#eeeeee', '#333333');

$servers = $helper->getServers();

require JModuleHelper::getLayoutPath('mod_servers');
