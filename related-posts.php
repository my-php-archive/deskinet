<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if($_GET['title'] && $_GET['id']) {
	$title = mysql_clean(str_replace('-', ' ', $_GET['title']));
	$rq = (substr_count($title, ' ') == 0 ? "SELECT title, id, cat, MATCH(title, message) AGAINST('".$title."') AS score FROM `posts` WHERE (title LIKE '%".$title."%' OR message LIKE '%".$title."%')" : "SELECT *, MATCH(title, message) AGAINST('".$title."') AS score FROM `posts` WHERE MATCH(title, message) AGAINST('".$title."')");
	$rq .= " && id != '".mysql_clean($_GET['id'])."' ORDER BY score DESC LIMIT 10";
	$rquery = mysql_query($rq);
	while($relatedpost = mysql_fetch_array($rquery)) {
		$relatedcat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `categories` WHERE id = '".$relatedpost['cat']."'"));
		echo '<li class="categoriaPost '.$relatedcat['urlname'].'"><a href="/posts/'.$relatedcat['name'].'/'.$relatedpost['id'].'/'.url($relatedpost['title']).'.html">'.htmlspecialchars($relatedpost['title']).'</a></li>';
	}
} // title
?>