<?php
include('../config.php');
include('../functions.php');
if(!$_GET['nick'] || !$_GET['email']) { die; }
if(mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE nick = '".mysql_clean($_GET['nick'])."'"))) { die('El nick ya est&aacute; en uso'); }
if(mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE email = '".mysql_clean($_GET['email'])."'"))) { die('El EMail ya est&aacute; en uso'); }
die('1');
?>