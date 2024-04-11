<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
if($topt) {
	echo '<div class="filterBy" id="fBg">
        Filtrar por: <a id="filter_3_Semana" href="#" onclick="TopsTabs(\'groups_\',\'Semana\');return false;" class="here">Semana</a> - <a id="filter_3_Mes" href="#" onclick="TopsTabs(\'groups_\',\'Mes\');return false;">Mes</a> - <a id="filter_3_Historico" href="#" onclick="TopsTabs(\'groups_\',\'Historico\');return false;">Hist&oacute;rico</a>    </div>';
	//$qt[1] = time()-((date('N')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('s')))); // semana
	//$qt[2] = time()-((date('j')-1)*86400+((((int) substr(date('i'), 0, 1)) == 0 ? (int) substr(date('i'), 1) : (int) date('i'))*60)+((((int) substr(date('s'), 0, 1)) == 0 ? (int) substr(date('s'), 1) : (int) date('s')))); // mez
	$qt[1] = time()-(date('w')*86400+date('G')*3600+date('i')*60);
	$qt[2] = time()-((date('j')-1)*86400+date('G')*3600+date('i')*60);
	$qt[3] = 0;
	$tt[1] = 'Semana';
	$tt[2] = 'Mes';
	$tt[3] = 'Historico';

		$wol = 'var t_groups = new Array(3);';
		for($i=1;$i<=3;$i++) {
			$query = mysql_query("SELECT g.name AS name, g.urlname AS url, COUNT(m.id) AS members FROM groups AS g, group_members AS m WHERE m.group = g.id && m.time >= '".$qt[$i]."' GROUP BY g.id ORDER BY members DESC LIMIT 15");
			$rows = mysql_num_rows($query);
			$wol .= "t_groups[".$i."] = document.getElementById('groups_filterBy".$tt[$i]."').offsetHeight;\ndocument.getElementById('groups_filterBy".$tt[$i]."').style.visibility = 'visible';\n";
			if($i != 1) { $wol .= "document.getElementById('groups_filterBy".$tt[$i]."').style.display = 'none';\n"; }
			echo '<ol class="filterBy" id="groups_filterBy'.$tt[$i].'">';
			while($group = mysql_fetch_array($query)) {
				echo '<li><a href="/comunidades/'.$group['url'].'/">'.(strlen($group['name']) > 37 ? substr(htmlspecialchars($group['name']), 0, 40).'...' : htmlspecialchars($group['name'])).'</a> ('.$group['members'].')</li>';
			}
			echo '</ol>';
		}
		echo '<script type="text/javascript">
		'.$wol.'
		var t_groups_selected = 1;
		var t_groups_box_dh = parseInt(document.getElementById(\'fBg\').offsetHeight+5);
		document.getElementById(\'box_c_groups\').style.height = parseInt(t_groups_box_dh+t_groups[t_groups_selected]) + \'px\';
		</script>';
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

if($_GET['cat'] && mysql_num_rows($qcat = mysql_query("SELECT id FROM `group_categories` WHERE urlname = '".mysql_clean($_GET['cat'])."'"))) {
	$fcat = mysql_fetch_array($qcat);
	$cat = $fcat['id'];
	unset($qcat, $fcat);
	$qt .= "' && g.cat = '".$cat;
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
				$query = mysql_query("SELECT id, name, urlname FROM `group_categories` WHERE sub = '0' ORDER BY name ASC");
				while($scat = mysql_fetch_array($query)) {
					echo '<option '.($cat == $scat['id'] ? 'selected ' : '').'value="'.$scat['urlname'].'">'.$scat['name'].'</option>';
				}
				?>
		</select>
        &nbsp;
        <input type="button" value="Filtrar" class="login" onclick="document.location = '/comunidades/top/' + document.getElementById('top_fs').options[document.getElementById('top_fs').selectedIndex].value + '/' + (document.getElementById('top_cs').selectedIndex == '0' ? '' : document.getElementById('top_cs').options[document.getElementById('top_cs').selectedIndex].value);" />
</center>
</div>
<br />
<div class="tops" id="izquierda">
<div class="box_title">
  <div class="box_txt">Comunidades con m&aacute;s miembros <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/comunidades/miembros/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_1_1">
<?php
$query = mysql_query("SELECT g.name AS name, g.urlname AS url, COUNT(m.id) AS members FROM groups AS g, group_members AS m WHERE m.group = g.id && m.time >= '".$qt."' GROUP BY g.id ORDER BY members DESC LIMIT 15");
$rows = mysql_num_rows($query);
$i = 0;
while($group = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/comunidades/'.$group['url'].'/">'.(strlen($group['name']) > 37 ? substr(htmlspecialchars($group['name']), 0, 40).'...' : htmlspecialchars($group['name'])).'</a> ('.$group['members'].')';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
<br />
<div class="box_title">
  <div class="box_txt">Temas con m&aacute;s puntos <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/temas/puntos/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_1_2">
<?php
$query = mysql_query("SELECT p.id AS id, p.title AS title, g.urlname AS url, SUM(gp.pnum) AS points FROM group_posts AS p, groups AS g, group_points AS gp WHERE g.id = p.group && gp.post = p.id && gp.time >= '".$qt."' GROUP BY p.id ORDER BY points DESC LIMIT 15") or die(mysql_error());
$rows = mysql_num_rows($query);
$i = 0;
while($post = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/comunidades/'.$post['url'].'/'.$post['id'].'/'.url($post['title']).'">'.(strlen($post['title']) > 37 ? substr(htmlspecialchars($post['title']), 0, 40).'...' : htmlspecialchars($post['title'])).'</a> ('.$post['points'].')';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
</div><!--izq-->
<div class="tops" id="centro">
<div class="box_title">
  <div class="box_txt">Comunidades con m&aacute;s temas <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/comunidades/temas/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_2_1">
<?php
$query = mysql_query("SELECT g.name AS name, g.urlname AS url, COUNT(p.id) AS posts FROM groups AS g, group_posts AS p WHERE p.group = g.id && p.time >= '".$qt."' GROUP BY g.id ORDER BY posts DESC LIMIT 15");
$rows = mysql_num_rows($query);
$i = 0;
while($group = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/comunidades/'.$group['url'].'/">'.(strlen($group['name']) > 37 ? substr(htmlspecialchars($group['name']), 0, 40).'...' : htmlspecialchars($group['name'])).'</a> ('.$group['posts'].')';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
<br />
<div class="box_title">
  <div class="box_txt">Temas con m&aacute;s respuestas <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/temas/respuestas/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_2_2">
<?php
$query = mysql_query("SELECT p.id AS id, p.title AS title, g.urlname AS url, COUNT(c.id) AS comments FROM group_posts AS p, groups AS g, group_comments AS c WHERE g.id = p.group && c.post = p.id && c.time >= '".$qt."' GROUP BY p.id ORDER BY comments DESC LIMIT 15") or die(mysql_error());
$rows = mysql_num_rows($query);
$i = 0;
while($post = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/comunidades/'.$post['url'].'/'.$post['id'].'/'.url($post['title']).'">'.(strlen($post['title']) > 37 ? substr(htmlspecialchars($post['title']), 0, 40).'...' : htmlspecialchars($post['title'])).'</a> ('.$post['comments'].')';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
</div><!--centro-->
<div class="tops" id="derecha">
<div class="box_title">
  <div class="box_txt">Comunidades con m&aacute;s respuestas <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/comunidades/respuestas/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_3_1">
<?php
$query = mysql_query("SELECT g.name AS name, g.urlname AS url, COUNT(c.id) AS comments FROM groups AS g, group_comments AS c WHERE c.group = g.id && c.time >= '".$qt."' GROUP BY g.id ORDER BY comments DESC LIMIT 15");
$rows = mysql_num_rows($query);
$i = 0;
while($group = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/comunidades/'.$group['url'].'/">'.(strlen($group['name']) > 37 ? substr(htmlspecialchars($group['name']), 0, 40).'...' : htmlspecialchars($group['name'])).'</a> ('.$group['comments'].')';
if($i != $rows) { echo '<br />'; }
}
?>
</div>
<br />
<div class="box_title">
  <div class="box_txt">Temas con m&aacute;s visitas <?=$tt;?></div>
  <div class="box_rss">
  	<a href="/rss/top/temas/visitas/<?=$tf;?>/">
    <span class="systemicons sRss"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="bc_3_2">
<?php
$query = mysql_query("SELECT p.id AS id, p.title AS title, g.urlname AS url, COUNT(v.id) AS visits FROM group_posts AS p, groups AS g, group_visits AS v WHERE g.id = p.group && v.post = p.id && v.time >= '".$qt."' GROUP BY p.id ORDER BY visits DESC LIMIT 15") or die(mysql_error());
$rows = mysql_num_rows($query);
$i = 0;
while($post = mysql_fetch_array($query)) {
$i++;
echo '<b>'.$i.'</b> - <a href="/comunidades/'.$post['url'].'/'.$post['id'].'/'.url($post['title']).'">'.(strlen($post['title']) > 37 ? substr(htmlspecialchars($post['title']), 0, 40).'...' : htmlspecialchars($post['title'])).'</a> ('.$post['visits'].')';
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