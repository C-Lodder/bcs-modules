<?php
/**
 * @package    BCS_Info
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::_('stylesheet', 'mod_bcsinfo/mod_bcsinfo.min.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'mod_bcsinfo/mod_bcsinfo.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);

$table = '<table class="table-striped">';
foreach ($infos as $info)
{
	$table .= '<tr>';
	$table .= '<td>'. $info->name . '</td>';
	$table .= '<td>'. $info->info . '</td>';
	$table .= '<td>';
	$table .= '<button class="button button-small copy" type="button"><span class="uk-icon uk-icon-copy"></span> Copy</button>';
	$table .= '</td>';
	$table .= '</tr>';
}
$table .= '</table>';

echo HTMLHelper::_(
	'bootstrap.renderModal',
	'bcsinfo-modal',
	[
		'title'  => 'BCS Info',
		'height' => '100%',
		'width'  => '100%',
		'modalWidth'  => '50',
		'bodyHeight'  => '40',
		'footer' => '<button type="button" data-bs-dismiss="modal" aria-hidden="true">'
			. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>',
	],
	$table,
);
?>

<a href="#bcsinfo-modal2" data-bs-toggle="modal" data-bs-target="#bcsinfo-modal" class="bcsinfo-button"><svg aria-hidden="true" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"/></svg></a>
