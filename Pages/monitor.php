<?php
if(!defined($config['define'])) { die; }
if(!isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}
// GEGEGEGEGE
$ex = explode(',', $currentuser['notificate']);
foreach($ex as $v) {
	$e = explode(':', $v);
	$filter[$e[0]] = ($e[1] == '1' ? true : false);
}
?>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
<div id="centroDerecha" style="width:705px;float:left;">
	<div class="">
		<h2 style="font-size:15px">&Uacute;ltimas notificaciones<!--<span style="float:right;cursor:pointer;font-size:12px;font-weight:normal;" onclick="notis_markasread();">Marcas como vistas</span>--></h2>
	</div>
	<ul class="notification-detail listado-content">
    <?php
	$query = mysql_query("SELECT * FROM `notifications` WHERE user = '".$currentuser['id']."' ORDER BY time DESC LIMIT 50");
	while($noti = mysql_fetch_assoc($query)) {
		if($noti['who'] != '0') {
			list($n, $a) = mysql_fetch_row(mysql_query("SELECT nick, avatar FROM `users` WHERE id = '".$noti['who']."'"));
		}
		echo '<li class="com-thread'.($noti['readed'] == '0' ? ' unread' : '').'">
		<div class="avatar-box"'.($noti['who']=='0' ? ' style="margin-right:5px;"' : '').'>'.($noti['who'] != '0' ? '<a href="/perfil/'.$n.'/"><img src="/avatares/32/'.$a.'" width="32" height="32" /></a>' : '<span class="medalla '.$noti['img'].'-big"></span>').'</div>
		<div class="notification-info"'.($noti['who']=='0' ? ' style="float:none;"' : '').'><span>';
		if($noti['who'] != '0') {
			echo '<a href="/perfil/'.$n.'/">'.$n.'</a> ';
		}
		echo '<span class="time" title="'.udate('d.m.Y', $comment['time']).' a las '.udate('h:s', $comment['time']).' hs.">'.($noti['who'] == '0' ? timeFrom($noti['time']) : strtolower(timeFrom($noti['time']))).'</span></span><span class="action"><span class="icon-'.($noti['who'] == '0' ? 'medallas' : 'noti').' '.$noti['img'].'"></span>'.$noti['text'].'</span></div>
		</li>';
	}
	?>
	</ul>
</div>
 
<div id="post-izquierda" style="width:210px;float:right">
	<div class="categoriaList">
		<h6>Filtrar Actividad<img src="/images/loading.gif" width="16" height="16" id="filter_loading" style="display:none;margin-right:6px;float:right;" /></h6>
		<ul>
			<li><strong>Mis Posts</strong></li>
			<li><label><span class="icon-noti favoritos-n"></span><input type="checkbox" onclick="notis_filter(1, this.checked);"<?=($filter[1] ? ' checked' : '');?> /> Favoritos</label></li>
			<li><label><span class="icon-noti comentarios-n"></span><input type="checkbox" onclick="notis_filter(2, this.checked);"<?=($filter[2] ? ' checked' : '');?> /> Comentarios</label></li>
			<li><label><span class="icon-noti puntos-n"></span><input type="checkbox" onclick="notis_filter(3, this.checked);"<?=($filter[3] ? ' checked' : '');?> /> Puntos</label></li>
            <li><label><span class="icon-medallas medalla-oro"></span><input type="checkbox" onblur="notis_filter(4, this.checked);"<?=($filter[4] ? ' checked' : '');?> /> Medallas</label></li>
			<li><strong>Usuarios que sigo</strong></li>
			<li><label><span class="icon-noti follow-n"></span><input type="checkbox" onclick="notis_filter(5, this.checked);"<?=($filter[5] ? ' checked' : '');?> /> Nuevos</label></li>
			<li><label><span class="icon-noti post-n"></span><input type="checkbox" onclick="notis_filter(6, this.checked);"<?=($filter[6] ? ' checked' : '');?> /> Posts</label></li>
			<li><label><span class="icon-noti comunidades-n"></span><input type="checkbox" onclick="notis_filter(7, this.checked);"<?=($filter[7] ? ' checked' : '');?> /> Temas</label></li>
			<li><label><span class="icon-noti recomendar-p"></span><input type="checkbox" onclick="notis_filter(8, this.checked);"<?=($filter[8] ? ' checked' : '');?>  /> Recomendaciones</label></li>
			<li><strong>Posts que sigo</strong></li>
			<li><label><span class="icon-noti comentarios-n-b"></span><input type="checkbox" onclick="notis_filter(9, this.checked);"<?=($filter[9] ? ' checked' : '');?> /> Comentarios</label></li>
			<li><strong>Comunidades</strong></li>
			<li><label><span class="icon-noti comunidades-n"></span><input type="checkbox" onclick="notis_filter(10, this.checked);"<?=($filter[10] ? ' checked' : '');?> /> Temas</label></li>
			<li><label><span class="icon-noti comentarios-n-g"></span><input type="checkbox" onclick="notis_filter(11, this.checked);"<?=($filter[11] ? ' checked' : '');?>  /> Respuestas</label></li>
		</ul>
	</div>
	<div class="categoriaList estadisticasList">
		<h6>Estad&iacute;sticas</h6>
		<ul>
			<li class="clearfix"><a href="/monitor/seguidores"><span class="floatL">Seguidores</span><span class="floatR number"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$currentuser['id']."'"));?></span></a></li>
			<li class="clearfix"><a href="/monitor/siguiendo"><span class="floatL">Usuarios</span><span class="floatR number"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && user = '".$currentuser['id']."'"));?></span></a></li>
			<li class="clearfix"><a href="/monitor/posts"><span class="floatL">Posts</span><span class="floatR number"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '1' && user = '".$currentuser['id']."'"));?></span></a></li>
			<li class="clearfix"><a href="/monitor/comunidades"><span class="floatL">Comunidades</span><span class="floatR number"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '3' && user = '".$currentuser['id']."'"));?></span></a></li>
			<li class="clearfix"><a href="/monitor/temas"><span class="floatL">Temas</span><span class="floatR number"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '4' && user = '".$currentuser['id']."'"));?></span></a></li>
			<li class="clearfix"><a href="/perfil/<?=$currentuser['nick'];?>/medallas"><span class="floatL">Medallas</span><span class="floatR number"><?=mysql_num_rows(mysql_query("SELECT id FROM `medals` WHERE user = '".$currentuser['id']."'"));?></span></a></li>
		</ul>
	</div>
</div>
<div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>