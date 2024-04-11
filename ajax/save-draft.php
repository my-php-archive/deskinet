<?php
if(!$_POST['title'] || !$_POST['message'] || !$_POST['tags'] || !$_POST['cat']) { die('.Faltan datos'); }
//die(print_r($_POST, true));
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('.No est&aacute;s logeado'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `categories` WHERE id = '".mysql_clean($_POST['cat'])."'"))) { die('.La categoria no existe'); }
$time = time();
if($_POST['id']) {
  if(!mysql_num_rows($q = mysql_query("SELECT user FROM `drafts` WHERE id = '".mysql_clean($_POST['id'])."'"))) { die('.No existe el borrador'); }
  $d = mysql_fetch_row($q);
  if($d[0] != $currentuser['id']) { die('.No es tu borrador!'); }
  mysql_query("UPDATE `drafts` SET title = '".mysql_clean($_POST['title'])."', cat = '".mysql_clean($_POST['cat'])."', content = '".mysql_clean($_POST['message'])."', tags = '".mysql_clean($_POST['tags'])."', stick = '".($_POST['sticky'] && isAllowedTo('stick') ? '1' : '0')."', superstick = '".($_POST['ssticky'] && isAllowedTo('superstick') ? '1' : '0')."', comments = '".($_POST['comments'] && $currentuser['rank'] != '0' ? '0' : '1')."', private = '".($_POST['private'] && $currentuser['rank'] != '0' ? '1' : '0')."', time = '".$time."' WHERE id = '".mysql_clean($_POST['id'])."'");
} else {
  mysql_query("INSERT INTO `drafts` (user, type, title, cat, content, tags, stick, superstick, comments, private, time) VALUES ('".$currentuser['id']."', '1', '".mysql_clean($_POST['title'])."', '".mysql_clean($_POST['cat'])."', '".mysql_clean($_POST['message'])."', '".mysql_clean($_POST['tags'])."', '".($_POST['sticky'] && isAllowedTo('stick') ? '1' : '0')."', '".($_POST['ssticky'] && isAllowedTo('superstick') ? '1' : '0')."', '".($_POST['comments'] && $currentuser['rank'] != '0' ? '0' : '1')."', '".($_POST['private'] && $currentuser['rank'] != '0' ? '1' : '0')."', '".$time."')");
}
die(($_POST['id'] ? $_POST['id'] : mysql_insert_id()).'.Guardado a las '.date('H:i:s', $time));
?>