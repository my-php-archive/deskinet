<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if($topt && ($topt == '1' || $topt == '2')) {
	echo '<div class="filterBy" id="fB'.($topt == '1' ? 'p' : 'u').'">
        Filtrar por: <a id="filter_'.$topt.'_Semana" href="#" onclick="TopsTabs(\''.($topt == '1' ? 'posts_' : 'users_').'\',\'Semana\');return false;"'.($topt == '1' ? ' class="here"' : '').'>Semana</a> - <a id="filter_'.$topt.'_Mes" href="#" onclick="TopsTabs(\''.($topt == '1' ? 'posts_' : 'users_').'\',\'Mes\');return false;"'.($topt == '2' ? ' class="here"' : '').'>Mes</a> - <a id="filter_'.$topt.'_Historico" href="#" onclick="TopsTabs(\''.($topt == '1' ? 'posts_' : 'users_').'\',\'Historico\');return false;">Hist&oacute;rico</a>    </div>';
	//$qt[1] = time()-((date('N')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('s')))); // semana
	//$qt[2] = time()-((date('j')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('s')))); // mez
	$qt[1] = time()-(date('w')*86400+date('G')*3600+date('i')*60);
	$qt[2] = time()-((date('j')-1)*86400+date('G')*3600+date('i')*60);
	$qt[3] = 0;
	$tt[1] = 'Semana';
	$tt[2] = 'Mes';
	$tt[3] = 'Historico';

	if($topt == '1') {
		$wol = 'var t_posts = new Array(3);';
		for($i=1;$i<=3;$i++) {
			$query = mysql_query("SELECT p.id AS id, p.title AS title, c.urlname AS uname, SUM(po.pnum) AS points FROM posts AS p, categories AS c, points AS po WHERE po.post = p.id && c.id = p.cat && po.time >= '".$qt[$i]."' GROUP BY po.post ORDER BY points DESC LIMIT 15");
			$rows = mysql_num_rows($query);
			$wol .= "t_posts[".$i."] = document.getElementById('posts_filterBy".$tt[$i]."').offsetHeight;\ndocument.getElementById('posts_filterBy".$tt[$i]."').style.visibility = 'visible';\n";
			if($i != 1) { $wol .= "document.getElementById('posts_filterBy".$tt[$i]."').style.display = 'none';\n"; }
			echo '<ol class="filterBy" id="posts_filterBy'.$tt[$i].'">';
			while($post = mysql_fetch_array($query)) {
				echo '<li><a href="/posts/'.$post['uname'].'/'.$post['id'].'/'.url($post['title']).'.html" title="'.htmlspecialchars($post['title']).'">'.(strlen($post['title']) > 37 ? substr(htmlspecialchars($post['title']), 0, 40).'...' : htmlspecialchars($post['title'])).'</a> ('.$post['points'].')</li>';
			}
			echo '</ol>';
		}
		echo '<script type="text/javascript">
		'.$wol.'
		var t_posts_selected = 1;
		var t_posts_box_dh = parseInt(document.getElementById(\'fBp\').offsetHeight+5);
		document.getElementById(\'box_c_posts\').style.height = parseInt(t_posts_box_dh+t_posts[t_posts_selected]) + \'px\';
		</script>';
	} else {
		$query = mysql_query("SELECT u.nick AS nick, SUM(po.pnum) AS points FROM users AS u, points AS po WHERE po.user_to = u.id && po.time >= '".$qt."' GROUP BY po.user_to ORDER BY points DESC LIMIT 15");
		$rows = mysql_num_rows($query);
		$wol = 'var t_users = new Array(3);';
		for($i=1;$i<=3;$i++) {
			$query = mysql_query("SELECT u.nick AS nick, SUM(po.pnum) AS points FROM users AS u, points AS po WHERE po.user_to = u.id && po.time >= '".$qt[$i]."' GROUP BY po.user_to ORDER BY points DESC LIMIT 15");
			$rows = mysql_num_rows($query);
			$wol .= "t_users[".$i."] = document.getElementById('users_filterBy".$tt[$i]."').offsetHeight;\ndocument.getElementById('users_filterBy".$tt[$i]."').style.visibility = 'visible';\n";
			if($i != 2) { $wol .= "document.getElementById('users_filterBy".$tt[$i]."').style.display = 'none';\n"; }
			echo '<ol class="filterBy" id="'.($topt == '1' ? 'posts_' : 'users_').'filterBy'.$tt[$i].'">';
			while($user = mysql_fetch_array($query)) {
				echo '<li><a href="/perfil/'.$user['nick'].'">'.$user['nick'].'</a> ('.$user['points'].')</li>';
			}
			echo '</ol>';
		}
		echo '<script type="text/javascript">
		'.$wol.'
		var t_users_selected = 2;
		var t_users_box_dh = parseInt(document.getElementById(\'fBu\').offsetHeight+5);
		document.getElementById(\'box_c_users\').style.height = parseInt(t_users_box_dh+t_posts[t_users_selected]) + \'px\';
		</script>';
	}
} else {
//...!
//if(!isLogged()) { die(error('OOPS!', 'Para ver el top necesitas autentificarte', 'Ir a la p&aacute;gina principal', '/')); }
// 360 303 303
if(!$_GET['tf'] || ($_GET['tf'] != 'day' && $_GET['tf'] != 'yesterday' && $_GET['tf'] != 'week' && $_GET['tf'] != 'month' && $_GET['tf'] != 'lastmonth' && $_GET['tf'] != 'ever')) { $tf = 'ever'; } else { $tf = $_GET['tf']; }
if($tf == 'day') { 
	$qt = time()-((date('G')*3600)+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('i'))));
	$tt = 'del d&iacute;a';
	$tf = 'dia';
} elseif($tf == 'yesterday') {
	$qt = (time()-((date('G')*3600)+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('i'))))-86400)."' && po.time < '".time()-((date('G')*3600)+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('i'))));
	$tt = 'de ayer';
	$tf = 'ayer';
} elseif($tf == 'week') {
	$qt = time()-((date('N')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('i'))));
	$tt = 'de la semana';
	$tf = 'semana';
} elseif($tf == 'month') {
	$qt = time()-((date('j')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('i'))));
	$tt = 'del mes';
	$tf = 'mes';
} elseif($tf == 'lastmonth') {
	$qt = (time()-((date('j')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('i'))))-2592000)." && po.time < '".time()-((date('j')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('i'))));
	$tt = 'del mes pasado';
	$tf = 'mes-anterior';
} elseif($tf == 'ever') {
	$qt = 0;
	$tt = '';
	$tf = '';
}

