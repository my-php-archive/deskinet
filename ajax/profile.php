<?php
if(!$_GET['_']) { die('0error de usuario'); }
include('../config.php');
include('../functions.php');
if(!$_GET['tab'] || $_GET['tab'] < 1 || $_GET['tab'] > 7 || !$_GET['user'] || !mysql_num_rows($q = mysql_query("SELECT * FROM `users` WHERE id = '".mysql_clean($_GET['user'])."'"))) { die('0Error de usuario'); }
$user = mysql_fetch_array($q);
$tab = 'general';
$currenttab = '1';
switch($_GET['tab']) {
	case '2': $tab = 'info'; $currenttab = '2'; break;
	case '3':
		$query = mysql_query("SELECT g.name, g.urlname, g.cat, g.avatar FROM groups AS g, group_members AS m WHERE m.user = '".$currentuser['id']."' && g.id = m.group ORDER BY m.time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'groups';
			$currenttab = '3';
		}
	break;
	case '4':
		$tab = 'photos';
		$query = mysql_query("SELECT url, `desc` FROM `photos` WHERE user = '".$currentuser['id']."' ORDER BY time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'photos';
			$currenttab = '4';
		}
	break;
	case '5':
		$tab = 'followers';
		$query = mysql_query("SELECT u.nick, u.avatar, u.personal_text, u.country FROM follows AS f, users AS u WHERE f.what = '2' && f.who = '".$user['id']."' && u.id = f.user ORDER BY f.time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'followers';
			$currenttab = '5';
		}
	break;
	case '6':
		$tab = 'following';
		$query = mysql_query("SELECT u.nick, u.avatar, u.personal_text, u.country FROM follows AS f, users AS u WHERE f.what = '2' && f.user = '".$user['id']."' && u.id = f.who ORDER BY f.time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'following';
			$currenttab = '6';
		}
	break;
	case '7':
		$tab = 'medals';
		$query = mysql_query("SELECT d.*, m.link, m.link_title, m.time FROM medals AS m, medals_data AS d WHERE m.user = '".$user['id']."' && d.id = m.medal ORDER BY time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'medals';
			$currenttab = '7';
		}
	break;
}
define('ok', true);
include('../Pages/profile_'.$tab.'.php');
?>