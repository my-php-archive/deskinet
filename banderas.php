<style type="text/css">
table {
    border-top: 1px solid #000;
    border-left: 1px solid #000;
}
td {
    border-bottom: 1px solid #000;
    border-right: 1px solid #000;
    padding: 5px;
}


</style>
<table cellpading="0" cellspacing="0">
<?php
include('config.php');
//$connection = mysql_connect('localhost', 'pepe', '');
//mysql_select_db('test', $connection);
$query = mysql_query("SELECT code FROM `countries` ORDER BY code ASC");
while($c = mysql_fetch_row($query)) {
  echo '<tr><td><img src="http://o2.t26.net/images/flags/'.strtolower($c[0]).'.png" alt="'.$c[0].'" title="'.$c[0].'" width="16" height="11" /></td></tr>';
}
?>