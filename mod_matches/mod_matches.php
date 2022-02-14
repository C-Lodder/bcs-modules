<?php
/**
 * @package    BCS_Matches
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Helper\ModuleHelper;

$matches = $params->get('matches');

require ModuleHelper::getLayoutPath('mod_matches');
