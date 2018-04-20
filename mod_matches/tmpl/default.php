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
			<?php
				$winner = $match[0];
				$textClass = 'uk-text-danger';

				if ($match[2] > $match[3])
				{
					$winner = 'BCS';
					$textClass = 'uk-text-success';
				}
				else if ($match[2] === $match[3])
				{
					$winner = 'Draw';
					$textClass = 'uk-text-warning';
				}
			?>
			<tr>
				<td>BCS <span class="uk-text-warning">vs</span> <?php echo $match[0]; ?></td>
				<td><?php echo $match[1]; ?></td>
				<td class="<?php echo $textClass; ?>"><?php echo $match[2]; ?> : <?php echo $match[3]; ?></td>
				<td class="uk-hidden-small"><?php echo $winner; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
