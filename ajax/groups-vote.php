<?php
if(!$_GET['id'] || !$_GET['a'] || ($_GET['a'] != '1' && $_GET['a'] != '-1')) { die; }
$a = (int) $_GET['a'];
include('../config.php');
include('../functions.php');
if(!isLogged()) { die; }
if(!mysql_num_rows($q = mysql_query("SELECT id, points_by, `group`, author FROM `group_posts` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die('No existe el tema'); }
$c = mysql_fetch_array($q);
if(!mysql_num_rows(mysql_query("SELECT id FROM `group_members` WHERE `group` = '".$c['group']."' && user = '".$currentuser['id']."'"))) { die('No perteneces a la comunidad'); }
if($c['author'] == $currentuser['id']) { die('No puedes votar tu propio tema'); }
if(preg_match('/'.$currentuser['id'].'(\-|$)/', $c['points_by'])) { die('Ya has votado este tema'); }
mysql_query("UPDATE `group_posts` SET points = points+".$a.", points_by = '".(empty($c['points_by']) ? '' : $c['points_by'].'-').$currentuser['id']."' WHERE id = '".$c['id']."'");
mysql_query("INSERT INTO `group_points` (post, pnum, user_from, user_to, time) VALUES ('".$c['id']."', '".$a."', '".$currentuser['id']."', '".$c['author']."', '".time()."')") or die(mysql_error());
die('1');
?>