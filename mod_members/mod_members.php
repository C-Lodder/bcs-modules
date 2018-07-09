<?php
/**
 * @package    BCS_Members
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Helper\ModuleHelper;

\JLoader::register('ModMembersHelper', __DIR__ . '/helper.php');

// Initiate classes
$helper = new ModMembersHelper;

// Get the results
$members = $helper->getMembersList();

require ModuleHelper::getLayoutPath('mod_members');
