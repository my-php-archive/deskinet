<?php
if(!$_GET['_'] || !$_GET['p']) { die('Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
if(!mysql_num_rows($q = mysql_query("SELECT id, title, cat FROM `posts` WHERE id = '".mysql_clean($_GET['p'])."'"))) { die('No existe el post que quieres recomendar'); }
list($pid, $title, $cat) = mysql_fetch_row($q);
list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$cat."'"));
if(!mysql_num_rows($q = mysql_query("SELECT user FROM `follows` WHERE what = '2' && who = '".$currentuser['id']."'"))) { die('No tienes seguidores, tal vez <a href="/agregar/">aqu&iacute;</a> consigas alguno.'); }
while(list($id) = mysql_fetch_row($q)) {
	mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who, what, `where`) VALUES ('".$id."', 'te recomienda este <a href=\"/posts/".$cat."/".$pid."/".url($title).".html\" title=\"".htmlspecialchars($title)."\">post</a>', '/posts/".$cat."/".$pid."/".url($title).".html', 'sprite-recomendar-p', '".time()."', '".$currentuser['id']."', '1', '".$pid."')");
}
die('1');
?>