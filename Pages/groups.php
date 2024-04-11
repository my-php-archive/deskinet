<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303

// procesar datos GET, NO USAR $query hasta mostrar posts
$q = "SELECT p.id, p.group, p.title, p.author FROM group_posts AS p, groups AS g WHERE g.id = p.group";
	if($_GET['cat'] && mysql_num_rows($qcat = mysql_query("SELECT id, urlname, name FROM `group_categories` WHERE urlname = '".mysql_clean($_GET['cat'])."'"))) { $cat = mysql_fetch_array($qcat); $q .= "&& g.cat = '".$cat['id']."'"; }
	if(!mysql_num_rows(mysql_query($q))) { $nhp = 'No hay temas'; $pn = 0; $tp = 0; } else {
	$tp = ceil(mysql_num_rows(mysql_query($q))/20);
	if(!$_GET['pn'] || $_GET['pn'] < 1 || !preg_match('/^[0-9]+$/', $_GET['pn'])) { $pn = 1; } else { $pn = $_GET['pn']; }
	if($pn > $tp) { $pn = $tp; }
	$min = ($pn-1)*20;
	$max = $pn+19;
	$query = mysql_query($q." ORDER BY p.time DESC LIMIT ".$min.",".$max) or die($q.mysql_error());
	$while = true;
	} // NR
?>
<div id="cuerpocontainer">
<div class="comunidades">
 
<div class="breadcrump">
<ul>
<li class="first"><?=($cat || $pn ? '<a href="/comunidades/" title="Comunidades">Comunidades</a>' : 'Comunidades');?></li>
<?php
if($cat) { 
	echo '<li>'.(!$nhp ? '<a href="/comunidades/cat/'.$cat['urlname'].'/" title="'.$cat['name'].'">'.$cat['name'].'</a>' : $cat['name']).'</li>';
}
if(!$nhp) { echo '<li>P&aacute;gina '.$pn.'</li>'; }
?>
<li class="last"></li>
</ul>
</div>
 
	<div class="home">
<div id="izquierda">
 
		<div class="crear_comunidad">
		<div class="box_cuerpo" style="background:#FFFFCC;border:#b5b539 1px solid; -moz-border-radius:7px">
			<h3 style="margin:5px 0;">Comunidades</h3>
			<p style="color: #333"><?=$config['script_name'];?> te permite crear tu comunidad para que puedas compartir gustos e intereses con los dem&aacute;s.</p>
			<div class="buttons">
				<input id="a_susc" class="mBtn btnYellow" onclick="location.href='/comunidades/crear/'" value="&iexcl;Crea la tuya! &raquo;" type="button" />
			</div>
		</div>
	</div>
 
			<br class="space">
		<div class="destacadas">
			<div class="box_title">
				<span class="box_txt">Destacadas</span>
				<span class="box_rss"></span>
			</div>
			<div class="box_cuerpo oficial" style="text-align:center">
				<div class="avaComunidad">
                <?php
				$cd = mysql_fetch_array(mysql_query("SELECT name, urlname, avatar FROM `groups` ORDER BY RAND() DESC LIMIT 1"));
					echo '<a href="/comunidades/'.$cd['urlname'].'/"><img class="avatar" src="'.htmlspecialchars($cd['avatar']).'" onerror="error_avatar(this);" alt="'.$cd['urlname'].'" title="'.htmlspecialchars($cd['name']).'" /></a>
				</div>
				<a href="/comunidades/'.$cd['urlname'].'/" style="font-weight:bold;font-size: 12px;color:#1A7706" title="'.htmlspecialchars($cd['name']).'">'.htmlspecialchars($cd['name']).'</a>';
				?>
			</div>
		</div>
		<br class="space">
		<?=advert('160x600');?>
        </div>
 
<div id="centro">
	<div class="box_title">
		<div class="box_txt ultimos_posts">
			&Uacute;ltimos temas 
		</div>
		<div class="box_rss">
			<a href="/rss/comunidades/" title="&Uacute;ltimos Temas"><span class="systemicons sRss" style="position: relative; z-index: 87;"></span></a>
		</div>
	</div>
	<div class="box_cuerpo">
    <?php
	echo $nhp;
