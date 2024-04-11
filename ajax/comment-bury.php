<?php
if(!$_GET['_'] || !$_GET['id'] || !is_numeric($_GET['_']) || !is_numeric($_GET['id'])) { die('Error de usuario'); }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('Debes logearte'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('No existe el comentario'); }
if(mysql_num_rows(mysql_query("SELECT id FROM `comment_complaints` WHERE comment = '".mysql_clean($_GET['id'])."' && user = '".$currentuser['id']."'"))) { die('Ya has denunciado este comentario'); }
list($id, $pid, $title, $cid, $cat, $author) = mysql_fetch_row(mysql_query("SELECT u.id, p.id, p.title, c.id, k.urlname, p.author FROM users AS u, comments AS c, posts AS p, categories AS k WHERE c.id = '".mysql_clean($_GET['id'])."' && u.id = c.author && p.id = c.post && k.id = p.cat"));
if($id == $currentuser['id']) { die('No puedes denunciar tu propio comentario'); }
mysql_query("INSERT INTO `comment_complaints` (user, comment, time) VALUES ('".$currentuser['id']."', '".mysql_clean($_GET['id'])."', '".time()."')");
$complaints = mysql_num_rows(mysql_query("SELECT id FROM `comment_complaints` WHERE comment = '".mysql_clean($_GET['id'])."'"));
if($complaints == 3) {
	mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$author."', '0', 'Problemas en el paraiso', 'Han denunciado 3 o más veces un comentario en uno de tus [url=http://turingax.net/posts/".$cat."/".$pid."/".mysql_clean(url($title)).".html]posts[/url], por favor visita [url=http://turingax.net/posts/".$cat."/".$pid.".".$cid."/".mysql_clean(url($title)).".html#c".$cid."]el comentario[/url] y decide que debes hacer.\n\nGracias!', '".time()."')");
}
die('La denuncia se ha enviado');
?>