<?php
/**
 * @package    BCS_Info
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('stylesheet', 'mod_bcsinfo/mod_bcsinfo.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'mod_bcsinfo/mod_bcsinfo.js', ['version' => 'auto', 'relative' => true]);
?>

<a href="#bcsinfo-modal" data-uk-modal="{center:true}" class="uk-button bcsinfo-button"><span class="uk-icon uk-icon-info-circle"></span></a>

<div id="bcsinfo-modal" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<h4 class="uk-modal-header uk-margin-top-remove">BCS Info</h4>
		<table class="uk-table uk-table-striped">
			<?php foreach ($infos as $info) : ?>
				<tr>
					<td><?php echo $info->name; ?></td>
					<td><?php echo $info->info; ?></td>
					<td>
						<button class="uk-button uk-button-primary uk-button-small copy" type="button"><span class="uk-icon uk-icon-copy"></span> Copy</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
