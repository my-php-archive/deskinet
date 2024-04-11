<?php
if(!defined('admin')) { header('Location: /index.php'); }
$sort_by = (!$_GET['sort_by'] || ($_GET['sort_by'] != 'nick' && $_GET['sort_by'] != 'mod' && $_GET['sort_by'] != 'reason' && $_GET['sort_by'] != 'from' && $_GET['sort_by'] != 'end' && $_GET['sort_by'] != 'active') ? 'from' : mysql_clean($_GET['sort_by']));
  // Por si alguno se le ocurre leer esto... no me quise complicar la vida, asi que lo hice a las malas...
  $posts = array();
  $query = mysql_query("SELECT DISTINCT b.post FROM buries AS b, posts AS p WHERE p.id = b.post && p.revision = '1' ORDER BY time DESC") or die(mysql_error());
  if(!mysql_num_rows($query)) { echo 'Este usuario no tiene comentarios'; } else {
  	while($f = mysql_fetch_array($query)) { if(!in_array($f['post'], $posts)) { $posts[] = $f['post']; } }
  	$c = count($posts);
  	for($i=0;$i<$c;$i++) {
		$qpost = mysql_fetch_array(mysql_query("SELECT id, cat, title, time FROM `posts` WHERE id = '".$posts[$i]."'"));
		$cat = mysql_fetch_array(mysql_query("SELECT name, urlname FROM `categories` WHERE id = '".$qpost['cat']."'"));
		echo '<span onmouseover="this.style.backgroundColor = \'transparent\';" class="categoriaPost '.$cat['urlname'].'" alt="'.$cat['name'].'" title="'.$cat['name'].'"></span> <a href="/posts/'.$cat['urlname'].'/'.$qpost['id'].'/'.url($qpost['title']).'.html" title="'.$cat['name'].'"><strong>'.htmlspecialchars($qpost['title']).'</strong></a><br /><div style="clear:both"></div>';
		$comments = mysql_query("SELECT id, message FROM `comments` WHERE post = '".$qpost['id']."' && author = '".$id."'");
		while($comment = mysql_fetch_array($comments)) {
			echo '<div class="perfil_comentario">'.date('d.m.Y H:i:s', $qpost['time']).': <a href="/posts/'.$cat['urlname'].'/'.$qpost['id'].'/'.url($qpost['title']).'.html#c'.$comment['id'].'.html">'.$comment['message'].'</a></div>';
		}
		if(($i+1) != $c) { echo '<hr />'; }
	}
  }
	?>