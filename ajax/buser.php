<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No estas logeado'); }
if(!$_GET['sa'] || !$_GET['id']) { die('Faltan datos'); }
if($_GET['sa'] != '1' && $_GET['sa'] != '2') { die('Datos incorrectos'); }
if(!mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('El usuario no existe'); }
$currentuser['blocked_array'] = (empty($currentuser['blocked']) ? array() : explode(',', $currentuser['blocked']));
if($_GET['sa'] == '1') {
	if(in_array($_GET['id'], $currentuser['blocked_array'])) { die('El usuario ya est&aacute; bloqueado'); }
	$currentuser['blocked_array'][] = mysql_clean($_GET['id']);
	mysql_query("UPDATE `users` SET blocked = '".implode(',', $currentuser['blocked_array'])."' WHERE id = '".$currentuser['id']."'");
	die('1');
} else {
	if(!in_array($_GET['id'], $currentuser['blocked_array'])) { die('El usuario no est&aacute; bloqueado'); }
	$c = count($currentuser['blocked_array']);
	for($i=0;$i<$c;$i++) {
		if($currentuser['blocked_array'][$i] == $_GET['id']) {
			unset($currentuser['blocked_array'][$i]);
			break;
		}
	}
	mysql_query("UPDATE `users` SET blocked = '".implode(',', $currentuser['blocked_array'])."' WHERE id = '".$currentuser['id']."'");
	die('1');
}
?>