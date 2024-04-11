<?php
if(!defined($config['define'])) { header('Location: /index.php'); }
$time = time();
$ntime = 60*15;
mysql_query("DELETE FROM `connected` WHERE time < '".($time-$ntime)."'") or die(mysql_error());

$query = mysql_query("SELECT id FROM `connected` WHERE ip = '".mysql_clean($_SERVER['REMOTE_ADDR'])."'".(isLogged() ? " || user = '".$currentuser['id']."'" : ''));

if(!mysql_num_rows($query)) {
	if(!isLogged()) {
		mysql_query("INSERT INTO `connected` (ip, time) VALUES ('".mysql_clean($_SERVER['REMOTE_ADDR'])."','".$time."')");
	} else {
		mysql_query("INSERT INTO `connected` (ip, time, user) VALUES ('".mysql_clean($_SERVER['REMOTE_ADDR'])."','".$time."','".$currentuser['id']."')");
	}
} else {
	$f = mysql_fetch_array($query);
	mysql_query("UPDATE `connected` SET time = '".$time."' WHERE id = '".$f['id']."'");
}
// stats
$pstats['total_users'] = mysql_num_rows(mysql_query("SELECT * FROM `connected`"));
$pstats['reg_users'] = mysql_num_rows(mysql_query("SELECT * FROM `connected` WHERE user != '0'"));
?>