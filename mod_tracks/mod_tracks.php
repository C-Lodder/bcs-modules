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

\JLoader::register('ModTracksHelper', __DIR__ . '/helper.php');

$active = Factory::getApplication()->getMenu()->getActive();
$Itemid = is_null($active) ? null : $active->id;

require ModuleHelper::getLayoutPath('mod_tracks');
