<?php
if($_GET['i']) { include('../config.php'); include('../functions.php'); }
if(!$_GET['shortby'] && !$shortby) { die('<tr><td colspan="5">ERROR PROVOCADO POR EL USUARIO - EC:1</td></tr>'); }
if($_GET['shortby']) { $shortby = $_GET['shortby']; }
if($_GET['cat'] && $_GET['cat'] != 'all') { $cat = mysql_clean($_GET['cat']); }
if($shortby != 'guardado' && $shortby != 'creado' && $shortby != 'titulo' && $shortby != 'puntos' && $shortby != 'visitas') { die('<tr><td colspan="5">ERROR PROVOCADO POR EL USUARIO - EC:2</td></tr>'); }
if($cat && !mysql_num_rows(mysql_query("SELECT * FROM `categories` WHERE id = '".$cat."'"))) { die('<tr><td colspan="5">ERROR PROVOCADO POR EL USUARIO - EC:3</td></tr>'); }
if(!isLogged()) { die('No est&aacute;s logeado'); }
if(!mysql_num_rows(mysql_query("SELECT * FROM `favorites` WHERE user = '".$currentuser['id']."'"))) { die('No tienes post favoritos'); }
if(!$cat) {
	if($shortby == 'guardado') {
		$q = "SELECT * FROM `favorites` WHERE user = '".$currentuser['id']."' ORDER BY time DESC";
	} elseif($shortby == 'creado') {
		$q = "SELECT f.* FROM favorites AS f, posts AS p WHERE f.user = '".$currentuser['id']."' && p.id = f.post ORDER BY p.time DESC";
	} elseif($shortby == 'puntos') {
		$q = "SELECT f.* FROM favorites AS f, points AS p WHERE f.user = '".$currentuser['id']."' && p.post = f.post GROUP BY p.post ORDER BY SUM(p.pnum) DESC";
	} elseif($shortby == 'visitas') {
		$q = "SELECT f.* FROM favorites AS f, visits AS v WHERE f.user = '".$currentuser['id']."' && v.post = f.post GROUP BY v.post ORDER BY COUNT(v.id) DESC";
	} elseif($shortby == 'titulo') {
		$q = "SELECT f.* FROM favorites AS f, posts AS p WHERE f.user = '".$currentuser['id']."' && p.id = f.post ORDER BY p.title ASC";
	}
} else {
	if($shortby == 'guardado') {
		$q = "SELECT f.* FROM favorites AS f, posts AS p WHERE f.user = '".$currentuser['id']."' && p.id = f.post && p.cat = '".$cat."' ORDER BY f.time DESC";
	} elseif($shortby == 'creado') {
		$q = "SELECT f.* FROM favorites AS f, posts AS p WHERE f.user = '".$currentuser['id']."' && p.id = f.post && p.cat = '".$cat."' ORDER BY p.time DESC";
	} elseif($shortby == 'puntos') {
		$q = "SELECT f.* FROM favorites AS f, points AS p, posts AS po WHERE f.user = '".$currentuser['id']."' && p.post = f.post && po.id = f.post && po.cat = '".$cat."' GROUP BY p.post ORDER BY SUM(p.pnum) DESC";
	} elseif($shortby == 'visitas') {
		$q = "SELECT f.* FROM favorites AS f, visits AS v, posts AS p WHERE f.user = '".$currentuser['id']."' && v.post = f.post && p.id = f.post && p.cat = '".$cat."' GROUP BY v.post ORDER BY COUNT(v.id) DESC";
	} elseif($shortby == 'titulo') {
		$q = "SELECT f.* FROM favorites AS f, posts AS p WHERE f.user = '".$currentuser['id']."' && p.id = f.post && p.cat = '".$cat."' ORDER BY p.title ASC";
	}
}
$query = mysql_query($q) or die(mysql_error());	
if($_GET['i']) {
	echo '<table class="linksList" id="favs_table">
			<thead>
				<tr>
					<th></th>
					<th style="text-align:left;width:350px;overflow:hidden;"><a href="#" onclick="filtro_favs(\'orden\', \'titulo\', this); return false;" id="orden_e_titulo">T&iacute;tulo</a></th>
					<th><a href="#" onclick="filtro_favs(\'orden\', \'creado\', this); return false;" id="orden_e_creado">Creado</a></th>
					<th><a href="#" onclick="filtro_favs(\'orden\', \'guardado\', this); return false;" id="orden_e_guardado">Guardado</a></th>
					<th><a href="#" onclick="filtro_favs(\'orden\', \'puntos\', this); return false;" id="orden_e_puntos">Puntos</a></th>
					<th><a href="#" onclick="filtro_favs(\'orden\', \'visitas\', this); return false;" id="orden_e_visitas">Visitas</a></th>
					<th></th>
				</tr>
			</thead>';
}
echo '<tbody>';
while($fav = mysql_fetch_array($query)) {
	$post = mysql_fetch_array(mysql_query("SELECT id, title, time, cat FROM `posts` WHERE id = '".$fav['post']."'"));
	$points = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS p FROM `points` WHERE post = '".$post['id']."'"));
	$visits = mysql_fetch_array(mysql_query("SELECT COUNT(id) AS v FROM `visits` WHERE post = '".$post['id']."'"));
	$cat = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
	echo '<tr id="div_'.$fav['id'].'">
					<td>
						<span class="categoriaPost '.$cat['urlname'].'">
						</span>
					</td>
					<td style="text-align:left">
						<a class="titlePost" href="/posts/'.$cat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html" title="'.htmlspecialchars($post['title']).'" alt="'.htmlspecialchars($post['title']).'">'.htmlspecialchars($post['title']).'</a>
					</td>
					<td title="'.gmdate('d.m.Y', $post['time']).' a las '.gmdate('h:i', $post['time']).' hs.">
						'.timefrom($post['time']).'					</td>
					<td title="'.gmdate('d.m.Y', $fav['time']).' a las '.gmdate('h:i', $fav['time']).' hs.">
						'.timefrom($fav['time']).'					</td>
					<td class="color_green">
						'.($points['p'] ? $points['p'] : '0').'					</td>
					<td>
						'.$visits['v'].'					</td>
					<td>
						<a id="change_status_'.$fav['id'].'_1" href="#" onclick="action_favs('.$fav['id'].', '.$fav['post'].', '.$fav['time'].', 1);return false;"><img src="/images/borrar.png" alt="Borrar" title="Borrar favorito" id="action_img_'.$fav['id'].'" /></a>
						<a id="change_status_'.$fav['id'].'_2" href="#" onclick="action_favs('.$fav['id'].', '.$fav['post'].', '.$fav['time'].', 2);return false;" style="display:none;"><img src="/images/reactivar.png" alt="Borrar" title="Reactivar favorito" id="action_img_'.$fav['id'].'" /></a>
					</td>
				</tr>';
}
echo '</tbody>';
if($_GET['i']) { echo '</table>'; }
?>