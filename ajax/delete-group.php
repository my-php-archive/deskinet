<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('No est&aacute;s logeado'); }
if(!$_GET['id'] || !mysql_num_rows($g = mysql_query("SELECT id, creator FROM `groups` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('La comunidad no existe'); }
list($id, $creator) = mysql_fetch_row($g);
if($creator != $currentuser['id'] && !isAllowedTo('delete_groups')) { die('No tienes permisos para borrar la comunidad'); }
mysql_query("DELETE FROM `groups` WHERE id = '".$id."'");
die('1');
?>