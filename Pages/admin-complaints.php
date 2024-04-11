<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('0Logeate'); }
if(!isAllowedTo('complaints')) { die('0A donde vas...'); }
if(!$_GET['sa'] || !$_GET['id']) { die('0Faltan datos'); }
if($_GET['sa'] != 'delete' && $_GET['sa'] != 'accept' && $_GET['sa'] != 'reject') { die('0Datos incorrectos'); }

if($_GET['sa'] == 'delete') {
	if(!$_GET['post']) { die('0Faltan datos'); }
	if(!mysql_num_rows($com = mysql_query("SELECT user FROM `complaints` WHERE id = '".mysql_clean($_GET['id'])."' && post = '".mysql_clean($_GET['post'])."'"))) { die('0No existe la denuncia.'); }
	mysql_query("DELETE FROM `complaints` WHERE id = '".mysql_clean($_GET['id'])."'") or die('01'.mysql_error());
	if(mysql_num_rows(mysql_query("SELECT * FROM `complaints` WHERE post = '".mysql_clean($_GET['post'])."'")) == 0) {
		$p = mysql_fetch_array(mysql_query("SELECT title FROM `posts` WHERE id = '".mysql_clean($_GET['post'])."'"));
		mysql_query("UPDATE `posts` SET revision = '0' WHERE id = '".mysql_clean($_GET['post'])."'") or die('02'.mysql_error());
		mysql_query("DELETE FROM `mod-history` WHERE post_id = '".mysql_clean($_GET['post'])."' && action_type = '3' LIMIT 1") or die('03'.mysql_error());
		mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$comp['user']."', '".$currentuser['id']."', 'Denuncia borrada', 'Hemos considerado que tu denuncia en el post ".htmlspecialchars($p['title'])." no es correcta y ha sido borrada, por ello has perdido 5 puntos', '".time()."')") or die('04'.mysql_error());
		mysql_query("INSERT INTO `points` (user_from, user_to, pnum, time) VALUES ('".$currentuser['id']."', '".$comp['user']."', '-5', '".time()."')") or die('05'.mysql_error());
	}
} else {
	if(!mysql_num_rows($p = mysql_query("SELECT id, title, author, tags FROM `posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('0No existe el post'); }
	$post = mysql_fetch_array($p);
	$query = mysql_query("SELECT user FROM `complaints` WHERE post = '".$post['id']."'");
	if($_GET['sa'] == 'accept') {
		// SAcatr razon
		//mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$post['author']."', '".$currentuser['id']."', 'Post borrado', 'Tu post ".$post['title']." ha sido borrado tras ser denunciado por los usuarios.\n\nRazón: '.$LAPUTARAZON.'\n\nGracias por comprenderlo.', '".time()."')");
		while($comp = mysql_fetch_array($query)) {
			mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$comp['user']."', '".$currentuser['id']."', 'Denuncia aceptada', 'Hemos considerado que el post que denunciaste (".htmlspecialchars($post['title']).") debe ser borrado por no cumplir el [url=/protocolo/]protocolo[/url].\n\nPor ayudar a la comunidad, has ganado 3 puntos.', '".time()."')") or die('06'.mysql_error());
			mysql_query("INSERT INTO `points` (user_from, user_to, pnum, time) VALUES ('".$currentuser['id']."', '".$comp['user']."', '3', '".time()."')") or die('07'.mysql_error());
		}
		mysql_query("INSERT INTO `mod-history` (`post_title`, `post_author`, `mod`, `action_type`, `action_reason`, `time`) VALUES ('".$post['title']."','".$post['author']."','0','3', 'Por acumulación de denuncias', '".time()."')") or die(mysql_error());
		mysql_query("DELETE FROM `complaints` WHERE post = '".$post['id']."'");
		mysql_query("DELETE FROM `posts` WHERE id = '".$post['id']."'");
		mysql_query("DELETE FROM `comments` WHERE post = '".$post['id']."'");
		mysql_query("DELETE FROM `visits` WHERE post = '".$post['id']."'");
		mysql_query("DELETE FROM `favorites` WHERE post = '".$post['id']."'");
		$tags = explode(',', mysql_clean($post['tags']));
		foreach($tags as $tag) {
			mysql_query("UPDATE `tags` SET num = num-1 WHERE tag = '".$tag."'");
		}
		mysql_query("DELETE FROM `tags` WHERE num = '0'");
	} else {
		while($comp = mysql_fetch_array($query)) {
			mysql_query("INSERT INTO `pms` (user_to, user_from, title, message, time) VALUES ('".$comp['user']."', '".$currentuser['id']."', 'Denuncia rechazada', 'Hemos considerado que el post que denunciaste (".htmlspecialchars($post['title']).") cumple el [url=/protocolo/]protocolo[/url].\n\nDebido a esto, te retiramos 3 puntos.', '".time()."')") or die('08'.mysql_error());
			mysql_query("INSERT INTO `points` (user_from, user_to, pnum, time) VALUES ('".$currentuser['id']."', '".$comp['user']."', '-3', '".time()."')") or die('09'.mysql_error());
		}
		mysql_query("DELETE FROM `complaints` WHERE post = '".$post['id']."'");
		mysql_query("UPDATE `posts` SET revision = '0' WHERE id = '".$post['id']."'");
	}
}
?>