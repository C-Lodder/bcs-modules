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

$user = Factory::getUser();
$isAdmin = $user->authorise('core.admin');

?>

<h3>Staff</h3>
<table class="uk-table uk-table-striped">
	<thead>
		<tr>
			<th style="width: 25%">Username</th>
			<th>Role</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>fiendy</td>
			<td class="uk-text-success">Leader</td>
		</tr>
		<tr>
			<td>Mouse</td>
			<td class="uk-text-danger">Admin</td>
		</tr>
		<tr>
			<td>Flame</td>
			<td class="uk-text-danger">Admin</td>
		</tr>
		<tr>
			<td>alpha</td>
			<td class="uk-text-danger">Admin</td>
		</tr>
		<tr>
			<td>Lodder</td>
			<td class="uk-text-danger">Webmaster</td>
		</tr>
	</tbody>
</table>

<h3>Members</h3>
<table class="uk-table uk-table-striped">
	<thead>
		<tr>
			<th style="width: 25%">Username</th>
			<th>Role</th>
			<?php if ($isAdmin) : ?>
				<th>Last Visit Date</th>
				<th>Actions</th>
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
					<td>
						<a href="#" class="uk-button uk-button-small uk-button-danger"><span class="uk-icon uk-icon-ban" aria-hidden="true"></span> Ban</a>
						<?php if ($lastVisit['limit'] === true) : ?>
							<a href="#" class="uk-button uk-button-small uk-button-primary uk-margin-right"><span class="uk-icon uk-icon-user-times" aria-hidden="true"></span> Set Inactive</a>
						<?php endif; ?>
					</td>
				<?php endif; ?>
			</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>
