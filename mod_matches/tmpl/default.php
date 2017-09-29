<?php
/**
* @package    BCS_Matches
* @author     Lodder
* @copyright  Copyright (C) 2017 Lodder. All Rights Reserved
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC')  or die('Restricted access');

JFactory::getDocument()->addStyleDeclaration('
	.match_box {
		padding: 10px;
		background: rgba(0,0,0,.3);
	}
	.match_number {
		display: inline-block;
		min-width: 20px;
		text-align: right;
		color: #fff;
	}
	.top3 {
		color: #76ec00;
	}
	.top6 {
		color: #ff0;
	}
	.top10 {
		color: #e42222;
	}
');
?>

<div id="scores" class="uk-text-center uk-text-bold">
	<h1 class="uk-article-title uk-margin-top-remove">Standings</h1>
	<p class="uk-h3 uk-margin-top-remove">BCS (<span class="scoreBCS"></span>)<span class="uk-h4 uk-text-muted uk-display-inline-block uk-margin-small-left uk-margin-small-right">vs</span>Speed (<span class="scoreOther"></span>)</p>
</div>

<div class="uk-grid uk-grid-small" data-uk-grid-margin>
	<?php 
		foreach ($standings as $map)
		{
			echo '<div class="uk-width-medium-1-3">';
			echo '<div class="match_box">';
			echo '<ul class="uk-list uk-margin-bottom">';
			echo '<li class="uk-h6"><i class="uk-icon-justify uk-icon-flag-checkered"></i> ' . $cp->toHTML($map[0]['Name']) . '</li>';
			echo '</ul>';
			echo '<ul class="uk-list uk-list-line">';
			$i = 1;
			$points = 10;
			foreach ($map as $v)
			{
				if ($i <= 10)
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

					// Strip tags and check for 'вcs' in name
					$bcs = '';
					$nickname = $cp->toHTML($v['NickName']);
					if ((strpos(strip_tags($nickname), '|') !== false) && (strpos(strip_tags($nickname), 'bcs') !== false))
					{
						$bcs = 'bcs';
					}

					$input = $v['Score'];

					$microseconds = ($input % 1000 < 100) ? 0 . $input % 1000 : $input % 1000;
					$microseconds = ($microseconds < 10) ? 0 . $microseconds : $microseconds;
					$input = floor($input / 1000);

					$seconds = ($input % 60 < 10) ? 0 . $input % 60 : $input % 60;
					$input = floor($input / 60);

					$minutes = ($input % 60 == 0) ? '' : $input % 60 . '.';
					$input = floor($input / 60);
					
					$time = $minutes . $seconds . '.' . $microseconds;

					echo '<li class="getPoints" data-name="' . $bcs . '" data-points="' . $points-- . '">';
					echo '<span class="match_number">'. $i++ . '.</span>';
					echo '<span class="' . $class . ' uk-text-bold">' . $time . '</span>';
					echo ' - ' . $nickname;
					echo '</li>';
				}
			}
			echo '</ul>';
			echo '</div>';
			echo '</div>';
		}
	?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

	var totalBCS   = 0,
		totalOther = 0,
		wrapper    = document.getElementById('scores'),
		points     = document.querySelectorAll('.getPoints');

	for (var i = 0; i < points.length; i++)
	{
		var el = points[i];

		if (el.getAttribute('data-name') == 'bcs')
		{
			totalBCS += parseInt(el.getAttribute('data-points'));
		}
		else
		{
			totalOther += parseInt(el.getAttribute('data-points'));
		}
	}

	var classBCS   = totalBCS > totalOther ? 'success' : 'danger',
		classOther = totalBCS > totalOther ? 'danger' : 'success';

	wrapper.querySelector('.scoreBCS').innerHTML = totalBCS;
	wrapper.querySelector('.scoreBCS').classList.add('uk-text-' + classBCS);

	wrapper.querySelector('.scoreOther').innerHTML = totalOther;
	wrapper.querySelector('.scoreOther').classList.add('uk-text-' + classOther);
});
</script>
