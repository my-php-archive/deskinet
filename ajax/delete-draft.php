<?php
if(!$_GET['_']) { die; }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
if(!$_GET['id'] || !mysql_num_rows($g = mysql_query("SELECT user FROM `drafts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('El borrador no existe'); }
$d = mysql_fetch_row($g);
if($d[0] != $currentuser['id']) { die('No puedes borrar borradores de otros'); }
mysql_query("DELETE FROM `drafts` WHERE id = '".$_GET['id']."'");
die('1');
?>