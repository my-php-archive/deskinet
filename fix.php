<?php
include('config.php');
$query = mysql_query("SELECT id,user FROM `follows` WHERE what = '2' && who ='357'");
while(list($i,$u)=mysql_fetch_row($query)) {
if(!mysql_num_rows(mysql_query("SELECT id FROM `users` WHERE id = '".$u."'"))) {
mysql_query("DELETE FROM `follows` WHERE id = '".$i."'");
}
}
unlink('__FILE__');
?>