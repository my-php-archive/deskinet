<?php
if(!$_POST['id'] || !$_POST['message']) { die('ERROR PROVOCADO POR EL USUARIO'); }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('Logeate'); }
//$_POST['message'] = urldecode($_POST['message']);
$query = mysql_query("SELECT id, author, comments, title, `group` FROM `group_posts` WHERE id = '".mysql_clean($_POST['id'])."' && `group` = '".mysql_clean($_POST['group'])."'") or die(mysql_error());
if(!mysql_num_rows($query)) { die('error'); }
$post = mysql_fetch_array($query);
list($group) = mysql_fetch_row(mysql_query("SELECT urlname FROM `groups` WHERE id = '".$post['group']."'"));
if(!mysql_num_rows(mysql_query("SELECT * FROM `group_members` WHERE `group` = '".mysql_clean($_POST['group'])."' && user = '".$currentuser['id']."' && rank > '0'"))) { die('No perteneces al grupo o no eres comentador'); }
if($post['comments'] == '0') { die('Los comentarios estan desactivados'); }
$author['blocked_array'] = (empty($author['blocked']) ? array() : explode(',', $author['blocked']));
if(in_array($currentuser['id'], $author['blocked_array'])) { die('No puedes comentar porque has sido bloqueado por el autor del tema'); }
if(mysql_num_rows(mysql_query("SELECT id FROM `group_comments` WHERE author = '".$currentuser['id']."' && ((post != '".$post['id']."' && -time > '".(time()-10)."') || (post = '".$post['id']."' && time > '".(time()-30)."'))"))) { die('Debes esperar antes de publicar otro comentario!'); }
mysql_query("INSERT INTO `group_comments` (post, `group`, author, message, time) VALUES ('".mysql_clean($_POST['id'])."','".mysql_clean($_POST['group'])."','".$currentuser['id']."','".mysql_clean($_POST['message'])."','".time()."')") or die(mysql_error());
$commentid = mysql_insert_id();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////medal
$query = mysql_query("SELECT user FROM `follows` WHERE what = '4' && who = '".$post['id']."' && user != '".$currentuser['id']."'");
if($currentuser['id'] != $post['author']) {
	if(!mysql_num_rows($q = mysql_query("SELECT id, `text`, who FROM `notifications` WHERE readed = '0' && user = '".$post['author']."' && link REGEXP '/posts/.*/".$post['id']."/.*\.html' && img = 'new-comment'"))) {
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who) VALUES ('".$post['author']."', 'respondi&oacute; en un <a href=\"/comunidades/".$group."/".$post['id'].".".$commentid."/".url($post['title']).".html#c".$commentid."\" title=\"".mysql_clean(htmlspecialchars($post['title']))."\">tema</a> tuyo', '/comunidades/".$group."/".$post['id'].".".$commentid."/".url($post['title']).".html#c".$commentid."', 'sprite-balloon-left-green', '".time()."', '".$currentuser['id']."')") or die(mysql_error());
	} else {
		$f = mysql_fetch_assoc($q);
		if(substr($post['text'], 0, 1) == '<') {
			$post['text'] = substr($post['text'], 8);
			$p = strpos($post['text'], ' ');
			$text = '<strong>'.(substr($post['text'], 0, $p)+1).substr($post['text'], $p);
			$p = strpos($post['who'], ' ');
			$who = (substr($post['who'], 0, $p)+1).substr($post['who'], $p);
		} else {
			$text = '<strong>2 nuevas</strong> respuestas en un <a href="/comunidades/'.$group.'/'.$post['id'].'.'.$commentid.'/'.url($post['title']).'.html#c'.$commentid.'" title="'.htmlspecialchars($post['title']).'">tema</a> tuyo';
			$who = '2 nuevas respuestas';
		}
		mysql_query("UPDATE `notifications` SET `text` = '".$text."', who = '".$who."', time = '".time()."', displayuser = '0' WHERE id = '".$f['id']."'");
}
}
while(list($id) = mysql_fetch_row($query)) {
	if(!mysql_num_rows($q = mysql_query("SELECT id, `text`, who FROM `notifications` WHERE readed = '0' && user = '".$id."' && link REGEXP '/posts/.*/".$post['id']."/.*\.html' && img = 'sprite-balloon-left-blue'"))) {
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who) VALUES ('".$id."', 'respondi&oacute; en un <a href=\"/comunidades/".$group."/".$post['id'].".".$commentid."/".url($post['title']).".html#c".$commentid."\" title=\"".htmlspecialchars($post['title'])."\">tema</a> que sigues', '/comunidades/".$group."/".$post['id'].".".$commentid."/".url($post['title']).".html#c".$commentid."', 'sprite-balloon-left-green', '".time()."', '".$currentuser['id']."')");
	} else {
		$f = mysql_fetch_assoc($q);
		if(substr($post['text'], 0, 1) == '<') {
			$post['text'] = substr($post['text'], 8);
			$p = strpos($post['text'], ' ');
			$text = '<strong>'.(substr($post['text'], 0, $p)+1).substr($post['text'], $p);
			$p = strpos($post['who'], ' ');
			$who = (substr($post['who'], 0, $p)+1).substr($post['who'], $p);
		} else {
			$text = '<strong>2 nuevas</strong> respuestas en un <a href="/comunidades/'.$group.'/'.$post['id'].'.'.$commentid."/".url($post['title']).'.html#c'.$commentid.'" title="'.htmlspecialchars($post['title']).'">tema</a> que sigues';
			$who = '2 nuevos comentarios';
		}
		mysql_query("UPDATE `notifications` SET `text` = '".$text."', who = '".$who."', time = '".time()."', displayuser = '0' WHERE id = '".$f['id']."'");
	}
}
echo '1';
?>