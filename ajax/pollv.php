<?php
include('../config.php');
include('../functions.php');
if(!isLogged() || !$_GET['_'] || !$_GET['p'] || !$_GET['o']) { die; }
if(!mysql_num_rows($q = mysql_query("SELECT id, `group`, options FROM `polls` WHERE id = '".mysql_clean($_GET['p'])."'"))) { die('La encuesta no existe');}
$poll = mysql_fetch_assoc($q);
if(!mysql_num_rows(mysql_query("SELECT id FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".$poll['group']."' && rank > '0'"))) { die('No perteneces a la comunidad o no tienes rango suficiente para votar'); }
if(mysql_num_rows(mysql_query("SELECT id FROM `poll_votes` WHERE poll = '".$poll['id']."' && user = '".$currentuser['id']."'"))) { die('Ya has votado en esta encuesta'); }
if(!preg_match('/.*\^?'.$_GET['o'].'\*.*/', $poll['options'])) { die('No existe la opci&oacute;n que quieres votar'); }
mysql_query("INSERT INTO `poll_votes` (user, poll, `option`, time) VALUES ('".$currentuser['id']."', '".$poll['id']."', '".mysql_clean($_GET['o'])."', '".time()."')");
die('1');
?>