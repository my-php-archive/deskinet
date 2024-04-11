<?php
if(!$_POST['title'] || !$_POST['message']) { die('ERROR PROVOCADO POR EL USUARIO'); }
include('../config.php');
include('../functions.php');
$_POST['message'] = urldecode($_POST['message']); // SAY :S!
?>		
<div id="post-izquierda">
<div class="box_title">
<div class="box_txt post_autor">Posteado por:</div>
<div class="box_rss"><a href="/rss/posts-usuario/<?=$currentuser['nick'];?>" target="_blank"><span class="systemicons sRss"></span></a></div></div>

<div class="box_perfil"><a href="/perfil/<?=$currentuser['nick'];?>" target="_blank"><img style="margin: auto; display: block" title="Ver perfil de <?=$currentuser['nick'];?>" border="0" alt="Ver perfil de <?=$currentuser['nick'];?>" src="<?=$currentuser['avatar'];?>" width="120" height="120" onerror="error_avatar(this);"></a> <b class="txt"><a title="Ver perfil de <?=$currentuser['nick'];?>" href="/perfil/<?=$currentuser['nick'];?>" target="_blank"><?=$currentuser['nick'];?></a></b> <br clear="left"><?=rankName($currentuser['rank']);?><br clear="left"> 
<span style="position:relative;"><img src="/images/space.gif" width="16" height="16" style="margin-right:2px;display:inline;" class="systemicons rango<?=$currentuser['rank'];?>" title="<?=rankName($currentuser['rank']);?>" /><img src="/images/space.gif" width="16" height="16" style="margin-right:2px;display:inline;" class="systemicons sexo<?=($currentuser['gender'] == 1 ? 'M' : 'F');?>" title="<?=($currentuser['gender'] == 1 ? 'Hombre' : 'Mujer');?>" /><img src="/images/flags/<?=numtoabbr($currentuser['country']);?>.png" width="16" height="11" style="display:inline;margin-bottom:2px;" alt="<?=numtocname($currentuser['country']);?>" title="<?=numtocname($currentuser['country']);?>" /></span>
<br clear="left">
<hr>
<b class="txt_post"><?=mysql_num_rows(mysql_query("SELECT * FROM `posts` WHERE author = '".$currentuser['id']."'"));?> posts</b><br clear="left"><b class="txt_post"><a href="/comentarios/<?=$currentuser['nick'];?>" target="_blank"><?=mysql_num_rows(mysql_query("SELECT * FROM `comments` WHERE author = '".$currentuser['id']."'"));?> comentarios</a></b><br clear="left"><b class="txt_post"><?php
				$f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE user_to = '".$currentuser['id']."'"));
				if(!empty($f['tp'])) {
					echo $f['tp'];
				} else {
					echo '0';
				}
				?> puntos</b><br clear="left">
<hr>
<img title="Enviar mensaje a <?=$currentuser['nick'];?>" border="0" alt="Enviar mensaje a <?=$currentuser['nick'];?>" align="absmiddle" src="/images/msg.gif" height="16" widht="16"> <a title="Enviar mensaje a <?=$currentuser['nick'];?>" href="/mensajes/para/<?=$currentuser['nick'];?>/" target="_blank">Enviar mensaje</a>
<hr>
</div></div>
<div id="post-centro">
<div class="box_title">
<div class="box_txt post_titulo"><?=htmlspecialchars($_POST['title']);?></div>
<div class="box_rrs">
<div class="box_rss"></div></div></div>
<div style="line-height: 1.4em; font-size: 13px" class="box_cuerpo"><?=bbcode($_POST['message']);?></div></div>
<div style="clear: both"></div>
