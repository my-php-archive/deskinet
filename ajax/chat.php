<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
if($_GET['action'] == 'send') {
	if(!$_GET['m']) { die('Env&iacute;a un mensaje'); }
	mysql_query("INSERT INTO `chat` (author, message, time) VALUES ('".$currentuser['id']."', '".mysql_clean($_GET['m'])."', '".time()."')");
	die('1');
}