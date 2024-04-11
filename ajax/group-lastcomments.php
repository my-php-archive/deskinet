<?php
if($_GET['_']) {
  include('../config.php');
  include('../functions.php');
  if($_GET['gc']) { $c = mysql_clean($_GET['gc']); }
  if($_GET['group']) { $g = mysql_clean($_GET['group']); }
} elseif($group) {
  $g = $group['id'];
} elseif($cat) {
  $c = $cat['id'];
}
if($c && !mysql_num_rows(mysql_query("SELECT * FROM `group_categories` WHERE id = '".$c."'"))) {
	unset($c);
}
if($g && !mysql_num_rows(mysql_query("SELECT id FROM `groups` WHERE id = '".$g."'"))) {
    unset($g);
}
$q = "SELECT c.id AS cid, p.id AS pid, p.title AS title, u.nick AS author, g.urlname AS `group` FROM group_comments AS c, group_posts AS p, groups AS g, users AS u WHERE p.id = c.post && g.id = p.group && u.id = c.author";
if(isset($c)) { $q .= " && g.cat = '".$c."'"; }
if($g) { $q .= " && g.id = '".$g."'"; }
$q .= " ORDER BY c.time DESC LIMIT 15";
$query = mysql_query($q) or die(mysql_error());
$rows = mysql_num_rows($query);
echo '<img src="/images/loading.gif" id="ult_comm_loading" style="position:relative;float:right;display:none;" width="16" height="16" />
<ul>';
while($fetch = mysql_fetch_array($query)) {
	echo '<li><strong>'.$fetch['author'].'</strong> <a href="/comunidades/'.$fetch['group'].'/'.$fetch['pid'].'.'.$fetch['cid'].'/'.url($fetch['title']).'.html#c'.$fetch['cid'].'" class="size10">'.(strlen($fetch['title']) > 30 ? substr($fetch['title'], 0, 27).'...' : $fetch['title']).'</a></li>';
}
echo '</ul>';
?>