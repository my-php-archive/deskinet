<?php
include('../config.php');
include('../functions.php');
if(!$_GET['nick'] && !$_GET['email']) { die('0Error'); }
if($_GET['nick']) {
    if(mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE nick = '".mysql_clean($_GET['nick'])."'"))) { die('0El nick ya est&aacute; en uso'); }
} else {
    if(mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE email = '".mysql_clean($_GET['email'])."'"))) { die('0El email ya est&aacute; en uso'); }
}
die('1OK');
?>