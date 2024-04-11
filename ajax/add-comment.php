<?php
if(!$_POST['id'] || !$_POST['message']) { die('ERROR PROVOCADO POR EL USUARIO'); }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('Logeate'); }
//$_POST['message'] = urldecode($_POST['message']);
$query = mysql_query("SELECT id, author, comments, cat, title FROM `posts` WHERE id = '".mysql_clean($_POST['id'])."'");
if(!mysql_num_rows($query)) { die('error'); }
$post = mysql_fetch_array($query);
$author = mysql_fetch_array(mysql_query("SELECT rank FROM `users` WHERE id = '".$post['author']."'"));
if($post['comments'] == '0') { die('Los comentarios estan desactivados'); }
if($currentuser['rank'] == 0 && $author['rank'] > 0) { die('No puedes comentar porque eres novato'); }
$author['blocked_array'] = (empty($author['blocked']) ? array() : explode(',', $author['blocked']));
if(in_array($currentuser['id'], $author['blocked_array'])) { die('No puedes comentar porque has sido bloqueado por el autor del tema'); }
if(mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE author = '".$currentuser['id']."' && ((post != '".$post['id']."' && time > '".(time()-15)."') || (post = '".$post['id']."' && time > '".(time()-30)."'))"))) { die('Debes esperar antes de publicar otro comentario!'); }
$code = 'DEFCODE';
while(eregi($code, $_POST['message']) || $code == 'DEFCODE') {
	$array = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
	$count = count($array)-1;
	$code = '';
	for($i=1;$i<=5;$i++) {
		$code .= $array[mt_rand(0, $count)];
	}
}
mysql_query("INSERT INTO `comments` (post, author, message, separator_str, time) VALUES ('".$post['id']."','".$currentuser['id']."','".mysql_clean($_POST['message'])."','".$code."','".time()."')");
$commentid = mysql_insert_id();
list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////medal
/*
$comments = mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE post = '".$post['id']."'"));
$c = mysql_num_rows($q = mysql_query("SELECT post FROM `comments` WHERE post != '".$post['id']."' ORDER BY COUNT(*) DESC LIMIT 1"));
list($tpost) = mysql_fetch_row($q);
*/
#if($c < $comments && !mysql_num_rows(mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$post['id']."/.*\.html' && medal = '10'"))) {
/*
	$tpost = mysql_fetch_assoc(mysql_query("SELECT id, title, cat, author FROM `posts` WHERE id = '".$tpost."'"));
	$tcat = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$tpost['cat']."'"));
	mysql_query("UPDATE `medals` SET medal = '16', time = '".time()."' WHERE medal = '10'");
	mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$tpost['author']."', '&iexcl;Perdiste un <a href=\"/posts/".$tcat."/".$tpost['id']."/".mysql_clean(url($tpost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($tpost['title']))."\">post</a> historico!', '/posts/".$tcat."/".$tpost['id']."/".mysql_clean(url($tpost['title']))."/', 'medalla-platino', '".time()."', 0)");
	*/
	#if(mysql_num_rows($q = mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$post['id']."/.*\.html' && medal = '16'"))) {
	/*
		$m = mysql_fetch_assoc($q);
		mysql_query("UPDATE `medals` SET medal = '10', time = '".time()."' WHERE id = '".$m['id']."'");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$post['author']."', '&iexcl;Tienes un <a href=\"/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">post</a> historico!', '/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title']))."/', 'medalla-diamante', '".time()."', 0)");
	} else {
		list($nick) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$post['author']."'"));
		mysql_query("INSERT INTO `medals` (user, medal, link, link_title, time) VALUES ('".$post['author']."', '10', '/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html', '".mysql_clean(htmlspecialchars($post['title']))."', '".time()."')") or die(mysql_error());
		$medal = mysql_fetch_assoc(mysql_query("SELECT name, type FROM `medals_data` WHERE id = '11'"));
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$post['author']."', 'Recibiste una nueva <a href=\"/perfil/".$nick."/medallas/\" title=\"".$medal['name']."\">medalla</a> por un <a href=\"/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">post</a>', '/posts/".$cat."/".$post['id']."/".mysql_clean(url($post['title'])).".html', '".$medal['type']."', '".time()."', 0)");
	}
}
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////medal
$query = mysql_query("SELECT user FROM `follows` WHERE what = '1' && who = '".$post['id']."' && user != '".$currentuser['id']."'");
if($currentuser['id'] != $post['author']) {
	if(!mysql_num_rows($q = mysql_query("SELECT id, `text`, who FROM `notifications` WHERE readed = '0' && user = '".$post['author']."' && link REGEXP '/posts/.*/".$post['id']."/.*\.html'"))) {
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who) VALUES ('".$post['author']."', 'coment&oacute; en un <a href=\"/posts/".$cat."/".$post['id'].".".$commentid."/".mysql_clean(url($post['title'])).".html#c".$commentid."\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">post</a> tuyo', '/posts/".$cat."/".$post['id'].".".$commentid."/".url($post['title']).".html#c".$commentid."', 'new-comment', '".time()."', '".$currentuser['id']."')") or die(mysql_error());
	} else {
		$f = mysql_fetch_assoc($q);
		if(substr($f['text'], 0, 1) == '<') {
			$f['text'] = substr($f['text'], 8);
			$p = strpos($f['text'], ' ');
			$text = '<strong>'.(substr($f['text'], 0, $p)+1).substr($f['text'], $p);
			$p = strpos($post['who'], ' ');
			$who = (substr($f['who'], 0, $p)+1).substr($f['who'], $p);
		} else {
			$ex = explode('en un', $f['text']);
            $text = '<strong>2 nuevos</strong> comentarios en un'.$ex[1];
            $who = '2 nuevos comentarios';
		}
		mysql_query("UPDATE `notifications` SET `text` = '".$text."', who = '".$who."', time = '".time()."', displayuser = '0' WHERE id = '".$f['id']."'");
}
}
while(list($id) = mysql_fetch_row($query)) {
	if(!mysql_num_rows($q = mysql_query("SELECT id, `text`, who FROM `notifications` WHERE readed = '0' && user = '".$id."' && link REGEXP '/posts/.*/".$post['id'].".[0-9]+/.*\.html#c[0-9]+'"))) {
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who) VALUES ('".$id."', 'coment&oacute; en un <a href=\"/posts/".$cat."/".$post['id'].".".$commentid."/".url($post['title']).".html#c".$commentid."\" title=\"".htmlspecialchars($post['title'])."\">post</a> que sigues', '/posts/".$cat."/".$post['id'].".".$commentid."/".url($post['title']).".html#c".$commentid."', 'sprite-balloon-left-blue', '".time()."', '".$currentuser['id']."')");
	} else {
		$f = mysql_fetch_assoc($q);
		if(substr($f['text'], 0, 1) == '<') {
			$f['text'] = substr($f['text'], 8);
			$p = strpos($f['text'], ' ');
			$text = '<strong>'.(substr($f['text'], 0, $p)+1).substr($f['text'], $p);
			$p = strpos($post['who'], ' ');
			$who = (substr($f['who'], 0, $p)+1).substr($f['who'], $p);
		} else {
			//$text = '<strong>2 nuevos</strong> comentarios en un <a href="/posts/'.$cat.'/'.$post['id'].'.'.$commentid.'/'.url($post['title']).'.html#c'.$commentid.'" title="'.htmlspecialchars($post['title']).'">post</a> que sigues';
            $ex = explode('en un', $f['text']);
            $text = '<strong>2 nuevos</strong> comentarios en un'.$ex[1];
            $who = '2 nuevos comentarios';
		}
		mysql_query("UPDATE `notifications` SET `text` = '".$text."', who = '".$who."', time = '".time()."', displayuser = '0' WHERE id = '".$f['id']."'");
	}
}
echo '1';
?>