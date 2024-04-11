<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No estas logeado'); }
if(!mysql_num_rows($query = mysql_query("SELECT id, post, author FROM `comments` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('El comentario no existe'); }
$comment = mysql_fetch_array($query);
$post = mysql_fetch_array(mysql_query("SELECT id, author, title, cat FROM `posts` WHERE id = '".$comment['post']."'"));
list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
if($post['author'] != $currentuser['id'] && !isAllowedTo('deletecomments')) { die('No tienes permisos para borrar este comentario'); }
if(mysql_num_rows($q = mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$post['id']."/.*\.html' && medal = '10'"))) {
	$qp = mysql_query("SELECT post, COUNT(*) AS c FROM `comments` WHERE post != '".$post['id']."' GROUP BY post ORDER BY c DESC LIMIT 1");
	list($nm, $c) = mysql_fetch_row($qp);
	if($c > mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE post = '".$post['id']."'"))) {
		$m = mysql_fetch_assoc($q);
		mysql_query("UPDATE `medals` SET medal = '16', time = '".time()."' WHERE id = '".$m['id']."'");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$post['author']."', '&Iexcl;Perdiste un <a href=\"/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">post</a> historico!', '/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title']))."/', 'medalla-platino', '".time()."', 0)");
		$npost = mysql_fetch_assoc(mysql_query("SELECT id, cat, title, author FROM `posts` WHERE id = '".$nm."'"));
		list($nick) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$npost['author']."'"));
		list($ncat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$npost['id']."'"));
		if(mysql_num_rows($q = mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$nm."/.*\.html' && medal = '16'"))) {
			$m = mysql_fetch_assoc($q);
			mysql_query("UPDATE `medals` SET medal = '10', time = '".time()."' WHERE id = '".$m['id']."'");
			mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$npost['author']."', '&Iexcl;Tienes un <a href=\"/posts/".$ncat."/".$npost['id']."/".mysql_clean(url($npost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($npost['title']))."\">post</a> historico!', '/posts/".$ncat."/".$npost['id']."/".mysql_clean(url($npost['title']))."/', 'medalla-diamante', '".time()."', 0)");
		} else {
			mysql_query("INSERT INTO `medals` (user, medal, link, link_title, time) VALUES ('".$npost['author']."', '10', '/posts/".$ncat."/".$npost['id']."/".mysql_clean(url($npost['title'])).".html', '".mysql_clean($npost['title'])."', '".time()."')");
			mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$npost['author']."', 'Recibiste una nueva <a href=\"/perfil/".$nick."/medallas/\" title=\"".$medal['name']."\">medalla</a>', '/perfil/".$nick."/medallas/', '".$medal['type']."', '".time()."', 0)");
		}
	}
}
mysql_query("DELETE FROM `notifications` WHERE link REGEXP '/posts/.+/[0-9]+\.".$comment['id']."/.+\.html#c".$comment['id']."'");
mysql_query("DELETE FROM `comment_complaints` WHERE comment = '".mysql_clean($_GET['id'])."'");
mysql_query("DELETE FROM `comment_votes` WHERE comment = '".mysql_clean($_GET['id'])."'");
mysql_query("DELETE FROM `comments` WHERE id = '".mysql_clean($_GET['id'])."'");
die('1');
?>