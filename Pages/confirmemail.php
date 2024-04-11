<?php
include('./header.php');
if(isLogged()) { die(error('HOLA', 'Bienvenido', 'Ir a la p&aacute;gina principal', '/')); }
//mysql_query("DELETE FROM `confirmemail` WHERE time < '".(time()-86400)."'");
if(!$_GET['h'] || !$_GET['en'] || !$_GET['ed'] || !mysql_num_rows(mysql_query("SELECT * FROM `confirmemail` WHERE hash = '".mysql_clean($_GET['h'])."' && email = '".mysql_clean($_GET['en'])."@".mysql_clean($_GET['ed'])."'"))) { die(error('Error', 'Faltan datos o no existe el hash para ese EMail', 'Ir a la p&aacute;gina principal', '/')); }
mysql_query("UPDATE `users` SET active = '1' WHERE email = '".mysql_clean($_GET['en'])."@".mysql_clean($_GET['ed'])."'") or die(mysql_error());
mysql_query("DELETE FROM `confirmemail` WHERE email = '".mysql_clean($_GET['en'])."@".mysql_clean($_GET['ed'])."'") or die(mysql_error());
$u = mysql_fetch_assoc(mysql_query("SELECT id, password FROM `users` WHERE email = '".mysql_clean($_GET['en'])."@".mysql_clean($_GET['ed'])."'"));
setcookie($config['cookie_name'], $u['id'].'-'.$u['password'], 0, '/');
header('Location: /cuenta/');
//die(error('YEAH!', 'Tu cuenta se ha confirmado, ahora puedes logearte', 'Ir a la p&aacute;gina principal', '/'));
?>