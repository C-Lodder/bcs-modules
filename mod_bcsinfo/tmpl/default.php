<?php
/**
 * @package    BCS_Info
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

Factory::getDocument()->addStyleDeclaration('
	.tm-footer .uk-modal {
		color: #323946;
	}
	.tm-footer .bcsinfo-button {
		position: fixed;
		top: 0;
		right: 0;
		z-index: 990;
		padding: 10px 15px;
		min-height: auto;
		font-size: 26px;
		line-height: 1;
		color: #333;
		background: #fff;
		border-radius: 0;
		box-shadow: none;
	}
	.tm-footer .bcsinfo-button:hover,
	.tm-footer .bcsinfo-button:focus {
		color: #323946;
	}
')
?>

<a href="#bcsinfo-modal" data-uk-modal="{center:true}" class="uk-button bcsinfo-button"><span class="uk-icon uk-icon-info-circle"></span></a>

<div id="bcsinfo-modal" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<h4 class="uk-modal-header uk-margin-top-remove">BCS Info</h4>
		<table class="uk-table uk-table-striped">
			<tr>
				<td>BCS Tags</td>
				<td><?php echo $tags; ?></td>
			</tr>
			<tr>
				<td>Team Server Password</td>
				<td><?php echo $password; ?></td>
			</tr>
		</table>
	</div>
</div>
