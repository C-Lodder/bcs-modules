<?php
/**
 * @package    BCS_Matches
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

?>

<div class="overflow-auto" style="height:340px">
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th class="hidden-small">Date</th>
				<th>Score</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($matches as $match) : ?>
			<?php
				$textClass = 'text-danger';

				if ($match->score > $match->score2)
				{
					$textClass = 'text-success';
				}
				else if ($match->score === $match->score2)
				{
					$textClass = 'text-warning';
				}
			?>
			<tr>
				<td>BCS <span class="text-warning">vs</span> <?php echo $match->opponent; ?></td>
				<td class="hidden-small"><?php echo $match->date; ?></td>
				<td class="<?php echo $textClass; ?>"><?php echo $match->score; ?> : <?php echo $match->score2; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
