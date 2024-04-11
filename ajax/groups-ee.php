<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
if(!$_GET['id']) { die('No has seleccionado una comunidad'); }
if(!$_GET['sa'] || ($_GET['sa'] != 'participate' && $_GET['sa'] != 'leave')) { die('Datos incorrectos'); }
if(!mysql_num_rows($g = mysql_query("SELECT default_rank FROM `groups` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('La comunidad no existe'); }
if($_GET['sa'] == 'participate') {
	if(mysql_num_rows(mysql_query("SELECT * FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".mysql_clean($_GET['id'])."'"))) { die('Ya eres miembro de esta comunidad'); }
	$group = mysql_fetch_array($g);
	mysql_query("INSERT INTO `group_members` (user, `group`, rank, time) VALUES ('".$currentuser['id']."', '".mysql_clean($_GET['id'])."', '".$group['default_rank']."', '".time()."')");
	mysql_query("UPDATE `groups` SET members = members+1 WHERE id = '".mysql_clean($_GET['id'])."'");
	die('1');
} else {
	if(!mysql_num_rows($m = mysql_query("SELECT id FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".mysql_clean($_GET['id'])."'"))) { die('No eres miembro de esta comunidad'); }
	$member = mysql_fetch_array($m);
	mysql_query("DELETE FROM `group_members` WHERE id = '".$member['id']."'");
	mysql_query("UPDATE `groups` SET members = members-1 WHERE id = '".mysql_clean($_GET['id'])."'");
	if(!mysql_num_rows(mysql_query("SELECT * FROM `group_members` WHERE `group` = '".mysql_clean($_GET['id'])."'"))) {
		mysql_query("DELETE FROM `groups` WHERE id = '".mysql_clean($_GET['id'])."'");
		mysql_query("DELETE FROM `group_posts` WHERE group = '".mysql_clean($_GET['id'])."'");
		mysql_query("DELETE FROM `group_comments` WHERE group = '".mysql_clean($_GET['id'])."'");
	}
	die('1');
}
?>