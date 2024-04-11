<?php
if(!$_GET['_'] || !$_GET['id'] || !$_GET['a'] || !is_numeric($_GET['_']) || !is_numeric($_GET['id']) || ($_GET['a'] != 'a' && $_GET['a'] != 'r')) { die('Error de usuario'); }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('Debes logearte'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('No existe el comentario'); }
if(!mysql_num_rows(mysql_query("SELECT id FROM `comment_complaints` WHERE comment = '".mysql_clean($_GET['id'])."'"))) { die('El comentario no ha sido denunciado'); }
list($id) = mysql_fetch_row(mysql_query("SELECT p.author FROM users AS u, comments AS c, posts AS p WHERE c.id = '".mysql_clean($_GET['id'])."' && p.id = c.post && u.id = p.author "));
if($id != $currentuser['id'] && !isAllowedTo('comment_complaints')) { die('No puedes manejar las denuncias de este comentario'); }
mysql_query("DELETE FROM `comment_complaints` WHERE comment = '".mysql_clean($_GET['id'])."'");
if($_GET['a'] == 'a') {
	mysql_query("DELETE FROM `comments` WHERE id = '".mysql_clean($_GET['id'])."'");
}
die('1');
?>