if($while) {
	while($post = mysql_fetch_array($query)) {
		$gro = mysql_fetch_array(mysql_query("SELECT cat, name, urlname, official FROM `groups` WHERE id = '".$post['group']."'"));
		$pcat = mysql_fetch_array(mysql_query("SELECT urlname, name FROM `group_categories` WHERE id = '".$gro['cat']."'"));
		$author = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$post['author']."'"));
		echo '<ul>
				<li class="categoriaCom '.$pcat['urlname'].'">
				<a href="/comunidades/'.$gro['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html" class="titletema" title="'.$pcat['name'].' | '.htmlspecialchars($post['title']).'">'.htmlspecialchars($post['title']).'</a>
				En <a href="/comunidades/'.$gro['urlname'].'/">'.htmlspecialchars($gro['name']).'</a> por <a href="/perfil/'.$author['nick'].'/">'.$author['nick'].'</a>';
        if($gro['official'] == 1) { echo '<img src="/images/oficial.png" alt="Comunidad Oficial" title="Comunidad Oficial" class="comOfi" />'; }
							echo '</li>
			</ul>';
	}
}
	?>
		<br clear="left">
		<div class="paginator" align="center">
        			<?php
					if($cat) { $pcd = 'cat/'.$cat['urlname'].'/'; }
					if($pn > 1) { echo '<div class="floatL"><a href="/comunidades/'.$pcd.'pagina.'.($pn-1).'">&laquo; Anterior</a></div>'; }
					if($pn != $tp) { echo '<div class="floatR"><a href="/comunidades/'.$pcd.'pagina.'.($pn+1).'">Siguiente &raquo;</a></div>'; }
					?>
				<div class="clearBoth"></div>
		</div>
	</div>
</div>
 
<div id="derecha">
	<!-- buscador -->
	<div class="new-search comunidades" style="margin-bottom:0;"><!-- buscador -->
	<div class="bar-options">
		<ul class="clearfix">
            <li class="posts-tab"><a>Posts</a></li>
			<li class="comunidades-tab selected"><a>Comunidades</a></li>
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
	<br class="space">

	<div class="ult_respuestas">
		<div class="box_title">
			<div class="box_txt ultimos_comentarios">&Uacute;ltimas respuestas</div>
			<div class="box_rss">
				<a href="#" onclick="update_last_comments('<?=$cat['id'];?>', true);return false;">
					<span class="systemicons actualizar"></span>
				</a>
			</div>
		</div>
		<div class="box_cuerpo" id="ult_comm">
						<?php
						include('./ajax/group-lastcomments.php');
						?>
		</div>
	</div>
    <?php $topt = '3'; include('./Pages/tops.php'); ?>
		<br class="space">
 
	<div class="ult_comunidades">
		<div class="box_title">
			<div class="box_txt ultimas_comunidades">&Uacute;ltimas Comunidades</div>
			<div class="box_rrs"><span class="box_rss"></span></div>
		</div>
		<div class="box_cuerpo">
			<ul class="listDisc">
							<?php
							$query = mysql_query("SELECT name, urlname FROM `groups` ORDER BY id DESC LIMIT 15");
							while(list($name, $urlname) = mysql_fetch_row($query)) {
								echo '<li><a href="/comunidades/'.$urlname.'/" class="size10">'.$name.'</a></li>';
							}
							?>
						</ul>
			<div style="background:#FFFFCC; border:1px solid #FFCC33; padding:5px;margin:5px 0 0 0;font-weight: bold; text-align:center;-moz-border-radius: 5px">
				<a href="/comunidades/crear/" style="color:#0033CC">&iquest;Qu&eacute; esperas para crear la tuya?</a>
			</div>
		</div>
	</div>
 
</div>
</div>
 
 
</div><div style="clear:both"></div>
</div> <!-- cuerpocontainer -->