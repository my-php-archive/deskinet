<?php
if(!$_GET['id']) { die; }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
if(mysql_num_rows(mysql_query("SELECT * FROM `favorites` WHERE post = '".mysql_clean($_GET['id'])."' && user = '".$currentuser['id']."'"))) { die('Este post ya es tu favorito'); }
if(!mysql_num_rows($q = mysql_query("SELECT id, cat, title, author FROM `posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('El post no existe'); }
mysql_query("INSERT INTO `favorites` (user, post, time) VALUES ('".$currentuser['id']."','".mysql_clean($_GET['id'])."','".time()."')") or die(mysql_error());
list($pid, $cat, $title, $id) = mysql_fetch_row($q);
list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$cat."'"));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$favs = mysql_num_rows(mysql_query("SELECT id FROM `favorites` WHERE post = '".$pid."'"));
$q = mysql_query("SELECT COUNT(*) AS c, post FROM `favorites` WHERE post != '".$pid."' GROUP BY post ORDER BY c DESC LIMIT 1");
list($f, $tpost) = mysql_fetch_row($q);
if($f > $favs && mysql_num_rows(mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$pid."/.*\.html' && medal = '12'"))) {
	mysql_query("UPDATE `medals` SET medal = '24', time = '".time()."' WHERE medal = '12'");
	mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$id."', '&iexcl;Perdiste un <a href=\"/posts/".$cat."/".$pid."/".mysql_clean(url($title)).".html\" title=\"".mysql_clean(htmlspecialchars($title))."\">post</a> historico!', '/posts/".$cat."/".$pid."/".mysql_clean(url($title))."/', 'medalla-platino', '".time()."', 0)");
	$tpost = mysql_fetch_assoc(mysql_query("SELECT id, title, cat, author FROM `posts` WHERE id = '".$tpost."'"));
	$tcat = mysql_fetch_row(mysql_query("SELECT urlname FROM `posts` WHERE id = '".$tpost['cat']."'"));
	$nick = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$tpost['author']."'"));
	if(mysql_num_rows($q = mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$pid."/.*\.html' && medal = '24'"))) {
		$m = mysql_fetch_assoc($q);
		mysql_query("UPDATE `medals` SET medal = '12', time = '".time()."' WHERE id = '".$m['id']."'");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$tpost['author']."', '&iexcl;Tienes un <a href=\"/posts/".$tcat."/".$tpost['id']."/".mysql_clean(url($tpost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($tpost['title']))."\">post</a> historico!', '/posts/".$cat."/".$tpost['id']."/".mysql_clean(url($tpost['title']))."/', 'medalla-diamante', '".time()."', 0)");
	} else {
		mysql_query("INSERT INTO `medals` (user, medal, link, link_title, time) VALUES ('".$id."', '12', '/posts/".$cat."/".$pid."/".mysql_clean(url($title)).".html', '".mysql_clean($title)."', '".time()."')");
		$medal = mysql_fetch_assoc(mysql_query("SELECT name, type FROM `medals_data` WHERE id = '12'"));
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$tpost['author']."', 'Recibiste una nueva <a href=\"/perfil/".$nick."/medallas/\" title=\"".$medal['name']."\">medalla</a>', '/perfil/".$nick."/medallas/', '".$medal['type']."', '".time()."', 0)");
	}
} elseif($f < $favs && !mysql_num_rows($q=mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$pid."/.*\.html' && medal = '24'"))) {
	list($m) = mysql_fetch_row($q);
	mysql_query("UPDATE `medals` SET medal = '12', time = '".time()."' WHERE id = '".$m."'");
	mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$tpost['author']."', '&iexcl;Tienes un <a href=\"/posts/".$tcat."/".$tpost['id']."/".mysql_clean(url($tpost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($tpost['title']))."\">post</a> historico!', '/posts/".$cat."/".$tpost['id']."/".mysql_clean(url($tpost['title']))."/', 'medalla-diamante', '".time()."', 0)");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who) VALUES ('".$id."', 'agreg&oacute; tu <a href=\"/posts/".$cat."/".$pid."/".mysql_clean(url($title)).".html\" title=\"".mysql_clean(htmlspecialchars($title))."\">post</a> a favoritos', '/posts/".$cat."/".$pid."/".mysql_clean(url($title)).".html', 'sprite-star', '".time()."', '".$currentuser['id']."')");
echo 1;
?>