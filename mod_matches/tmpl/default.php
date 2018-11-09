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
				$winner = $match->opponent;
				$textClass = 'uk-text-danger';

				if ($match->score > $match->score2)
				{
					$winner = 'BCS';
					$textClass = 'uk-text-success';
				}
				else if ($match->score === $match->score2)
				{
					$winner = 'Draw';
					$textClass = 'uk-text-warning';
				}
			?>
			<tr>
				<td>BCS <span class="uk-text-warning">vs</span> <?php echo $match->opponent; ?></td>
				<td><?php echo $match->date; ?></td>
				<td class="<?php echo $textClass; ?>"><?php echo $match->score; ?> : <?php echo $match->score2; ?></td>
				<td class="uk-hidden-small"><?php echo $winner; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