if($_GET['cat'] && mysql_num_rows($qcat = mysql_query("SELECT id FROM `categories` WHERE urlname = '".mysql_clean($_GET['cat'])."'"))) {
	$fcat = mysql_fetch_array($qcat);
	$cat = $fcat['id'];
	unset($qcat, $fcat);
	$qt .= "' && p.cat = '".$cat;
}
?>
<div id="cuerpocontainer">
    <div class="box_cuerpo">
    <center style="padding-top:10px;padding-bottom:10px;">
<b>TOPs de </b>
	<select id="top_fs" name="fecha">
		<option value="siempre"<?=($tf == 'siempre' ? ' selected' : '');?>>Todos los tiempos</option>
		<option value="hoy"<?=($tf == 'hoy' ? ' selected' : '');?>>Hoy</option>
		<option value="ayer"<?=($tf == 'ayer' ? ' selected' : '');?>>Ayer</option>
		<option value="semana"<?=($tf == 'semana' ? ' selected' : '');?>>De la semana</option>
		<option value="mes"<?=($tf == 'mes' ? ' selected' : '');?>>Del mes</option>
		<option value="mes-anterior"<?=($tf == 'mes-anterior' ? ' selected' : '');?>>Mes Anterior</option>
	</select>
	<b>de la Categoria:</b>
	&nbsp;
	<select id="top_cs" name="cat">
		<option value="0">Todas</option>
				<?php
				$query = mysql_query("SELECT id, name, urlname FROM `categories` ORDER BY name ASC");
				while($scat = mysql_fetch_array($query)) {
					echo '<option '.($cat == $scat['id'] ? 'selected ' : '').'value="'.$scat['urlname'].'">'.$scat['name'].'</option>';
				}
				?>
		</select>
        &nbsp;
        <input type="button" value="Filtrar" class="login" onclick="document.location = '/top/' + document.getElementById('top_fs').options[document.getElementById('top_fs').selectedIndex].value + '/' + (document.getElementById('top_cs').selectedIndex == '0' ? '' : document.getElementById('top_cs').options[document.getElementById('top_cs').selectedIndex].value);" />
</center>
</div>
<br />
<div class="tops" id="izquierda">
<div class="box_title">
  <div class="box_txt">Posts con m&aacute;s puntos <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/posts/puntos/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_1_1">
