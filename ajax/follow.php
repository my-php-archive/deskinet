<?php
if(!$_GET['_']) { die('Error provocado por el usuario'); }
include('../config.php');
include('../functions.php');
if(!isLogged() || !$_GET['what'] || !$_GET['who'] || !$_GET['follow'] || ($_GET['what'] != '1' && $_GET['what'] != '2' && $_GET['what'] != '3' && $_GET['what'] != '4') || ($_GET['follow'] != '1' && $_GET['follow'] != '2')) { die('Error provocado por el usuario'); }
switch($_GET['what']) {
	default:
	case '1':
		$table = 'posts';
		$who = 'el post';
	break;
	case '2':
		$table = 'users';
		$who = 'el usuario';
	break;
	case '3':
		$table = 'groups';
		$who = 'la comunidad';
	break;
	case '4':
		$table = 'group_posts';
		$who = 'el tema';
	break;
}
if(!mysql_num_rows(mysql_query("SELECT id FROM `".$table."` WHERE id = '".mysql_clean($_GET['who'])."'"))) { die('No existe '.$who.' que quieres seguir'); }
switch($table) {
	case 'posts':
	list($a) = mysql_fetch_row(mysql_query("SELECT author FROM `posts` WHERE id = '".mysql_clean($_GET['who'])."'"));
	if($a == $currentuser['id']) { die('No puedes seguir tus propios post'); }
	break;
	case 'users':
	if($_GET['who'] == $currentuser['id']) { die('No puedes seguirte a ti mismo'); }
	break;
	case 'group_posts':
	list($a) = mysql_fetch_row(mysql_query("SELECT author FROM `group_posts` WHERE id = '".mysql_clean($_GET['who'])."'"));
	if($a == $currentuser['id']) { die('No puedes seguir tus propios temas'); }
	break;
}
if($_GET['follow'] == '1') {
	if(mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE user = '".$currentuser['id']."' && what = '".mysql_clean($_GET['what'])."' && who = '".mysql_clean($_GET['who'])."'"))) { die('Ya est&aacute;s siguiendo '.(substr($who, 0, 1) == 'e' ? 'ese' : 'esa').substr($who, 2)); }
	mysql_query("INSERT INTO `follows` (user, who, what, time) VALUES ('".$currentuser['id']."', '".mysql_clean($_GET['who'])."', '".mysql_clean($_GET['what'])."', '".time()."')");
	if($_GET['what'] == '2') {
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who) VALUES ('".mysql_clean($_GET['who'])."', 'te est&aacute; siguiendo', '/perfil/".$currentuser['nick']."/', 'sprite-follow', '".time()."', '".$currentuser['id']."')");
	}
	die('1');
} else {
	if(!mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE user = '".$currentuser['id']."' && what = '".mysql_clean($_GET['what'])."' && who = '".mysql_clean($_GET['who'])."'"))) { die('No est&aacute;s siguiendo '.(substr($who, 0, 1) == 'e' ? 'ese' : 'esa').substr($who, 2)); }
	mysql_query("DELETE FROM `follows` WHERE user = '".$currentuser['id']."' && what = '".mysql_clean($_GET['what'])."' && who = '".mysql_clean($_GET['who'])."'");
	die('1');
}
?>