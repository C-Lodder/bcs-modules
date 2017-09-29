<?php
/**
* @package    BCS_Matches
* @author     Lodder
* @copyright  Copyright (C) 2016 Lodder. All Rights Reserved
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC') or die('Restricted access');

// Get the helper file
JLoader::register('ModMatchesHelper', __DIR__ . '/helper.php');
JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

// Initiate classes
$helper = new ModMatchesHelper;
$cp 	= new TMFColorParser();

// Get the results
$standings = $helper->getMatchStandings();

require JModuleHelper::getLayoutPath('mod_matches');
