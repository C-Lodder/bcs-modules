<?php
/**
 * @package    BCS_Matches
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

?>

<div class="uk-overflow-container" style="height:340px">
	<table class="uk-table uk-table-striped">
		<thead>
			<tr>
				<th>Title</th>
				<th>Date</th>
				<th>Score</th>
				<th class="uk-hidden-small">Winner</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($matches as $match) : ?>
			<tr>
				<td>BCS <span class="uk-text-warning">vs</span> TFC</td>
				<td>27th November 2017</td>
				<td class="uk-text-success">464 : 86</td>
				<td class="uk-hidden-small">BCS</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
