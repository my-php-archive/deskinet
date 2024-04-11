<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if(!$_GET['id'] && !$_GET['nick']) { $id = $currentuser['id']; }
if($_GET['id'] && !mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE id = '".mysql_clean($_GET['id'])."'"))) { $id = '0'; } else { $id = mysql_clean($_GET['id']); }
if($_GET['nick'] && !mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE nick = '".mysql_clean($_GET['nick'])."'"))) { $nick = '0'; } else { $nick = mysql_clean($_GET['nick']); }
if($id == '0' || $nick == '0') {
	if(isLogged()) {
		$user = $currentuser;
	} else {
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` ORDER BY RAND() LIMIT 1"));
	}
} else {
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE ".($id ? 'id' : 'nick')." = '".($id ? $id : $nick)."'"));
	//mysql_query("UPDATE `notifications` SET readed = '1' WHERE what = '2' && `where` = '".$user['id']."' && readed = '0' && user = '".$currentuser['id']."'");
}
$url = '/perfil/'.($id ? $user['id'].'/id/' : $user['nick'].'/');
$txt['page_title'] = 'Perfil de '.$user['nick'];
?>