<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!$_GET['id']) { die(error('OOPS!', '&iquest;Qué post?', 'Ir a la p&aacute;gina principal', '/')); }
$q = "SELECT id, title FROM `posts` WHERE id ".($_GET['act'] == 'prev' ? '<' : '>')." '".mysql_clean($_GET['id'])."' ORDER BY id ".($_GET['act'] == 'prev' ? 'DESC' : 'ASC')." LIMIT 1";
$query = mysql_query($q) or die($q.'-'.mysql_error());
if(!mysql_num_rows($query)) { die(error('OOPS!', 'Ese fu&eacute; el &uacute;ltimo post amigos...', 'Ir a la p&aacute;gina principal', '/')); }
$f = mysql_fetch_array($query);
$_GET['id'] = $f['id'];
$_GET['title'] = $f['title'];
unset($f, $query);
include('post.php');
?>