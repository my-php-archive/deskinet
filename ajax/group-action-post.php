<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
if(!$_GET['id']) { die('No has seleccionado un post para borrar'); }
if(!mysql_num_rows($query = mysql_query("SELECT id, title, `group`, author, sticky, tags FROM `group_posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('No existe el post<br />A lo mejor ya lo han borrado...'); }
$post = mysql_fetch_array($query);
list($gid) = mysql_fetch_row(mysql_query("SELECT id FROM `groups` WHERE id = '".$post['group']."'"));
if($_GET['sa'] == 'delete') {
	if(!isAllowedTo('delete_post_groups') && $post['author'] != $currentuser['id'] && !mysql_num_rows(mysql_query("SELECT id FROM `group_members` WHERE `group` = '".$post['group']."' && user = '".$currentuser['id']."' && rank > 2"))) {
		die('No tienes permisos para borrar este tema');
	}
	if($post['author'] != $currentuser['id'] && !$_GET['r']) {
		die('Introduce una raz&oacute;n para borrar el tema');
	}
	if(!@mysql_query("DELETE FROM `group_posts` WHERE id = '".$post['id']."'")) {
		die('No se pudo borrar el tema<br />&iquest;Se te habr&aacute;n adelantado?');
	}
	mysql_query("UPDATE `groups` SET posts = posts-1 WHERE id = '".$post['group']."'");
	/* tags raros... kitar el * / junto para comentar BIBA! */
	$tags = explode(',', mysql_clean($post['tags']));
	foreach($tags as $tag) {
		mysql_query("UPDATE `groups_tags` SET num = num-1 WHERE tag = '".$tag."'");
	}
	mysql_query("DELETE FROM `groups_tags` WHERE num = '0'");
	/*
	if(mysql_num_rows($q=mysql_query("SELECT id FROM `polls` WHERE post = '".$post['id']."'"))) {
		list($poll) = mysql_fetch_row($q);
		mysql_query("DELETE FROM `polls` WHERE post = '".$poll."'");
		mysql_query("DELETE FROM `poll_votes` WHERE poll = '".$poll."'");
	}*/
	mysql_query("DELETE FROM `group_comments` WHERE post = '".$post['id']."'");
	mysql_query("DELETE FROM `group_points` WHERE post = '".$post['id']."'");
	mysql_query("DELETE FROM `group_visits` WHERE post = '".$post['id']."'");
	mysql_query("DELETE FROM `follows` WHERE what = '4' && who = '".$post['id']."'");
	mysql_query("DELETE FROM `notifications` WHERE link REGEXP '/comunidades/.*/".$post['id']."(\.[0-9]+)?/.*\.html(#[0-9]+)?'");
	/*if($currentuser['id'] != $post['author']) {
		mysql_query("INSERT INTO `mod-history` (`post_title`, `post_author`, `mod`, `action_type`, `action_reason`, `time`) VALUES ('".$post['title']."','".$post['author']."','".$currentuser['id']."','3','".mysql_clean($_GET['r'])."','".time()."')") or die(mysql_error());
		mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$post['author']."', '".$currentuser['id']."', 'Post borrado', 'Lamentamos comunicarte que tu post \"[b]".mysql_clean($post['title'])."[/b]\" ha sido borrado por:\n\n".utf8_encode(mysql_clean($_GET['r']))."\n\nPara ver el protocolo, visita [url=/protocolo/]este enlace[/url]\n\nGracias por entender!', '".time()."')") or die(mysql_error());
	}*/
	die('1');
} elseif($_GET['sa'] == 'stick') {
	if(!$_GET['ft'] || ($_GET['ft'] != '1' && $_GET['ft'] != '2')) {
		die('&iquest;Quieres fijar o desfijar?');
	}
	if(($_GET['ft'] == '1' && $post['sticky'] == '1') || ($_GET['ft'] == '2' && $post['sticky'] == '0')) {
		die('El tema '.($_GET['ft'] == '1' ? 'ya' : 'no').' est&aacute; fijado');
	}
	$fod = ($_GET['ft'] == '1' ? 'fijar' : 'desfijar');
	if(!isAllowedTo('stick_post_groups') && !mysql_num_rows(mysql_query("SELECT id FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".$gid."' && rank > '2'"))) {
		die('No tienes permisos para '.$fod.' este post');
	}
	if(!@mysql_query("UPDATE `group_posts` SET sticky = '".($_GET['ft'] == '1' ? time() : '0')."' WHERE id = '".$post['id']."'")) {
		die('No se pudo '.$fod.' el post');
	}
	// HISTORIAL COMUS
	die('1');
} else { die(':/'); }
?>