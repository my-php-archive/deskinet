 <?php
include('../config.php');
include('../functions.php');
if(!isLogged() || !$_GET['p'] || !$_GET['id'] || !ereg('^[0-9]{1,2}$', $_GET['p']) || $_GET['p'] > 10 || $_GET['p'] < 1 || ((int) $currentuser['rank']) == 0) { die('ER:Ha ocurrido un error provocado por el usuario'); }
if(!mysql_num_rows($query = mysql_query("SELECT id, cat, title, author FROM `posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('ER:No existe el post'); }
if(((int) $currentuser['currentpoints']) < $_GET['p']) { die('ER:No tienes puntos suficientes'); }
$f = mysql_fetch_array($query);
if($f['author'] == $currentuser['id']) { die('ER:No puedes puntuar tus propios post'); }
if(mysql_num_rows(mysql_query("SELECT * FROM `points` WHERE user_from = '".$currentuser['id']."' && post = '".mysql_clean($_GET['id'])."'"))) { die('ER:Ya has puntuado este post'); }
mysql_query("INSERT INTO `points` (user_to, user_from, post, pnum, time) VALUES ('".$f['author']."','".$currentuser['id']."','".mysql_clean($_GET['id'])."','".mysql_clean($_GET['p'])."','".time()."')");
mysql_query("UPDATE `users` SET points = '".($currentuser['currentpoints']-$_GET['p'])."-".date('d/m/Y')."' WHERE id = '".$currentuser['id']."'") or die(mysql_error());
list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$f['cat']."'"));

// medallas |
//          V
if(isNew($f['author'])) {
	mysql_query("UPDATE `users` SET nfu = nfu+1 WHERE id = '".$currentuser['id']."'");
	$currentuser['nfu']++;
	if($currentuser['nfu'] == 10 || $currentuser['nfu'] == 100) {
		$medal = mysql_fetch_assoc(mysql_query("SELECT id, name, type FROM `medals_data` WHERE id = '".($currentuser['nfu']==10 ? '4' : '5')."'"));
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$currentuser['id']."', 'Recibiste una nueva <a href=\"/perfil/".$currentuser['nick']."/medallas/\" title=\"".$medal['name']."\">medalla</a>', '/perfil/".$currentuser['nick']."/medallas/', '".$medal['type']."', '".time()."', 0)");
		mysql_query("INSERT INTO `medals` (medal, user, time) VALUES ('".$medal['id']."', '".$currentuser['id']."', '".time()."')");
	}
}
$r = mysql_num_rows(mysql_query("SELECT id FROM `points` WHERE user_from = '".$currentuser['id']."'"));
if($r == 100 || $r == 500 || $r == 1000) {
	$medal = mysql_fetch_assoc(mysql_query("SELECT id, name, type FROM `medals_data` WHERE id = '".($currentuser['nfu'] == 100 ? '1' : ($currentuser['nfu'] == 500 ? '2' : '3'))."'"));
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$currentuser['id']."', 'Recibiste una nueva <a href=\"/perfil/".$currentuser['nick']."/medallas/\" title=\"".$medal['name']."\">medalla</a>', '/perfil/".$currentuser['nick']."/medallas/', '".$medal['type']."', '".time()."', 0)");
		mysql_query("INSERT INTO `medals` (medal, user, time) VALUES ('".$medal['id']."', '".$currentuser['id']."', '".time()."')");
}
/*
//GEGEGEGEGEGEGEGE TOP GEGEGE
list($points) = mysql_fetch_row(mysql_query("SELECT SUM(pnum) FROM `points` WHERE post = '".$f['id']."'"));
$q = mysql_query("SELECT SUM(pnum) AS p, post FROM `points` WHERE post != '".$f['id']."' && post != '0' GROUP BY post ORDER BY p DESC LIMIT 1");
list($p, $tpost) = mysql_fetch_row($q);
*/
#if($p < $points && !mysql_num_rows(mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$f['id']."/.*\.html' && medal = '11'"))) {
/*
	$tpost = mysql_fetch_assoc(mysql_query("SELECT id, title, cat, author FROM `posts` WHERE id = '".$tpost."'"));
	$tcat = mysql_fetch_row(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$tpost['cat']."'"));
	mysql_query("UPDATE `medals` SET medal = '20', time = '".time()."' WHERE medal = '11'");
	mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$tpost['author']."', '&iexcl;Perdiste un <a href=\"/posts/".$tcat."/".$tpost['id']."/".mysql_clean(url($tpost['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($tpost['title']))."\">post</a> historico!', '/posts/".$tcat."/".$tpost['id']."/".mysql_clean(url($tpost['title']))."/', 'medalla-platino', '".time()."', 0)");*/
	#if(mysql_num_rows($q = mysql_query("SELECT id FROM `medals` WHERE link REGEXP '/posts/.*/".$f['id']."/.*\.html' && medal = '20'"))) {
	/*
		$m = mysql_fetch_assoc($q);
		mysql_query("UPDATE `medals` SET medal = '11', time = '".time()."' WHERE id = '".$m['id']."'");
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$f['author']."', '&iexcl;Tienes un <a href=\"/posts/".$cat."/".$f['id']."/".mysql_clean(url($f['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($f['title']))."\">post</a> historico!', '/posts/".$cat."/".$f['id']."/".mysql_clean(url($f['title']))."/', 'medalla-diamante', '".time()."', 0)");
	} else {
		list($nick) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$f['author']."'"));
		mysql_query("INSERT INTO `medals` (user, medal, link, link_title, time) VALUES ('".$f['author']."', '11', '/posts/".$cat."/".$tpost['id']."/".mysql_clean(url($f['title'])).".html', '".mysql_clean(htmlspecialchars($f['title']))."', '".time()."')") or die(mysql_error());
		$medal = mysql_fetch_assoc(mysql_query("SELECT name, type FROM `medals_data` WHERE id = '11'"));
		mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, displayuser) VALUES ('".$f['author']."', 'Recibiste una nueva <a href=\"/perfil/".$nick."/medallas/\" title=\"".$medal['name']."\">medalla</a> por un <a href=\"/posts/".$cat."/".$f['id']."/".mysql_clean(url($f['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($f['title']))."\">post</a>', '/posts/".$cat."/".$f['id']."/".mysql_clean(url($f['title'])).".html', '".$medal['type']."', '".time()."', 0)");
	}
}*/
// medallas ^
//          |
mysql_query("INSERT INTO `notifications` (user, `text`, link, img, time, who, what, `where`) VALUES ('".$f['author']."', 'dej&oacute; ".($_GET['p'] == 1 ? 'un punto' : mysql_clean($_GET['p']).' puntos')." en tu <a href=\"/posts/".$cat."/".$f['id']."/".mysql_clean(url($f['title'])).".html\" title=\"".mysql_clean(htmlspecialchars($f['title']))."\">post</a>', '/posts/".$cat."/".$f['id']."/".mysql_clean(url($f['title'])).".html', 'sprite-point', '".time()."', '".$currentuser['id']."', '1', '".$f['id']."')");
die(trim('OK:Los puntos se han a&ntilde;adido correctamente'));
?>