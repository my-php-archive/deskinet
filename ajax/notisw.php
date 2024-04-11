<?php
if(!$_GET['_'] || !$_GET['c'] || !preg_match('/^([0-9]{1,2}:(1|2),?)+$/', $_GET['c'])) { die('Datos incorrectos'); }
include('../config.php');
include('../functions.php');
if(!isLogged()) { die('Logeate'); }
$ex = explode(',', $_GET['c']);
$c = count($ex);
for($i=0;$i<$c;$i++) {
	if(!preg_match('/^(1|2|3|4|5|6|7|8|9|10|11):(1|2)$/', $ex[$i])) {
		unset($ex[$i]);
	}
}

foreach($ex as $v) {
	$e = explode(':', $v);
	$w[$e[0]] = ($e[1] == '1' ? '1' : '0');
}
$ex = explode(',', $currentuser['notificate']);
foreach($ex as $v) {
	$e = explode(':', $v);
	if(!isset($w[$e[0]])) { $w[$e[0]] = $e[1]; }
}
foreach($w as $key => $value) {
	$n .= ','.$key.':'.$value;
}
mysql_query("UPDATE `users` SET notificate = '".substr($n, 1)."' WHERE id = '".$currentuser['id']."'");
die('1');
?>