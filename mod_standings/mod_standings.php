<?php
/**
 * @package    BCS_Standings
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Helper\ModuleHelper;

// Get the helper file
\JLoader::register('ModStandingsHelper', __DIR__ . '/helper.php');
\JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

// Initiate classes
$helper = new ModStandingsHelper;
$cp 	= new TMFColorParser();

// Get the results
$standings = $helper->getMatchStandings();

require ModuleHelper::getLayoutPath('mod_standings');
