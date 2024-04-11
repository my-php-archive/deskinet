<?php
include('../config.php');
include('../functions.php');
if(!mysql_num_rows($q = mysql_query("SELECT message, post FROM `comments` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die; }
$c = mysql_fetch_array($q);
if(!isLogged()) {
	$p = mysql_fetch_array(mysql_query("SELECT private FROM `posts` WHERE id = '".$c['post']."'"));
	if($p['private'] == '1') { die; }
}
echo $c['message'];
?>