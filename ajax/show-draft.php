<?php
if(!$_GET['_']) { die; }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('0No est&aacute;s logeado'); }
if(!$_GET['id'] || !mysql_num_rows($g = mysql_query("SELECT user, content FROM `drafts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('0El borrador no existe'); }
$d = mysql_fetch_row($g);
if($d[0] != $currentuser['id']) { die('0No puedes borrar borradores de otros'); }
die('1'.bbcode($d[0]));
?>