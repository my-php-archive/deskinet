<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
?>
<div id="cuerpocontainer">
<div id="izquierda">
<div id="lp">
<div class="box_title" style="_width:380px">
<div class="box_txt ultimos_posts">&Uacute;ltimos posts</div>
<div class="box_rss">
	<a href="/rss/ultimos-post">
		<span style="position:relative;z-index:87" class="systemicons sRss"></span>
	</a>
</div>
</div>
<!-- inicio posts -->
<div class="box_cuerpo">
<ul>
<?php
$cat = mysql_clean($_GET['cat']);
if(!$_GET['cat']) { unset($cat); }
if($cat != 'novatos') {
if(mysql_num_rows($query = mysql_query("SELECT id FROM categories WHERE urlname = '".$cat."'"))) {
	$f = mysql_fetch_array($query);
	$catn = $f['id'];
	unset($query, $f);
}
}
$q = "SELECT p.id, p.title, p.private, p.cat, p.sticky FROM posts AS p, users AS u WHERE u.id = p.author && u.rank ".($cat == 'novatos' ? '=' : '!=')." '0' && revision = '0'";
if(isset($catn)) {
	$q .= " && p.cat = '".$catn."'";
}

// PPPP
$pn = $_GET['pn'];
if(!$pn || $pn < 0 || !eregi('^[0-9]{1,}$', $pn)) {
$pn = 0;
}
// PPPPP

if($pn == 0) { $sp = "SELECT p.id, p.title, p.cat, p.sticky FROM posts AS p, users AS u WHERE u.id = p.author && p.sticky = '1' && u.rank ".($cat == 'novatos' ? '=' : '!=')." '0'".($catn ? " && p.cat = '".$catn."'" : '')." ORDER BY p.sticky_time DESC, p.time DESC, p.id DESC";
$sr = mysql_num_rows(mysql_query($sp));
} else {
$sr = 0;
}

// STICKY
if($pn == 0 && (!isset($cat) || $cat == 'novatos') && $sr) {
$posts = mysql_query($sp) or die(mysql_error());
while($post = mysql_fetch_array($posts)) {
	$qc = mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'") or die(mysql_error());
	$pcat = mysql_fetch_array($qc);
	echo '<li class="categoriaPost sticky">'."\n";
	echo '<a href="/posts/'.$pcat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html" title="'.htmlspecialchars($post['title']).'" alt="'.htmlspecialchars($post['title']).'" class="categoriaPost '.$pcat['urlname'].'">'.(strlen($post['title']) >= 45 ? substr(htmlspecialchars($post['title']), 0, 42).'...' : htmlspecialchars($post['title'])).'</a>'."\n";
	echo "</li>\n";
}
}

// PPPP
$tp = ceil((mysql_num_rows(mysql_query($q))+$sr)/60);
if($pn > $tp) {
$pn = $tp;
}
// PPPP

$posts = mysql_query($q." ORDER BY time DESC, id DESC LIMIT ".($pn*60).",".(($pn*60)+(60-$sr))) or die(mysql_error());
while($post = mysql_fetch_array($posts)) {
	$qc = mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'") or die(mysql_error());
	$pcat = mysql_fetch_array($qc);
	echo '<li class="categoriaPost '.$pcat['urlname'].'">'."\n";
	echo '<a href="/posts/'.$pcat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html" title="'.htmlspecialchars($post['title']).'" alt="'.htmlspecialchars($post['title']).'" class="'.($post['private'] == 1 ? 'categoriaPost privado' : '').'">'.(strlen($post['title']) >= 48 ? substr(htmlspecialchars($post['title']), 0, 45).'...' : htmlspecialchars($post['title'])).'</a>'."\n";
	echo "</li>\n";
}
?>
</ul>
<br clear="left" />
<?php
if($pn != $tp) {
echo '<div align="center" class="size13">'."\n";
if($pn != 0) { echo '<a href="'.($cat ? '/posts/'.$cat : '').($pn == 1 ? '/' : '/pagina'.($pn-1)).'">&laquo; Anterior</a>'; }
if($pn != 0 && $pn != ($tp-1)) { echo '&nbsp;'; }
if($pn < ($tp-1)) { echo '<a href="'.($cat ? '/posts/'.$cat : '').'/pagina'.($pn+1).'">Siguiente &raquo;</a>'; }
echo "\n</div>\n";
}
?>
</div>
<!-- fin posts -->
</div> <!-- lp -->
</div><!-- izq -->
<div id="centro">
<div id="searchBox"><!-- buscador -->
	<div class="box_title">
		<span class="box_txt home_buscador">Buscador</span>
		<span class="box_rss"></span>
	</div>
	<div class="box_cuerpo">
		<img src="/images/InputSleft_2.gif" class="leftIbuscador" />
		<input type="text" id="ibuscadorq" class="ibuscador onblur_effect" onkeypress="if(event.keyCode == 16) { document.location = '/posts/buscador/' + (document.getElementById('swg').checked ? 'google' : '<?=$config['script_name2'];?>') + '/' + this.value; }" onfocus="if(this.value == 'Buscar') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Buscar'; }" value="Buscar" title="Buscar" />
		<input type="button" onclick="document.location = '/posts/buscador/<?=$config['script_name2'];?>/?q=' + document.getElementById('ibuscadorq').value;" align="top" vspace="2" hspace="10" alt="Buscar" class="bbuscador" title="Buscar" />
			<div style="clear:both"></div>
		<div style="margin: 5px 5px 0 0; color:#878787;font-weight:bold; ">
			<div style="clear:both"></div>
		</div>
		<div style="clear:both"></div>
		</div>
