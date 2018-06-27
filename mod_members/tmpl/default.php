﻿<?php
/**
 * @package    BCS_Members
 * @author     Lodder
 * @copyright  Copyright (C) 2018 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

$exclude = [
	'fiendy',
	'Mouse',
	'flamecron',
	'Lodder'
];

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
			<td class="uk-text-danger">Git</td>
		</tr>
		<tr>
			<td>Flame</td>
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
		</tr>
	</thead>
	<tbody>
		<?php foreach ($members as $member) : ?>
		<?php if (!in_array($member->username, $exclude)) : ?>
			<tr>
				<td><?php echo $member->username; ?></td>
				<td>Member</td>
			</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>
