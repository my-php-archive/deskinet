<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
/*if(mysql_num_rows($q = mysql_query("SELECT `text` FROM `mininews` ORDER BY RAND() LIMIT 1"))) {
$n = mysql_fetch_array($q);
?>
<div id="mensaje-top">
<div class="msgtxt"><?=bbcode($n['text']);?></div>
</div>
<? } */?>
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
if(!$pn || $pn < 0 || !ctype_digit($pn)) {
$pn = 0;
}
// PPPPP

if($pn == 0) {
  $sp = "SELECT p.id, p.title, p.cat, p.sticky, p.superstick FROM posts AS p, users AS u WHERE u.id = p.author && (p.sticky = '1' || superstick != '0') && u.rank ".($cat == 'novatos' ? '=' : '!=')." '0'".($catn ? " && p.cat = '".$catn."'" : '')." ORDER BY p.superstick DESC, p.sticky_time DESC, p.time DESC, p.id DESC";
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
	echo '<li class="categoriaPost sticky'.($post['superstick'] != '0' ? ' patrocinado' : '').'">';
	echo '<a href="/posts/'.$pcat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html" title="'.htmlspecialchars($post['title']).'" alt="'.htmlspecialchars($post['title']).'" class="categoriaPost '.$pcat['urlname'].'">'.(strlen($post['title']) >= 45 ? substr(htmlspecialchars($post['title']), 0, 42).'...' : htmlspecialchars($post['title'])).'</a>'."\n";
	echo '</li>';
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
	echo '</li>';
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
echo '</div>';
}
?>
</div>
<!-- fin posts -->
</div> <!-- lp -->
</div><!-- izq -->
<div id="centro">
<div class="new-search posts"><!-- buscador -->
	<div class="bar-options">
		<ul class="clearfix">
            <li class="posts-tab selected"><a>Posts</a></li>
			<li class="comunidades-tab"><a>Comunidades</a></li>
			<li class="temas-tab"><a>Temas</a></li>
					</ul>
	</div>
	<div class="search-body clearfix">
		<form name="search" action="buscador">
			<div class="input-search-left"></div>
			<input id="new-search-input-q" class="input-search-middle" name="q" type="text" value="Buscar" autocomplete="off" onfocus="this.style.color='#000';if(this.value=='Buscar'){this.value='';}" onblur="this.style.color='#999';if(this.value==''){this.value='Buscar';}" />
            <div class="input-search-right"></div>
			<a class="btn-search-home"></a>
		</form>
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
<td width="50%" align="left"><?=mysql_num_rows(mysql_query("SELECT * FROM `users`"));?> miembros</td>
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
<?php $topt = '2'; /* $cat = novatos/nonovatos */ include('Pages/tops.php'); ?>
<!--otro-->
<?php $topt = 1; include('Pages/tops.php'); ?>
<!--otro-->
<br class="space" />
<div id="tags">
<div class="box_title">
<div class="box_txt tags-cloud"><a href="/nube-de-tags/">TOP TAGs</a></div>
<div class="box_rss"></div>
</div>
<div class="box_cuerpo tags_cloud"><a href="/tags/Argentina" title="58028 post con el tag Argentina"  style="font-size: 14px;padding-right:1.3%" rel="tag">Argentina</a> <a href="/tags/Rapidshare" title="77119 post con el tag Rapidshare"  style="font-size: 17px;padding-right:1.3%" rel="tag">Rapidshare</a> <a href="/tags/Windows" title="48155 post con el tag Windows"  style="font-size: 13px;padding-right:1.3%" rel="tag">Windows</a> <a href="/tags/anime" title="25977 post con el tag anime"  style="font-size: 10px;padding-right:1.3%" rel="tag">anime</a> <a href="/tags/de" title="22603 post con el tag de"  style="font-size: 9px;padding-right:1.3%" rel="tag">de</a> <a href="/tags/descarga" title="52759 post con el tag descarga"  style="font-size: 13px;padding-right:1.3%" rel="tag">descarga</a> <a href="/tags/descargar" title="49471 post con el tag descargar"  style="font-size: 13px;padding-right:1.3%" rel="tag">descargar</a> <a href="/tags/descargas" title="26130 post con el tag descargas"  style="font-size: 10px;padding-right:1.3%" rel="tag">descargas</a> <a href="/tags/discografia" title="24215 post con el tag discografia"  style="font-size: 10px;padding-right:1.3%" rel="tag">discografia</a> <a href="/tags/download" title="34589 post con el tag download"  style="font-size: 11px;padding-right:1.3%" rel="tag">download</a> <a href="/tags/dvd" title="31810 post con el tag dvd"  style="font-size: 11px;padding-right:1.3%" rel="tag">dvd</a> <a href="/tags/dvdrip" title="38335 post con el tag dvdrip"  style="font-size: 11px;padding-right:1.3%" rel="tag">dvdrip</a> <a href="/tags/espa&#241;ol" title="47747 post con el tag espa&#241;ol"  style="font-size: 13px;padding-right:1.3%" rel="tag">espa&#241;ol</a> <a href="/tags/fotos" title="41671 post con el tag fotos"  style="font-size: 12px;padding-right:1.3%" rel="tag">fotos</a> <a href="/tags/full" title="55399 post con el tag full"  style="font-size: 14px;padding-right:1.3%" rel="tag">full</a> <a href="/tags/futbol" title="55133 post con el tag futbol"  style="font-size: 14px;padding-right:1.3%" rel="tag">futbol</a> <a href="/tags/gratis" title="41573 post con el tag gratis"  style="font-size: 12px;padding-right:1.3%" rel="tag">gratis</a> <a href="/tags/historia" title="20173 post con el tag historia"  style="font-size: 9px;padding-right:1.3%" rel="tag">historia</a> <a href="/tags/humor" title="49234 post con el tag humor"  style="font-size: 13px;padding-right:1.3%" rel="tag">humor</a> <a href="/tags/imagenes" title="70603 post con el tag imagenes"  style="font-size: 16px;padding-right:1.3%" rel="tag">imagenes</a> <a href="/tags/juego" title="53366 post con el tag juego"  style="font-size: 13px;padding-right:1.3%" rel="tag">juego</a> <a href="/tags/juegos" title="118487 post con el tag juegos"  style="font-size: 22px;padding-right:1.3%" rel="tag">juegos</a> <a href="/tags/mediafire" title="26317 post con el tag mediafire"  style="font-size: 10px;padding-right:1.3%" rel="tag">mediafire</a> <a href="/tags/megaupload" title="56337 post con el tag megaupload"  style="font-size: 14px;padding-right:1.3%" rel="tag">megaupload</a> <a href="/tags/metal" title="44682 post con el tag metal"  style="font-size: 12px;padding-right:1.3%" rel="tag">metal</a> <a href="/tags/mp3" title="41496 post con el tag mp3"  style="font-size: 12px;padding-right:1.3%" rel="tag">mp3</a> <a href="/tags/musica" title="131301 post con el tag musica"  style="font-size: 24px;padding-right:1.3%" rel="tag">musica</a> <a href="/tags/online" title="36491 post con el tag online"  style="font-size: 11px;padding-right:1.3%" rel="tag">online</a> <a href="/tags/pc" title="78637 post con el tag pc"  style="font-size: 17px;padding-right:1.3%" rel="tag">pc</a> <a href="/tags/pelicula" title="33339 post con el tag pelicula"  style="font-size: 11px;padding-right:1.3%" rel="tag">pelicula</a> <a href="/tags/peliculas" title="65770 post con el tag peliculas"  style="font-size: 15px;padding-right:1.3%" rel="tag">peliculas</a> <a href="/tags/programas" title="40089 post con el tag programas"  style="font-size: 12px;padding-right:1.3%" rel="tag">programas</a> <a href="/tags/rock" title="66707 post con el tag rock"  style="font-size: 15px;padding-right:1.3%" rel="tag">rock</a> <a href="/tags/software" title="20176 post con el tag software"  style="font-size: 9px;padding-right:1.3%" rel="tag">software</a> <a href="/tags/taringa" title="50056 post con el tag taringa"  style="font-size: 13px;padding-right:1.3%" rel="tag">turinga</a> <a href="/tags/video" title="49829 post con el tag video"  style="font-size: 13px;padding-right:1.3%" rel="tag">video</a> <a href="/tags/videos" title="47025 post con el tag videos"  style="font-size: 13px;padding-right:1.3%" rel="tag">videos</a> <a href="/tags/xp" title="21211 post con el tag xp"  style="font-size: 9px;padding-right:1.3%" rel="tag">xp</a> <a href="/tags/2008" title="34121 post con el tag 2008"  style="font-size: 11px;padding-right:1.3%" rel="tag">2008</a> <a href="/tags/2009" title="99104 post con el tag 2009"  style="font-size: 20px;padding-right:1.3%" rel="tag">2009</a><div class="clearBoth"></div></div>
</div>
</div> <!-- centro -->
<div id="derecha">
		<?php
		getLocation($cCity, $cCoords);
		getWeather($cCity, $weather, true);
		?>
		<div class="climaHome clearbeta">

		<div class="clima-h-city">
			<a href="/clima" style="color:#000;text-decoration:none">El clima en <?=$cCity;?></a>
			<? if(isLogged()) { echo '<a href="/cuenta"><img src="/images/edit_c.png" class="changec" /></a>'; } ?>
            </div>
		<div class="clima-h-data" onclick="$('.climaH-ext').toggle()">
		<img style="vertical-align:top" src="/images/clima/i_0001.png" alt="" /> <strong><span style="color:#666">Temp</span> <?=$weather['current']['temp'];?>&deg; <span style="color:#666"> - Hum</span> <?=$weather['current']['hum'];?></strong>

		<a class="expand"></a>
		<div class="climaH-ext" style="display: none">
		    <ul>
			    <li>
			    	<div class="floatL" style="font-weight:normal;text-transform:uppercase;color:#333">Ma&ntilde;ana</div>
				    <div class="floatR"><img src="/images/clima/i_0001.png" alt="" /> <strong><span style="color:#666">Min</span> <span style="color:#007ADE">13&deg;</span><span style="color:#666"> - Max</span> <span style="color:#F40000">26&deg;</span></strong></div>

			    </li>
			    <li>
			    	<div class="floatL" style="font-weight:normal;text-transform:uppercase;color:#333">Pasado</div>
				    <div class="floatR"><img src="/images/clima/i_0001.png" alt="" /> <strong><span style="color:#666">Min</span> <span style="color:#007ADE">12&deg;</span><span style="color:#666"> - Max</span> <span style="color:#F40000">26&deg;</span></strong></div>

			    </li>
			    <li style="text-align:center;padding-top:7px;background:#f1f1f1"><a href="/clima" style="color:#1571ba;">M&aacute;s informaci&oacute;n sobre el tiempo &raquo;</a></li>
			</ul>
			</div>
		</div>
        <?php
		if(!isLogged()) {
        echo '<div style="border-top:#CCCCCC 1px solid ; text-align:center; padding:4px 3px 3px 3px;margin-top:6px;">
        <a href="/registro/">Registrate para cambiar a tu ciudad</a>
        </div>';
		}
		?>
        </div>
