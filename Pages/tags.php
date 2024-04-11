<?php
$t = time();
$connection = mysql_connect('localhost', 'pepe', '');
mysql_select_db('test', $connection);
$v = 'бйнуъдлвкстз';
$v = utf8_encode(utf8_decode($v));
mysql_query("INSERT INTO `provinces` (name, country, code) VALUES ('".$v."', '1', '0')") or die(mysql_error());
list($s) = mysql_fetch_row(mysql_query("SELECT name FROM `provinces` ORDER BY id DESC LIMIT 1"));
echo $s;
echo '------ok';
?>