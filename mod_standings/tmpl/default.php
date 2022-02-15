<?php
/**
 * @package    BCS_Standings
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('script', 'mod_standings/mod_standings.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

try
{
	$css = file_get_contents(JPATH_ROOT . '/media/mod_standings/css/mod_standings.min.css');
	$wa->addInlineStyle($css);
}
catch (Exception $e)
{
	// Nothing
}

$top = (int)$params->get('top', '10');
?>

<div class="standings-title">
	<h1>Standings</h1>
	<p class="is-size-3">BCS (<span id="scoreBCS"></span>) <span class="is-size-4 text-muted">vs</span> <?php echo $params->get('opponent'); ?> (<span id="scoreOther"></span>)</p>
</div>

<div class="standings">
	<?php 
		foreach ($standings as $map)
		{
			if (strpos($map[0]['Name'], 'Chamber') === false)
			{
				echo '<div class="match_box">';
				echo '<ul class="list-unstyled">';
				echo '<li class="is-size-6"><span class="uk-icon-justify uk-icon-flag-checkered" aria-hidden="true"></span> ' . $cp->toHTML($map[0]['Name']) . '</li>';
				echo '</ul>';
				echo '<ul class="list-unstyled">';

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
						echo '<span class="' . $class . ' text-bold"> ' . $helper->formatTime($v['Score']) . '</span>';
						echo ' - ' . $nickname;
						echo '</li>';
					}
				}
				echo '</ul>';
				echo '</div>';
			}
		}
	?>
</div>

<div class="standings">
	<div>
		<div class="text-center text-bold">
			<h3>Server Ranks</h3>
		</div>
		<div class="match_box">
			<ul class="list-unstyled">
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
						echo '<span class="' . $class . ' text-bold">[' . $rank->Rank . ']</span> - ';
						echo '<span class="match_number">' . $cp->toHTML($rank->Player) .  '</span>';
						echo '</li>';
					}
				?>
			</ul>
		</div>
	</div>
	<div>
		<div class="text-center text-bold">
			<h3>Accumulated Points</h3>
		</div>
		<div class="match_box">
			<ul id="point-ranks" class="list-unstyled"></ul>
		</div>
	</div>
</div>
