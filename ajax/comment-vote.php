<?php
if(!$_GET['_'] || !$_GET['id'] || !$_GET['a'] || !is_numeric($_GET['_']) || !is_numeric($_GET['id']) || ($_GET['a'] != '1' && $_GET['a'] != '-1')) { die('0Error de usuario'); }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('0Debes logearte'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('0No existe el comentario'); }
if(mysql_num_rows(mysql_query("SELECT id FROM `comment_votes` WHERE comment = '".mysql_clean($_GET['id'])."' && user = '".$currentuser['id']."'"))) { die('0Ya has votado este comentario'); }
list($id, $pid, $title, $cid, $cat) = mysql_fetch_row(mysql_query("SELECT u.id, p.id, p.title, c.id, k.urlname FROM users AS u, comments AS c, posts AS p, categories AS k WHERE c.id = '".mysql_clean($_GET['id'])."' && u.id = c.author && p.id = c.post && k.id = p.cat"));
if($id == $currentuser['id']) { die('0No puedes votar tu propio comentario'); }
mysql_query("INSERT INTO `comment_votes` (user, comment, amount, time) VALUES ('".$currentuser['id']."', '".mysql_clean($_GET['id'])."', '".mysql_clean($_GET['a'])."', '".time()."')");
list($votes) = mysql_fetch_row(mysql_query("SELECT SUM(amount) FROM `comment_votes` WHERE comment = '".mysql_clean($_GET['id'])."'"));
if($votes == 15) {
	mysql_query("INSERT INTO `points` (user_to, pnum, time) VALUES ('".$id."', '1', '".time()."')");
	mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who, displayuser) VALUES ('".$id."', 'Ganaste un punto por un <a href=\"/posts/".$cat."/".$pid.".".$cid."/".mysql_clean(url($title)).".html#".$cid."\" title=\"".htmlspecialchars($title)."\">comentario</a>', '/posts/".$cat."/".$pid.".".$cid."/".mysql_clean(url($title)).".html#".$cid."', 'sprite-point', '".time()."', '".$currentuser['id']."', '0')");
} elseif($votes == -20) {
	mysql_query("INSERT INTO `points` (user_to, pnum, time) VALUES ('".$id."', '-1', '".time()."')");
	mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who, displayuser) VALUES ('".$id."', 'Perdiste un punto por un <a href=\"/posts/".$cat."/".$pid.".".$cid."/".mysql_clean(url($title)).".html#c".$cid."\" title=\"".htmlspecialchars($title)."\">comentario</a>', '/posts/".$cat."/".$pid.".".$cid."/".mysql_clean(url($title)).".html#c".$cid."', 'sprite-point', '".time()."', '".$currentuser['id']."', '0')");
}
die($votes);
?>