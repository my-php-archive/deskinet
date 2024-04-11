<?php
include('config.php');
include('functions.php');
$tags = array();
$query = mysql_query("SELECT tags FROM `posts` ORDER BY id ASC");
while($post = mysql_fetch_assoc($query)) {
	$ex = explode(',', $post['tags']);
	foreach($ex as $tag) {
		$tag = trim($tag);
		if(in_array($tag, $tags)) {
			$tags[$tag]++;
		} else {
			$tags[$tag] = 1;
		}
	}
}
foreach($tags as $tag => $num) {
	mysql_query("INSERT INTO `tags` (tag, num) VALUES ('".mysql_clean($tag)."', '".$num."')");
}
echo 'FINIZ';
?>