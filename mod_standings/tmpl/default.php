﻿<?php
/**
 * @package    BCS_Standings
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('stylesheet', 'mod_standings/mod_standings.min.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'mod_standings/mod_standings.min.js', ['version' => 'auto', 'relative' => true]);

$top = (int)$params->get('top', '10');
?>

<div class="uk-text-center uk-text-bold">
	<h1 class="uk-article-title uk-margin-top-remove">Standings</h1>
	<p class="uk-h3 uk-margin-top-remove">BCS (<span id="scoreBCS"></span>)<span class="uk-h4 uk-text-muted uk-display-inline-block uk-margin-small-left uk-margin-small-right">vs</span><?php echo $params->get('opponent'); ?> (<span id="scoreOther"></span>)</p>
</div>

<div class="uk-grid uk-grid-small" data-uk-grid-margin>
	<?php 
		foreach ($standings as $map)
		{
			if (strpos($map[0]['Name'], 'Chamber') === false)
			{
				echo '<div class="uk-width-medium-1-3">';
				echo '<div class="match_box">';
				echo '<ul class="uk-list uk-margin-bottom">';
				echo '<li class="uk-h6"><span class="uk-icon-justify uk-icon-flag-checkered" aria-hidden="true"></span> ' . $cp->toHTML($map[0]['Name']) . '</li>';
				echo '</ul>';
				echo '<ul class="uk-list uk-list-line">';

				$i = 1;
				$points = $top;

				foreach ($map as $v)
				{
					if ($i <= $top)
					{
						$class = 'top10';

						if ($i <= 3)
						{
							$class = 'top3';
						}
						else if ($i <= 6)
						{
							$class = 'top6';
						}

						// Strip tags and check for 'bcs' in name
						$bcs = '';
						$nickname = $cp->toHTML($v['NickName']);
						if (strpos(strip_tags($nickname), 'bcs') !== false)
						{
							$bcs = 'bcs';
						}

						echo '<li class="getPoints" data-player-id="' . $v['PlayerId'] . '" data-team="' . $bcs . '" data-name="' . $v['NickName'] . '" data-points="' . $points-- . '">';
						echo '<span class="match_number">'. $i++ . '.</span>';
						echo '<span class="' . $class . ' uk-text-bold"> ' . $helper->formatTime($v['Score']) . '</span>';
						echo ' - ' . $nickname;
						echo '</li>';
					}
				}
				echo '</ul>';
				echo '</div>';
				echo '</div>';
			}
		}
	?>
</div>

<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-medium-1-3">
		<div class="uk-text-center uk-text-bold">
			<h3 class="uk-margin-top-remove">Server Ranks</h3>
		</div>
		<div class="match_box">
			<ul class="uk-list uk-list-line">
				<?php
					$count = 1;
					foreach ($ranks as $rank)
					{
						$class = 'top10';
						$id = $rank->Id;

						if ($id <= 3)
						{
							$class = 'top3';
						}
						else if ($id <= 6)
						{
							$class = 'top6';
						}

						echo '<li id="' . $rank->Player . '">';
						echo '<span class="match_number">' . $id .  '.</span> - ';
						echo '<span class="' . $class . ' uk-text-bold">[' . $rank->Rank . ']</span> - ';
						echo '<span class="match_number">' . $cp->toHTML($rank->Player) .  '</span>';
						echo '</li>';
					}
				?>
			</ul>
		</div>
	</div>
	<div class="uk-width-medium-1-3">
		<div class="uk-text-center uk-text-bold">
			<h3 class="uk-margin-top-remove">Accumulated Points</h3>
		</div>
		<div class="match_box">
			<ul id="point-ranks" class="uk-list uk-list-line"></ul>
		</div>
	</div>
</div>
