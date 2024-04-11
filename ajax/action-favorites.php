<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
$_GET['action'] = (int) $_GET['action'];
if(!$_GET['id'] || !$_GET['post'] || !$_GET['time'] || !$_GET['action'] || ($_GET['action'] != 1 && $_GET['action'] != 2) || !eregi('^[0-9]+$', $_GET['time'])) { die('ERROR PROVOCADO POR EL USUARIO'); }
if($_GET['action'] == 1) {
	if(!mysql_num_rows(mysql_query("SELECT * FROM `favorites` WHERE id = '".mysql_clean($_GET['id'])."' && post = '".mysql_clean($_GET['post'])."' && time = '".$_GET['time']."' && user = '".$currentuser['id']."'"))) { die('No existe el favorito, alg&uacute;n dato es incorrecto o no es tu favorito'); }
	mysql_query("DELETE FROM `favorites` WHERE id = '".mysql_clean($_GET['id'])."'") or die(mysql_error());
	die('1');
} else {
	if(mysql_num_rows(mysql_query("SELECT * FROM `favorites` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('ID incorrecta'); }
	if(!mysql_num_rows(mysql_query("SELECT * FROM `posts` WHERE id = '".mysql_clean($_GET['post'])."'"))) { die('El post no existe'); }
	if(!eregi('^[0-9]+$', $_GET['time'])) { die('El valor para time debe ser un n\xfamero'); }
	if(time() < $_GET['time']) { die('Todavia no estamos a '.date('d/m/Y', $_GET['time']).'...'); }
	mysql_query("INSERT INTO `favorites` (id, user, post, time) VALUES ('".mysql_clean($_GET['id'])."','".$currentuser['id']."','".mysql_clean($_GET['post'])."','".mysql_clean($_GET['time'])."')");
	die('1');
}