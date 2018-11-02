<?php
/**
 * @package    BCS_Info
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Helper\ModuleHelper;

$tags     = $params->get('tags');
$password = $params->get('password');

require ModuleHelper::getLayoutPath('mod_members');