<?php
$query = mysql_query("SELECT p.id AS id, p.title AS title, ca.urlname AS uname, SUM(po.pnum) AS points FROM posts AS p, categories AS ca, points AS po WHERE po.post = p.id && ca.id = p.cat && po.time >= '".$qt."' GROUP BY po.post ORDER BY points DESC LIMIT 15");
$rows = mysql_num_rows($query);
$i = 0;
while($post = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/posts/'.$post['uname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.(strlen($post['title']) > 37 ? substr(htmlspecialchars($post['title']), 0, 40).'...' : htmlspecialchars($post['title'])).'</a> ('.$post['points'].' puntos)';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
<br />
<div class="box_title">
  <div class="box_txt">Usuarios con m&aacute;s puntos <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/usuarios/puntos/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_1_2">
<?php
if($cat) {
	$query = mysql_query("SELECT u.nick AS nick, SUM(po.pnum) AS points FROM users AS u, points AS po, posts AS p, categories AS ca WHERE po.user_to = u.id && p.id = po.post && ca.id = p.cat && po.time >= '".$qt."' GROUP BY po.user_to ORDER BY points DESC LIMIT 15");
} else {
	$query = mysql_query("SELECT u.nick AS nick, SUM(po.pnum) AS points FROM users AS u, points AS po WHERE u.id = po.user_to && po.time >= '".$qt."' GROUP BY po.user_to ORDER BY points DESC LIMIT 15");
}
$rows = mysql_num_rows($query);
$i = 0;
while($user = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/perfil/'.$user['nick'].'">'.$user['nick'].'</a> ('.$user['points'].' puntos)';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
</div><!--izq-->
<div class="tops" id="centro">
<div class="box_title">
  <div class="box_txt">Posts con m&aacute;s comentarios <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/posts/comentarios/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_2_1">
<?php
$query = mysql_query("SELECT p.id AS id, p.title AS title, ca.urlname AS uname, COUNT(c.id) AS comments FROM posts AS p, users AS u, comments AS c, categories AS ca WHERE u.id = p.author && ca.id = p.cat && c.post = p.id && c.time >= '".$qt."' GROUP BY p.id ORDER BY comments DESC LIMIT 15") or die(mysql_error());
$rows = mysql_num_rows($query);
$i = 0;
while($post = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/posts/'.$post['uname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.(strlen($post['title']) > 37 ? substr(htmlspecialchars($post['title']), 0, 40).'...' : htmlspecialchars($post['title'])).'</a> ('.$post['comments'].' comentarios)';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
<br />
<div class="box_title">
  <div class="box_txt">Usuarios con m&aacute;s comentarios <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/usuarios/comentarios/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_2_2">
<?php
$query = mysql_query("SELECT u.nick AS nick, COUNT(c.id) AS comments FROM users AS u, comments AS c, categories AS ca, posts AS p WHERE c.author = u.id && p.id = c.post && ca.id = p.cat && c.time >= '".$qt."' GROUP BY u.id ORDER BY comments DESC LIMIT 15") or die(mysql_error());
$rows = mysql_num_rows($query);
$i = 0;
while($user = mysql_fetch_array($query)) {
$user['comments']--;
$i++;
echo '<b>'.$i.'</b> - <a href="/perfil/'.$user['nick'].'">'.$user['nick'].'</a> ('.$user['comments'].' comentarios)';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
</div><!--centro-->
<div class="tops" id="derecha">
<div class="box_title">
  <div class="box_txt">Posts con m&aacute;s visitas <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/posts/visitas/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_3_1">
<?php
$query = mysql_query("SELECT p.id AS id, p.title AS title, ca.urlname AS uname, COUNT(v.id) AS visits FROM posts AS p, categories AS ca, visits AS v WHERE ca.id = p.cat && v.post = p.id && v.time >= '".$qt."' GROUP BY v.post ORDER BY visits DESC LIMIT 15");
$rows = mysql_num_rows($query);
$i = 0;
while($post = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/posts/'.$post['uname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.(strlen($post['title']) > 37 ? substr(htmlspecialchars($post['title']), 0, 40).'...' : htmlspecialchars($post['title'])).'</a> ('.$post['visits'].' visitas)';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
<br />
<div class="box_title">
  <div class="box_txt">Usuarios con m&aacute;s posts <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/usuarios/posts/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_3_2">
<?php
$query = mysql_query("SELECT u.nick AS nick, COUNT(p.id) AS posts FROM users AS u, posts AS p, categories AS ca WHERE p.author = u.id  && ca.id = p.cat && p.time >= '".$qt."' GROUP BY u.id ORDER BY posts DESC LIMIT 15") or die(mysql_error());
$rows = mysql_num_rows($query);
$i = 0;
while($user = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/perfil/'.$user['nick'].'">'.$user['nick'].'</a> ('.$user['posts'].' posts)';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
</div><!--der-->
<div style="clear:both"></div>
<script type="text/javascript">
var bc11, bc12, bc21, bc22, bc31, bc32;
bc11 = document.getElementById('bc_1_1');
bc12 = document.getElementById('bc_1_2');
bc21 = document.getElementById('bc_2_1');
bc22 = document.getElementById('bc_2_2');
bc31 = document.getElementById('bc_3_1');
bc32 = document.getElementById('bc_3_2');
var mw1 = Math.max(bc11.offsetHeight, bc21.offsetHeight, bc31.offsetHeight);
bc11.style.height = mw1;
bc21.style.height = mw1;
bc31.style.height = mw1;
var mw2 = Math.max(bc12.offsetHeight, bc22.offsetHeight, bc32.offsetHeight);
bc12.style.height = mw2;
bc22.style.height = mw2;
bc32.style.height = mw2;
</script>
</div><!--cc-->
<? } /* MIERDA DE LO DE PRINCIPAL */ ?>