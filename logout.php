<?php
include('config.php');
include('functions.php');
if(!$_COOKIE[$config['cookie_name']]) { die; }
setcookie($config['cookie_name'], 'false', time()+1, '/');
if(mysql_num_rows($q = mysql_query("SELECT id FROM `connected` WHERE ip = '".mysql_clean($_SERVER['REMOTE_ADDR'])."'"))) {
	$f = mysql_fetch_array($q);
	mysql_query("UPDATE `connected` SET user = '0' WHERE id = '".$f['id']."'");
}
header('Location: /index.php');
?>