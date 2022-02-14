<?php
/**
 * @package    BCS_Members
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

$exclude = [
	'fiendy',
	'Mouse',
	'flamecron',
	'alpha',
	'Lodder'
];

$isAdmin = Factory::getApplication()->getIdentity()->authorise('core.admin');
?>

<h3>Staff</h3>
<table>
	<thead>
		<tr>
			<th style="width: 25%">Username</th>
			<th>Role</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>fiendy</td>
			<td class="text-success">Leader</td>
		</tr>
		<tr>
			<td>Mouse</td>
			<td class="text-danger">Admin</td>
		</tr>
		<tr>
			<td>Flame</td>
			<td class="text-danger">Admin</td>
		</tr>
		<tr>
			<td>alpha</td>
			<td class="text-danger">Admin</td>
		</tr>
		<tr>
			<td>Lodder</td>
			<td class="text-danger">Webmaster</td>
		</tr>
	</tbody>
</table>

<h3>Members</h3>
<table>
	<thead>
		<tr>
			<th style="width: 25%">Username</th>
			<th>Role</th>
			<?php if ($isAdmin) : ?>
				<th>Last Visit Date</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($members as $member) : ?>
		<?php if (!in_array($member->username, $exclude)) : ?>
			<?php $lastVisit = $helper->timeElapsed($member->lastvisitDate); ?>
			<tr>
				<td><?php echo $member->username; ?></td>
				<td>Member</td>
				<?php if ($isAdmin) : ?>
					<td><?php echo $lastVisit['time']; ?></td>
				<?php endif; ?>
			</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>
