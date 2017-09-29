<?php 
/**
 * @package    BCS_Latest_Tracks
 * @copyright  Copyright (C) 2017 BCS. All rights reserved.
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

JLoader::register('ModBcstracksHelper', __DIR__ . '/helper.php');
JLoader::register('TMFColorParser', JPATH_BASE . '/tmfcolorparser.php');

// Initiate helper class
$authors = $params->get('authors', '');
$helper  = new ModBcstracksHelper($authors);

// Get tracks and cache the results
$cache = JFactory::getCache();
$cache->setCaching(1);
$cache->setLifeTime(720);
$tracks = $cache->call(array($helper, 'getAuthorTracks'));

// Color parser
$cp = new TMFColorParser();
$cp->replaceHex('#ffffff', '#aaaaaa');

require JModuleHelper::getLayoutPath('mod_tracks');
