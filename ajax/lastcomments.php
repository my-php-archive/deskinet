<?php
if($_GET['_']) {
  include('../config.php');
  include('../functions.php');
  if($_GET['gc']) { $cat = mysql_clean($_GET['gc']); }
}
if(isset($cat) && $cat != 'novatos' && !mysql_num_rows(mysql_query("SELECT * FROM `categories` WHERE urlname = '".$cat."'"))) {
	unset($cat);
}
if(!isset($cat)) {
	$q = "SELECT c.id AS cid, p.id AS pid, p.title AS title, ca.urlname AS curl, c.author AS author FROM comments AS c, posts AS p, users AS u, categories AS ca WHERE p.id = c.post && u.id = p.author && u.rank != '0' && ca.id = p.cat";
} elseif($cat == 'novatos') {
	$q = "SELECT c.id AS cid, p.id AS pid, p.title AS title, ca.urlname AS curl, c.author AS author FROM comments AS c, posts AS p, users AS u, categories AS ca WHERE p.id = c.post && u.id = p.author && u.rank = '0' && ca.id = p.cat";
} else {
	$q = "SELECT c.id AS cid, p.id AS pid, p.title AS title, ca.urlname AS curl, c.author AS author FROM comments AS c, posts AS p, users AS u, categories AS ca WHERE p.id = c.post && u.id = p.author && u.rank != '0' && ca.id = p.cat && ca.urlname = '".$cat."'";
}
$q .= " ORDER BY c.time DESC LIMIT 15";
$query = mysql_query($q) or die(mysql_error());
$rows = mysql_num_rows($query);
echo '<img src="/images/loading.gif" id="ult_comm_loading" style="position:relative;float:right;display:none;" width="16" height="16" />
<ul>';
while($fetch = mysql_fetch_array($query)) {
	$author = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$fetch['author']."'"));
	echo '<li><strong>'.$author['nick'].'</strong> <a href="/posts/'.$fetch['curl'].'/'.$fetch['pid'].'.'.$fetch['cid'].'/'.url($fetch['title']).'.html#c'.$fetch['cid'].'" class="size10">'.(strlen($fetch['title']) > 30 ? substr($fetch['title'], 0, 27).'...' : $fetch['title']).'</a></li>';
}
echo '</ul>';
?>