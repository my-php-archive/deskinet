<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No estas logeado'); }
if(!mysql_num_rows($query = mysql_query("SELECT id, post, author FROM `group_comments` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('El comentario no existe'); }
$comment = mysql_fetch_array($query);
$post = mysql_fetch_array(mysql_query("SELECT author, `group` FROM `group_posts` WHERE id = '".$comment['post']."'"));
if($post['author'] != $currentuser['id'] && !isAllowedTo('groups_delete_comments') && !mysql_num_rows(mysql_query("SELECT id FROM `group_members` WHERE user = '".$currentuser['id']."' && `group` = '".$post['group']."'"))) { die('No tienes permisos para borrar este comentario'); }
mysql_query("DELETE FROM `notifications` WHERE link REGEXP '/comunidades/.+/[0-9]+.".$comment['id']."/.+.html#c".$comment['id']."'");
mysql_query("DELETE FROM `group_comments` WHERE id = '".mysql_clean($_GET['id'])."'");
die('1');
?>