<?php
/**
 * @package    BCS_Mailbox
 * @author     Lodder
 * @copyright  Copyright (C) 2019 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

Factory::getDocument()->addStyleDeclaration('
	.tm-footer .bcsmailbox-button {
		position: fixed;
		top: 0;
		right: 60px;
		z-index: 990;
		padding: 10px 15px;
		min-height: auto;
		font-size: 26px;
		line-height: 1;
		color: #333;
		background: #fff;
		border-radius: 0;
		box-shadow: none;
	}
	.tm-footer .bcsmailbox-button:hover,
	.tm-footer .bcsmailbox-button:focus {
		color: #323946;
	}
');

$lang = Factory::getLanguage();

require_once JPATH_SITE.'/components/com_uddeim/uddeimlib.php';

$udd_pathtoadmin    = uddeIMgetPath('admin');
$udd_pathtouser     = uddeIMgetPath('user');
$udd_database       = uddeIMgetDatabase();
$udd_mosConfig_lang = uddeIMgetLang();

require_once $udd_pathtoadmin . '/admin.shared.php';
require_once $udd_pathtouser . '/crypt.class.php';
require_once $udd_pathtoadmin . '/config.class.php';

$udd_config = new uddeimconfigclass();

if (!defined('_UDDEIM_INBOX'))
{
	$udd_postfix = '';

	if ($udd_config->languagecharset)
	{
		$udd_postfix = ".utf8";
	}
	if (file_exists($udd_pathtoadmin . '/language' . $udd_postfix . '/' . $udd_mosConfig_lang . '.php'))
	{
		include_once $udd_pathtoadmin . '/language' . $udd_postfix . '/'.$udd_mosConfig_lang . '.php';
	}
	elseif (file_exists($udd_pathtoadmin . '/language' . $udd_postfix . '/english.php'))
	{
		include_once $udd_pathtoadmin . '/language' . $udd_postfix . '/english.php';
	}
	elseif (file_exists($udd_pathtoadmin . '/language/english.php'))
	{
		include_once $udd_pathtoadmin . '/language/english.php';
	}
}

$udd_userid    = uddeIMgetUserID();
$udd_mygroupid = uddeIMgetGroupID();

// first try to find a published link
$udd_sql = "SELECT id FROM `#__menu` WHERE link LIKE '%com_uddeim%' AND published=1 AND access".
		($udd_mygroupid == 0 ? "=" : "<=").$udd_mygroupid;
	$udd_sql .= " AND language IN (" . $udd_database->Quote($lang->get('tag')) . ",'*')";
$udd_sql .= " LIMIT 1";
$udd_database->setQuery($udd_sql);
$udd_item_id = (int)$udd_database->loadResult();

if (!$udd_item_id)
{
	// when no published link has been found, try to find an unpublished one
	$udd_sql = "SELECT id FROM `#__menu` WHERE link LIKE '%com_uddeim%' AND published=0 AND access".
			($udd_mygroupid==0 ? "=" : "<=").$udd_mygroupid;
		$udd_sql .= " AND language IN (" . $udd_database->Quote($lang->get('tag')) . ",'*')";
	$udd_sql .= " LIMIT 1";
	$udd_database->setQuery($udd_sql);
	$udd_item_id = (int)$udd_database->loadResult();
}
if ($udd_config->overwriteitemid)
{
	$udd_item_id = $udd_config->useitemid;
}

$udd_pms_link = uddeIMsefRelToAbs('index.php?option=com_uddeim&task=inbox' . ($udd_item_id ? '&Itemid=' . $udd_item_id : ''));

$udd_sql = "SELECT a.*, b." . ($udd_config->realnames ? "name" : "username")." AS displayname FROM `#__uddeim` AS a LEFT JOIN `#__users` AS b ON a.fromid=b.id WHERE `a`.`delayed`=0 AND a.toread=0 AND a.totrash=0 AND a.toid=" . (int)$udd_userid . " ORDER BY a.datum";
$udd_database->setQuery($udd_sql);
$udd_allmessages = $udd_database->loadObjectList();
$udd_totalmessages = count($udd_allmessages);

?>

<?php if ($udd_totalmessages > 0) : ?>
	<a href="<?php echo $udd_pms_link; ?>" class="uk-button bcsmailbox-button"><span class="uk-icon uk-icon-envelope uk-text-success"></span></a>
<?php else : ?>
	<a href="<?php echo $udd_pms_link; ?>" class="uk-button bcsmailbox-button"><span class="uk-icon uk-icon-envelope"></span></a>
<?php endif; ?>
