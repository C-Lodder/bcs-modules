<?php 
/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

\JLoader::register('ModBcstracksHelper', __DIR__ . '/helper.php');
\JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

// Initiate helper class
$authors = $params->get('authors', '');
$helper  = new ModBcstracksHelper($authors);

// Get tracks and cache the results
$cache = Factory::getCache();
$cache->setCaching(1);
$cache->setLifeTime(360);
$tracks = $cache->call([$helper, 'getAuthorTracks']);

// Color parser
$cp = new TMFColorParser();
$cp->replaceHex('#ffffff', '#aaaaaa');

require ModuleHelper::getLayoutPath('mod_tracks');