<!--EEEEEEEEEEE-->  <br />
</div> <!-- centro -->
<div id="derecha">
<div id="publi-der">
<div class="box_title">
<div class="box_txt ads">Publicidad</div>
<div class="box_rss"></div>
</div>
<div class="box_cuerpo ads"><center><?=advert('160x600').advert('234x60');?></center></div>
<!--EEEEEEEEEEE-->  <br />
<div class="box_title">
<div class="box_txt ads">Patrocinadores</div>
<div class="box_rss"></div>
</div>
<div class="box_cuerpo">
<img src="http://sexringa.net/images/sexringa.gif" align="absmiddle" widht="16" height="16" hspace="2" vspace="2" /> <a href="http://www.sexringa.net" target="_blank" rel="nofollow">Sexringa!</a>  </br>
<img src="http://turingax.net/images/enlace/turinga-16x16.gif" align="absmiddle" widht="16" height="16" hspace="2" vspace="2" /> <a href="http://www.clasificado-online.net/forum.php" target="_blank" rel="nofollow"><b>Clasificados online</b></a>
</div>
<!--EEEEEEEEEEE-->  <br />
<div class="box_title">
<div class="box_txt ads">Publicidad</div>
<div class="box_rss"></div>
</div>
<div class="box_cuerpo ads"><center><?=advert('160x600');?></center></div>
</div>
</div><!-- derecha -->
<div style="clear:both"></div>
</div> <!-- cuerpocontainer -->