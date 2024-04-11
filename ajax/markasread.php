<?php
include('../config.php');
include('../functions.php');
if(!isLogged()) { die; }
mysql_query("UPDATE `notifications` SET readed = '1' WHERE user = '".$currentuser['id']."'");
?>