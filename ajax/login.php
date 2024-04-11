<?php
if(!$_GET['nick'] || !$_GET['pass']) { die; }
include('../config.php');
include('../functions.php');
$q = mysql_query("SELECT * FROM `users` WHERE nick = '".mysql_clean($_GET['nick'])."'");
if(!mysql_num_rows($q)) { die('El usuario no existe'); }
$u = mysql_fetch_array($q);
if($u['active'] == 0) { die('Tienes que activar tu cuenta desde el enlace de tu EMail'); }
if(md5($_GET['pass']) != $u['password']) { die('La contrase&ntilde;a no es correcta'); }
$query = mysql_query("SELECT * FROM `bans` WHERE user = '".$u['id']."' && (end > '".time()."' || end = '0') && active = '1'") or die(mysql_error());
if(mysql_num_rows($query)) {
	$ban = mysql_fetch_array($query);
	die('Has sido baneado '.($ban['end'] == '0' ? 'permanentemente' : 'hasta el '.date('d/m/Y', $ban['end']).' a las '.date('H:i', $ban['end'])).' por '.htmlspecialchars($ban['reason']));
}
	if(mysql_num_rows($q = mysql_query("SELECT id FROM `connected` WHERE ip = '".mysql_clean($_SERVER['REMOTE_ADDR'])."'"))) {
		$f = mysql_fetch_array($q);
		mysql_query("UPDATE `connected` SET user = '".$u['id']."' WHERE id = '".$f['id']."'");
	}
	setcookie($config['cookie_name'], $u['id'].'-'.$u['password'], ($_GET['rememberme'] == 1 ? time()+2592000 : 0), '/');
	if(!empty($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip = null;
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(preg_match('/[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2}$/', $proxy)) {
			$ex = explode('.', strrev($proxy));
			$cbr = strrev($ex[(count($ex)-1)].'.'.$ex[(count($ex)-2)].'.'.$ex[(count($ex)-3)].'.'.$ex[(count($ex)-4)]);
		} else {
			$cbr = null;
		}
	} else {
		$proxy = null;
		$cbr = null;
	}
	mysql_query("INSERT INTO `ips` (user, ip, proxy, cbr, time) VALUES ('".$u['id']."','".mysql_clean($ip)."','".mysql_clean($proxy)."','".mysql_clean($cbr)."','".time()."')");
	mysql_query("UPDATE `users` SET currentip = '".($ip != null ? $ip : ($cbr != null ? $cbr : $proxy))."' WHERE id = '".$u['id']."'");
echo 1;
?>