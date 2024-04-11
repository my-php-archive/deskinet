<?php
include('../config.php');
include('../functions.php');
if(!mysql_num_rows($q = mysql_query("SELECT message, `group` FROM `group_comments` WHERE id = '".mysql_clean($_GET['id'])."'"))) { die; }
$c = mysql_fetch_array($q);
if(!isLogged()) {
	$g = mysql_fetch_array(mysql_query("SELECT private FROM `groups` WHERE id = '".$c['group']."'"));
	if($g['private'] == '1') { die; }
}
echo $c['message'];
?>