</div>
<br class="space" />
<div id="statisticsBox"><!-- estadisticas -->
<div class="box_title">
<span class="box_txt estadisticas">Estad&iacute;sticas</span>
<span class="box_rss"></span>
</div>
<div class="box_cuerpo">
<table cellpadding="0" cellspacing="0" width="100%" align="left">
<tr>
<td width="50%" align="left"><a href="/usuarios-online/" class="usuarios_online"><?=$pstats['total_users'];?> usuarios online</a></td>
<td width="50%" align="left"><?=mysql_num_rows(mysql_query("SELECT * FROM `users`"));?> miembros registrados</td>
</tr>
<tr>
<td width="50%" align="left"><?=mysql_num_rows(mysql_query("SELECT * FROM `posts`"));?> posts</td>
<td width="50%" align="left"><?=mysql_num_rows(mysql_query("SELECT * FROM `comments`"));?> comentarios</td>
</tr>
</table>
<div style="clear:both;"></div>
</div>
</div>
<br class="space" />
<!--est-->
<div id="lastCommBox">
<div class="box_title">
  <div class="box_txt ultimos_comentarios">&Uacute;ltimos comentarios</div>
  <div class="box_rss">
    <a href="#" class="size9" onclick="update_last_comments('<?=$cat;?>');return false;">
      <span class="systemicons actualizar"></span>
    </a>
  </div>
</div>
<div class="box_cuerpo" id="ult_comm">
<? /*$cat*/ include('ajax/lastcomments.php'); ?>
</div>
</div>
<!--otro-->
<br class="space" />
<div id="wpt">
<div class="box_title">
<div class="box_txt tops_posts_semana">TOPs posts de la semana <a href="/top/" class="size9">(Ver m&aacute;s)</a></div>
<div class="box_rss">
  <a href="/rss/top/posts/puntos/semana/">
    <span class="systemicons sRss"></span>
  </a>
</div>
</div>
<div class="box_cuerpo tops_posts_semana" style="padding:0pt;" id="box_c_posts"><?php $topt = '1'; /* $cat = novatos/nonovatos */ include('Pages/tops.php'); ?><div style="clearBoth"></div></div>
</div>
<!--otro-->
<br class="space" />
<div id="umt">
<div class="box_title">
<div class="box_txt tops_usuarios">Usuarios TOPs - &uacute;ltimos 30 d&iacute;as <a href="/top/" class="size9">(Ver m&aacute;s)</a></div>
<div class="box_rss">
  <a href="/rss/top/usuarios/puntos/mes">
    <span class="systemicons sRss"></span>
  </a>
</div>
</div>
<div class="box_cuerpo tops_usuarios" style="padding:0pt;" id="box_c_users"><?php $topt = '2'; /* $cat = novatos/nonovatos */ include('Pages/tops.php'); ?><div style="clearBoth"></div></div>
</div>
<!--otro-->
<br class="space" />
<div id="tags">
<div class="box_title">
<div class="box_txt tags-cloud"><a href="/nube-de-tags/">TOP TAGs</a></div>
<div class="box_rss"></div>
</div>
<div class="box_cuerpo tags_cloud"><?php include('Pages/tagscloud.php'); ?><div class="clearBoth"></div></div>
</div>
</div> <!-- centro -->
<div id="derecha">
<div id="publi-der">
<div class="box_title">
<div class="box_txt ads">Publicidad</div>
<div class="box_rss"></div>
</div>
<div class="box_cuerpo ads">PUBLI!</div>
</div>
</div><!-- derecha -->
<div style="clear:both"></div>
</div> <!-- cuerpocontainer -->