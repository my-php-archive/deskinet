<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('Logeate'); }
if(!$_GET['sa'] || ($_GET['sa'] != 'check' && $_GET['sa'] != 'subcat')) { die('Datos incorrectos'); }
if($_GET['sa'] == 'check') {
	if(!$_GET['name']) { die('Faltan datos'); }
	if(strlen($_GET['name']) < 5 || strlen($_GET['name']) > 32) { die('El nombre debe tener entre 5 y 32 caracteres'); }
	if(!preg_match('/^[a-z0-9]+$/i', $_GET['name'])) { die('El nombre solo admite letras y n&uacute;meros'); }
	if($_GET['name'] == 'crear' || $_GET['name'] == 'top' || $_GET['name'] == 'cat') { die('El nombre no es v&aacute;lido'); }
	if(mysql_num_rows(mysql_query("SELECT * FROM `groups` WHERE urlname = '".mysql_clean($_GET['name'])."'"))) {
		die('El nombre seleccionado ya est&aacute; en uso');
	} else {
		die('1');
	}
} elseif($_GET['sa'] == 'subcat') {
	if(!$_GET['id']) { die('0Faltan datos'); }
	if(!mysql_num_rows(mysql_query("SELECT id FROM `group_categories` WHERE id = '".mysql_clean($_GET['id'])."' && sub = '0'"))) { die('0No existe la categor&iacute;a'); }
	$query = mysql_query("SELECT id, name FROM `group_categories` WHERE sub = '".mysql_clean($_GET['id'])."' ORDER BY name ASC");
	while($cat = mysql_fetch_array($query)) {
		$echo .= ','.$cat['name'].':'.$cat['id'];
	}
	die(substr($echo, 1));
}
?>