<?php
if(!$adni) {
	include('../config.php');
	include('../functions.php');
}
if(!isLogged()) { die('Logeate'); }
if(!$_GET['sa'] || ($_GET['sa'] != '1' && $_GET['sa'] != '2' && $_GET['sa'] != '3')) { $sa = '1'; } else { $sa = $_GET['sa']; }

if($sa == '1') {
	$query = mysql_query("SELECT c.post AS post FROM comments AS c, posts AS p WHERE c.post = p.id && p.author = '".$currentuser['id']."' ORDER BY c.time DESC LIMIT 50") or die(mysql_error());
	if(!mysql_num_rows($query)) {
		die('<br /><div class="emptyData">Nada por aqu&iacute;...</div></div></div></div><div style="clear:both"></div></div>'.file_get_contents('./footer.php'));
	}
	echo '<div id="monitorComentarios">';
	$posts = array();
	while($post = mysql_fetch_array($query)) {
		if(!in_array($post['post'], $posts)) { $posts[] = $post['post']; }
	}
	foreach($posts as $p) {
		$post = mysql_fetch_array(mysql_query("SELECT * FROM `posts` WHERE id = '".$p."'"));
		$cat = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
        	$points = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE post = '".$post['id']."'"));
		echo '<div class="commentBoxM">
       	      <div class="hTitleM categoriaPost '.$cat['urlname'].'">
       	        <a class="postTitleM" href="/posts/'.$cat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
       	        <span class="pointsPost">'.(empty($points['tp']) ? '0' : $points['tp']).' Puntos</span>
       	        <div style="clear:both"></div>
       	      </div>
       	      <div style="clear:both"></div>';
			  $comm = mysql_query("SELECT author, time, message FROM `comments` WHERE post = '".$post['id']."' ORDER BY time DESC");
		while($comment = mysql_fetch_array($comm)) {
			$author = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$comment['author']."'"));
			echo '<div class="monitor_comentario">
       			    <a href="/perfil/'.$author['nick'].'" target="_blank" title="Ver Perfil">'.$author['nick'].'</a> <span class="mDate" title="'.udate('d.m.Y', $comment['time']).' a las '.udate('h.i', $comment['time']).' hs.">dijo '.strtolower(timeFrom($comment['time'])).':</span>
       			  '.htmlspecialchars($comment['message']).'       			</div>';
		}echo '</div>';
	}
	echo '</div><!-- end #monitorComentarios-->';
} elseif($sa == '2') { // $sa
	$query = mysql_query("SELECT po.post AS post FROM points AS po, posts AS p WHERE po.post = p.id && p.author = '".$currentuser['id']."' ORDER BY po.time DESC LIMIT 50") or die(mysql_error());
	if(!mysql_num_rows($query)) {
		die('<div class="emptyData">Nada por aqu&iacute;...</div>');
	}
	echo '<div id="monitorPuntos">';
	$posts = array();
	while($post = mysql_fetch_array($query)) {
		if(!in_array($post['post'], $posts)) { $posts[] = $post['post']; }
	}
	foreach($posts as $p) {
		$post = mysql_fetch_array(mysql_query("SELECT * FROM `posts` WHERE id = '".$p."'"));
		$cat = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
        	$points = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE post = '".$post['id']."'"));
		echo '<div class="commentBoxM">
       	      <div class="hTitleM categoriaPost '.$cat['urlname'].'">
       	        <a class="postTitleM" href="/posts/'.$cat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
       	        <span class="pointsPost">'.(empty($points['tp']) ? '0' : $points['tp']).' Puntos</span>
       	        <div style="clear:both"></div>
       	      </div>
       	      <div style="clear:both"></div>';
			  $po = mysql_query("SELECT user_from, time, pnum FROM `points` WHERE post = '".$post['id']."' ORDER BY time DESC") or die(mysql_error());
		while($points = mysql_fetch_array($po)) {
			$user = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$points['user_from']."'"));
			echo '<div class="monitor_comentario" style="padding:5px;">
       			    <a href="/perfil/'.$user['nick'].'" target="_blank" title="Ver Perfil">'.$user['nick'].'</a> <span class="mDate" title="'.udate('d.m.Y', $points['time']).' a las '.udate('h.i', $points['time']).' hs.">('.timeFrom($points['time']).')</span>
       			  <div style="float:right;"><span class="mBtn btnYellow" style="color:#642514;">+'.$points['pnum'].'</span></div>
				  </div>';
		}
		echo '</div>';
	}
	echo '</div><!-- end #monitorComentarios-->';
} else { // $sa
	$query = mysql_query("SELECT f.post AS post FROM favorites AS f, posts AS p WHERE f.post = p.id && p.author = '".$currentuser['id']."' ORDER BY f.time DESC LIMIT 50") or die(mysql_error());
	if(!mysql_num_rows($query)) {
		die('<div class="emptyData">Nada por aqu&iacute;...</div>');
	}
	echo '<div id="monitorFavoritos">';
	$posts = array();
	while($post = mysql_fetch_array($query)) {
		if(!in_array($post['post'], $posts)) { $posts[] = $post['post']; }
	}
	foreach($posts as $p) {
		$post = mysql_fetch_array(mysql_query("SELECT * FROM `posts` WHERE id = '".$p."'"));
		$cat = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
        	$points = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE post = '".$post['id']."'"));
		echo '<div class="commentBoxM">
       	      <div class="hTitleM categoriaPost '.$cat['urlname'].'">
       	        <a class="postTitleM" href="/posts/'.$cat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
       	        <span class="pointsPost">'.(empty($points['tp']) ? '0' : $points['tp']).' Puntos</span>
       	        <div style="clear:both"></div>
       	      </div>
       	      <div style="clear:both"></div>';
			  $f = mysql_query("SELECT user_from, time, pnum FROM `points` WHERE post = '".$post['id']."' ORDER BY time DESC") or die(mysql_error());
		while($fav = mysql_fetch_array($f)) {
			$user = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$fav['user_from']."'"));
			echo '<div class="monitor_comentario" style="padding:7px;">
       			    <a href="/perfil/'.$user['nick'].'" target="_blank" title="Ver Perfil">'.$user['nick'].'</a> <span class="mDate" title="'.udate('d.m.Y', $points['time']).' a las '.udate('h.i', $fav['time']).' hs.">('.timeFrom($fav['time']).')</span>
       			  <div style="float:right;"><span class="mBtn btnDelete" style="color:#000;">&#9829;</span></div>
				  </div>';
		}
		echo '</div>';
	}
	echo '</div><!-- end #monitorComentarios-->';
} // $sa

?>