<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
// 360 303 303
if(!$_GET['id']) { header('Location: /index.php'); }
if($post === false) {
	include($_SERVER['DOCUMENT_ROOT'].'/post-doesnt-exist.php');
	include($_SERVER['DOCUMENT_ROOT'].'/footer.php');
	die;
//MIERDA DE MENSAJE ELIMINADO
}
if($post['revision'] == '1' && !isAllowedTo('showrevposts')) {
	include($_SERVER['DOCUMENT_ROOT'].'/post-revision.php');
	include($_SERVER['DOCUMENT_ROOT'].'/footer.php');
	die;
}
if($post['private'] == 1 && !isLogged()) {
	include('./Pages/register.php');
    include('./footer.php');
    die;
}
if(!mysql_num_rows(mysql_query("SELECT id FROM `visits` WHERE post = '".$post['id']."' && ip = '".mysql_clean($_SERVER['REMOTE_ADDR'])."'"))) {
	mysql_query("INSERT INTO `visits` (post, ip, time) VALUES ('".$post['id']."', '".mysql_clean($_SERVER['REMOTE_ADDR'])."', '".time()."')");
}
if($post['revision'] == '1') {
	echo '<div id="mensaje-top">
<div class="msgtxt">Este post est&aacute; en revisi&oacute;n por acumulaci&oacute;n de denuncias.</div>
</div>';
}
$post['visits'] = mysql_num_rows(mysql_query("SELECT * FROM `visits` WHERE post = '".$post['id']."'"));
$author = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE id = '".$post['author']."'"));
// BLOCK!
$author['blocked_array'] = (empty($author['blocked']) ? array() : explode(',', $author['blocked']));
$cat = mysql_fetch_array(mysql_query("SELECT * FROM `categories` WHERE id = '".$post['cat']."'"));

?>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
<a name="cielo"></a>
<div class="post-wrapper">
<!-- Perfil -->
	<div class="post-autor vcard">
		<div class="box_title">
			<div class="box_txt post_autor">Posteado por:</div>
			<div class="box_rrs">
				<div class="box_rss">
					<a href="/rss/posts-usuario/<?=$author['nick'];?>/" title="RSS con los post de <?=$author['nick'];?>">
						<span style="position:relative;" class="systemicons sRss"></span>					</a>
				</div> 
			</div>
		</div>
		<div class="box_cuerpo" typeof="foaf:Person">
			<div class="avatarBox" rel="foaf:img">
				<a href="/perfil/<?=$author['nick'];?>/">
					<img src="/avatares/120/<?=$author['avatar'];?>" class="avatar" alt="Ver perfil de <?=$author['nick'];?>" title="Ver perfil de <?=$author['nick'];?>" onerror="error_avatar(this);" />
				</a>
			</div>
			<a rel="dc:creator" property="foaf:nick" class="url fn n" href="/perfil/<?=$author['nick'];?>/">
				<span class="given-name"><?=$author['nick'];?></span>
			</a>
			<br />
			<span class="title"><?=rankName($author['rank']);?></span>
			<br />
            		<span style="position:relative;"><?php
				$query = mysql_query("SELECT time FROM `connected` WHERE user = '".$author['id']."'");
				if(mysql_num_rows($query)) {
					list($oty) = mysql_fetch_row($query);
					$dif = time()-$oty;
					if($dif >= 600) {
						echo '<img src="/images/space.gif" width="16" height="16" style="margin-right:3px;display:inline;" class="systemicons ocupado" title="Ocupado" />';
					} elseif($dif >= 300) {
						echo '<img src="/images/space.gif" width="16" height="16" style="margin-right:3px;display:inline;" class="systemicons ausente" title="Ausente" />';
					} else {
						echo '<img src="/images/space.gif" width="16" height="16" style="margin-right:3px;display:inline;" class="systemicons online" title="Conectado" />';
					}
				} else {
					echo '<img src="/images/space.gif" width="16" height="16" style="margin-right:3px;display:inline;" class="systemicons offline" title="Desconectado" />';
				}
			?><img src="/images/space.gif" width="16" height="16" style="margin-right:3px;display:inline;" class="systemicons rango<?=$author['rank'];?>" title="<?=rankName($author['rank']);?>" /><img src="/images/space.gif" width="16" height="16" style="margin-right:3px;display:inline;" class="systemicons sexo<?=($author['gender'] == 1 ? 'M' : 'F');?>" title="<?=($author['gender'] == 1 ? 'Hombre' : 'Mujer');?>" /><img src="/images/flags/<?=numtoabbr($author['country']);?>.png" width="16" height="11" style="display:inline;margin-bottom:2px;margin-right:5px;" alt="<?=numtocname($author['country']);?>" title="<?=numtocname($author['country']);?>" /><a href="/mensajes/para/<?=$author['nick'];?>/"><img src="/images/space.gif" width="16" height="16" style="display:inline;" class="systemicons messages" title="Enviar mensaje" /></a></span>
							<hr class="divider" />
                            <?php
							$rows = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$author['id']."' && user = '".$currentuser['id']."'"));
                            	echo '<a id="unfollow_user" style="display:'.($rows ? 'block' : 'none').';" class="btn_g unfollow_user" href="'.(isLogged() ? '#" onclick="follow(2, '.$author['id'].', $(this).children(\'span\'), this, true);return false;' : '/registro/').'"><span class="icons unfollow">Dejar de seguir</span></a>
								<a id="follow_user" style="display:'.(!$rows ? 'block' : 'none').';" class="btn_g follow" href="'.(isLogged() ? '#" onclick="follow(2, '.$author['id'].', $(this).children(\'span\'), this);return false;' : '/registro/').'"><span class="icons follow">Seguir Usuario</span></a>';
							?>
						<hr class="divider"/>
			<div class="metadata-usuario">
            	<span class="nData" id="numf_user"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$author['id']."'"));?></span>
				<span class="txtData">Seguidores</span>
            
				<span class="nData"><?php
				$f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE user_to = '".$author['id']."'"));
				if(!empty($f['tp'])) {
					echo $f['tp'];
				} else {
					echo '0';
				}
				?></span>
				<span class="txtData">Puntos</span>
 
				<span class="nData"><a style="color: #0196ff" href="/posts/buscador/<?=$config['script_name2'];?>/autor/<?=$author['nick'];?>/" title="Posts de <?=$author['nick'];?>"><?=mysql_num_rows(mysql_query("SELECT * FROM `posts` WHERE author = '".$author['id']."'"));?></a></span>
				<span class="txtData"><a href="/posts/buscador/<?=$config['script_name2'];?>/autor/<?=$author['nick'];?>/" title="Posts de <?=$author['nick'];?>">Posts</a></span>
 
				<span class="nData"><a style="color: #456c00" href="/comentarios/<?=$author['nick'];?>/" title="Comentarios de <?=$author['nick'];?>"><?=mysql_num_rows(mysql_query("SELECT * FROM `comments` WHERE author = '".$author['id']."'"));?></a></span>
				<span class="txtData"><a href="/comentarios/<?=$author['nick'];?>/" title="Comentarios de <?=$author['nick'];?>">Comentarios</a></span>
 
			
			
			</div>
		</div>
 
		<!--<center>
	<iframe width="160" scrolling="NO" height="260" frameborder="0" src="/iframe.html" marginheight="5" marginwidth="0"/></iframe>
     </center>--><br />
<center><?=advert('120x240');?></center>
	</div><!-- Perfil -->

	<!-- Cuerpo -->
	<div class="post-contenedor">
		<div class="post-title">
			<a href="/prev/<?=$post['id'];?>/" class="icons anterior" title="Post Anterior (m&aacute;s viejo)"></a>
			<h1 property="dc:title"><?=htmlspecialchars($post['title']);?></h1>
			<a href="/next/<?=$post['id'];?>/" class="icons siguiente" title="Post Siguiente (m&aacute;s nuevo)"></a>
		</div>
		<div class="post-contenido">
				<?php
			if($currentuser['id'] == $author['id'] || isAllowedTo('stick') || isAllowedTo('deleteposts') || isAllowedTo('editposts')) {
				echo '<div class="floatR">';
				if(isAllowedTo('stick')) {
					$fpt = ($post['sticky'] == 1 ? 'Desfijar' : 'Fijar');
					echo '<a class="btnActions" href="#" onclick="fijar_post('.$post['id'].', \''.$fpt.' Post\'); return false;" title="'.$fpt.' Post">
						<img src="/images/fijar.gif" alt="'.$fpt.'" /> '.$fpt.'
					</a>';
				}
				if(isAllowedTo('deleteposts') || $currentuser['id'] == $author['id']) {
					echo '<a class="btnActions" href="#" onclick="borrar_post('.$post['id'].', '.($post['author'] == $currentuser['id'] ? 'true' : 'false').'); return false;" title="Borrar Post">
						<img src="/images/borrar.png" alt="Borrar" /> Borrar
					</a>';
				}
				if(isAllowedTo('editposts') || $currentuser['id'] == $author['id']) {
					echo '<a class="btnActions" href="/editar-post/'.$post['id'].'/" title="Editar Post">
						<img src="/images/editar.png" alt="Editar" /> Editar
					</a>';
				}
				echo '</div>';
				$atc = '<br style="height:25px;" />';
			}
				?>

								<center>
</center>								
				<span property="dc:content">
				<?=$atc.bbcode($post['message']);?>
                </span>
 
				
								<div style="text-align: right; color:#888; font-size: 14px;margin: 10px 0">
					Compartir en:
					<ul class="post-compartir">
						<li><a href="#" onclick="recommend_post('<?=$post['id'];?>');return false;"><img align="absmiddle" src="/images/taringa_32.png" alt="<?$config=['script_name'];?>" title="<?$config=['script_name'];?>" /></a></li>
						<li><a rel="nofollow" target="_blank" href="http://twitter.com/home?status=Recomiendo este post: http://www.<?=$config['script_url'];?>/posts/<?=$cat['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html"><img id="ctwitter" align="absmiddle" src="/images/twitter_32.png" alt="Twitter" title="Twitter" /></a></li>
						<li><a rel="nofollow" target="_blank" href="http://del.icio.us/post?url=http://www.<?=$config['script_url'];?>/posts/<?=$cat['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html"><img id="cdelicious" align="absmiddle" src="/images/delicious_32.png" alt="Delicious" title="Delicious" /></a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.facebook.com/share.php?u=http://www.<?=$config['script_url'];?>/posts/<?=$cat['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html"><img id="cfacebook" align="absmiddle" src="/images/facebook_32.png" alt="Facebook" title="Facebook" /></a></li>
						<li><a rel="nofollow" target="_blank" href="http://digg.com/submit?phase=2&url=http://www.<?=$config['script_url'];?>/posts/<?=$cat['urlname'];?>/<?=$post['id'];?>/<?=url($post['title']);?>.html"><img id="cdigg" align="absmiddle" src="/images/digg_32.png" alt="Digg" title="Digg" /></a></li>
						<li><a rel="nofollow" target="_blank" href="/recomendar/<?=$post['id'];?>/"><img id="cemail" alt="" title="Enviar a un amigo" align="absmiddle" src="/images/email_32.png" /></a></li>
					</ul>
				</div>
				
									<div class="banner 728x90"><?=advert('728x90');?></div>
										</div><!-- Cuerpo -->
		<div class="post-metadata floatL">
			<div style="padding: 12px">
			<div id="mensajes_div" class="mensajes" style="display:none"></div>
            <?php
			if((isLogged() && ((int) $currentuser['currentpoints']) > 0 && $currentuser['id'] != $author['id']) && (($currentuser['rank'] > 0) || ($currentuser['rank'] == 0 && $author['rank'] == 0))) {
				?>
					<div class="dar-puntos" id="dar_puntos">
				<span>Dar Puntos:</span> <? $m = min(10, ((int) $currentuser['currentpoints'])); for($i=1;$i<=$m;$i++) { echo '<a href="#" onclick="vote_post('.$i.', '.$post['id'].');return false;">'.$i.'</a>'; if($i != $m) { echo ' - '; } } ?> (de <?=$currentuser['currentpoints'];?> Disponibles)
			</div>
			<hr class="divider" />
            <? } ?>
					<div class="post-acciones">
			<ul>
            <?php
			$rows = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE user = '".$currentuser['id']."' && what = '1' && who = '".$post['id']."'"));
				echo '<li id="unfollow_post" style="display:'.($rows ? 'block' : 'none').';"><a class="btn_g unfollow_user_post" href="'.(isLogged() ? '#" onclick="follow(1, '.$post['id'].', $(this).children(\'span\'), $(this).parent(\'li\'), true);return false;' : '/registro/').'"><span class="icons unfollow">Dejar de seguir</span></a></li>
				<li id="follow_post" style="display:'.(!$rows ? 'block' : 'none').';"><a class="btn_g follow_post" href="'.(isLogged() ? '#" onclick="follow(1, '.$post['id'].', $(this).children(\'span\'), $(this).parent(\'li\'));return false;' : '/registro/').'"><span class="icons follow_post follow">Seguir Post</span></a></li>';
			?>
				<li><a class="btn_g" href="<?=(isLogged() ? '#" onclick="add_to_favorites('.$post['id'].');return false;' : '/registro/');?>"><span class="icons agregar_favoritos">Agregar a Favoritos</span></a></li>
				<li><a class="btn_g" href="<?=(isLogged() ? '/denunciar-post/'.$post['id'].'/' : '/registro/');?>"><span class="icons denunciar_post">Denunciar Post</span></a></li>
			</ul>
			</div>
			<ul class="post-estadisticas">
				<li>
					<span class="icons favoritos_post" id="post_favorites_span"><?=mysql_num_rows(mysql_query("SELECT * FROM `favorites` WHERE post = '".$post['id']."'"));?></span><br />
					Favoritos
									</li>
				<li>
					<span class="icons visitas_post"><?=$post['visits'];?></span><br />
					Visitas
				</li>
				<li>
					<span class="icons puntos_post" id="post_points_span"><?php
                    $f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE post = '".$post['id']."'"));
					if(!empty($f['tp'])) {
						echo $f['tp'];
					} else {
						echo '0';
					}
					?></span><br />
					Puntos
				</li>
            			<li>
					<span class="icons monitor" id="numf_post"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '1' && who = '".$post['id']."'"));?></span><br />
					Seguidores
				</li>
			</ul>
			<div class="clearfix"></div>
			<hr class="divider" />
			<div class="tags-block">
				<span class="icons tags_title">Tags:</span>
									 <?php
									 $ex = explode(',', $post['tags']);
									 $c = count($ex);
									 for($i=0;$i<$c;$i++) {
										 echo '<a rel="tag" href="/tags/'.$ex[$i].'/">'.htmlspecialchars($ex[$i]).'</a>';
										 if(($i+1) != $c) { echo ' - '; }
									 }
									 ?>
							</div>
			<ul class="post-cat-date">
				<li><strong>Categor&iacute;a:</strong> <a href="/posts/<?=$cat['urlname'];?>/"><?=$cat['name'];?></a></li>
				<li><strong>Creado:</strong> <span property="dc:date"><?=udate('d.m.Y', $post['time']);?> a las <?=udate('H:i', $post['time']);?> hs.</span></li>
			</ul>
			<div class="clearfix"></div>
			</div>
		</div>
	</div><!-- post contenedor 730px! -->
	<div class="floatR" style="width: 766px; wi\dth: 765px">
		<div class="post-relacionados">
			<h4>Otros posts que te van a interesar:</h4>
			<!--<ul>
								<li class="categoriaPost noticias">
					<a rel="dc:relation" href="/posts/noticias/4102225/Sueldos-de-los-tecnicos-de-futbol.html" title="Sueldos de los tecnicos de futbol">Sueldos de los tecnicos de futbol</a>
				</li>
                </ul>-->
								<ul><?php include($_SERVER['DOCUMENT_ROOT'].'/related-posts.php'); ?></ul>
		</div>
		<div class="banner-300">
			<!-- BEGIN SMOWTION TAG - 728x90 - <?$config=['script_name'];?>: p2p - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "300x250";
smowtion_section = "832735";
smowtion_iframe = 1;
//-->
</script>
<script type="text/javascript"
src="http://ads.smowtion.com/ad.js"> 
</script>
<!-- END SMOWTION TAG - 160x600 - <?$config=['script_name'];?>: p2p - DO NOT MODIFY --></div>
		<div class="clearfix"></div>
	</div>
 
	<a name="comentarios"></a>
	<div id="post-comentarios">
    <?php
	if($currentuser['id'] == $post['author']) {
			echo '<div style="clear: both; text-align: left; border: 1px solid rgb(211, 98, 98); background: none repeat scroll 0% 0% rgb(255, 255, 204); font-size: 13px; margin-top: 10px; margin-bottom: 10px; padding: 15px; width: 735px; margin-left: 50px;">
        	<span style="float: left; width: 550px; margin-top: 11px;">Si hay usuarios que insultan o generan disturbios en tu post puedes bloquearlos haciendo click sobre la opci&oacute;n desplegable de su avatar.</span><img style="float: right" src="/images/bloquear_usuario.png" alt="Bloquear Usuario">
<div style="clear: both;">
    	</div></div>';
		}
		?>
		<div class="comentarios-title">
        <?php
		$query = mysql_query("SELECT * FROM `comments` WHERE post = '".$post['id']."'");
		$crows = mysql_num_rows($query);
		?>
			<div class="box_rss"><a href="/rss/comentarios/<?=$post['id'];?>" class="systemicons sRss"></a></div> <h4 class="titulorespuestas floatL"><span id="comm_num"><?=$crows;?></span> Comentarios</h4>
					<div class="clearfix"></div>
		<hr />
 
	<!-- Paginado -->
    <?php
	if($_GET['comment'] && mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE id = '".mysql_clean($_GET['comment'])."' && post = '".$post['id']."'"))) {
		$cpage = ceil(mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE id <= '".mysql_clean($_GET['comment'])."' && post = '".$post['id']."'"))/100);
	} else {
		$cpage = ceil(mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE post = '".$post['id']."'"))/100);
	}
	$i = ($cpage-1)*100;
	$tcom = mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE post = '".$post['id']."'"));
	$tcomp = ceil($tcom/100);
		echo '<div class="paginadorCom" id="paginador1" style="display:'.($tcom > 100 ? 'block' : 'none').';">
      <div class="before floatL">
      	      	
      		<a href="#" onclick="comments_goto((comm_currentpage-1));return false;" id="comm_b_1"'.($cpage > 1 ? ' class="desactivado"' : '').'><b>&laquo; Anterior</b></a>
      	      </div>
      <div style="float:left;width: 530px">
        <ul id="comm_ul_1">';
		for($x=1;$x<=$tcomp;$x++) {
           echo '<li class="numbers"><a id="pc_1_'.$x.'" href="#" onclick="comments_goto('.$x.');return false;"'.($x == $cpage ? ' class="here"' : '').'>'.$x.'</a></li>';
		}
		echo '</ul>
      </div>
      <div class="floatR next">
                	<a href="#" onclick="comments_goto((comm_currentpage+1));return false;" id="comm_n_1"'.($cpage < $tcomp ? ' class="desactivado"' : '').'><b>Siguiente &raquo;</b></a>
              </div>
      <div class="clearBoth"></div>
    </div>';
	?>
  	<!-- FIN - Paginado -->
 
		</div>
        <?php
	
	echo '<script type="text/javascript">var dh = window.location.hash; var comm_currentpage = '.$cpage.'; var comm_totalpages = '.$tcomp.'; var comm_tcom = '.$tcom.'; var post_private = '.($post['private'] ? 1 : 2).'; var post_id = '.$post['id'].'; var post_author = '.$author['id'].';</script>
		<div id="comentarios">';
		

		if($post['comments'] == '1') {
		  if(!$crows) {
			echo '<div class="clearfix"></div>
				<div style="font-weight: bold; font-size: 14px;text-align: center;color: #666;margin: 20px 0 20px 175px;">Este post no tiene comentarios, &iexcl;S&eacute; el primero!</div>';
		  } else {
			//SE ENVIAN $post y $author!!!!!!!!!!!!!!!!!!!!!!
			/*$cpage = 1;*/
			//include('ajax/post-comments.php');
			include('./ajax/post-comments.php');
          }
		} else {
		echo '<div class="clearfix"></div>
				<div style="font-weight: bold; font-size: 14px;text-align: center;color: #666;margin: 20px 0 20px 175px;">Los comentarios est&aacute;n desactivados</div>';
	    }
			?>
		
<!--F C -->
					</div><!-- COMENTS???? -->
 
	<!-- Paginado -->
    <?php
		// NOTA: Se suma 1 a $cpage, porque en ajax/post-comments.php se resta 1!
		$cpage++;
		echo '<div class="comentarios-title" id="paginador2" style="display:'.($tcom > 100 ? 'block' : 'none').';">
		<div class="paginadorCom">
      <div class="before floatL">

      		<a href="#" onclick="comments_goto((comm_currentpage-1));return false;" id="comm_b_2"'.($cpage > 1 ? ' class="desactivado"' : '').'><b>&laquo; Anterior</b></a>
      	      </div>
      <div style="float:left;width: 530px">
        <ul id="comm_ul_2">';
		for($x=1;$x<=$tcomp;$x++) {
           echo '<li class="numbers"><a id="pc_2_'.$x.'" href="#" onclick="comments_goto('.$x.');return false;"'.($x == $cpage ? ' class="here"' : '').'>'.$x.'</a></li>';
		}
		echo '</ul>
      </div>
      <div class="floatR next">
                	<a href="#" onclick="comments_goto((comm_currentpage+1));return false;" id="comm_n_2"'.($cpage < $tcomp ? ' class="desactivado"' : '').'><b>Siguiente &raquo;</b></a>
              </div>
      <div class="clearBoth"></div>
    </div>
	</div>';
	?>
  	<!-- FIN - Paginado -->
 
 
	<?php
	if(isLogged() && $post['comments'] == '1' && ($author['rank'] == 0 || ($author['rank'] != 0 && $currentuser['rank'] != 0)) && !in_array($currentuser['id'], $author['blocked_array'])) {
		?>
    <div class="miComentario">
		<div id="procesando"><div id="post"></div></div>
		<div class="answerInfo">
			<img class="avatar-48" width="48" height="48" src="/avatares/48/<?=$currentuser['avatar'];?>" alt="Avatar de Usuario" onerror="error_avatar(this);" />
		</div>
		<div class="answerTxt">
		  <div class="Container">
				<div class="error"></div>
								<textarea id="body_comm" class="onblur_effect autogrow" tabindex="1" title="Escribir un comentario" style="resize:none;" onfocus="if(this.value == 'Escribir un comentario') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Escribir un comentario'; }">Escribir un comentario</textarea>
				<div class="buttons" style="text-align:left">
					<div class="floatL">
						<input id="button_add_resp" type="button" onclick="add_comment(<?=$post['id'];?>, document.getElementById('body_comm').value);" class="mBtn btnOk" value="Enviar Comentario" tabindex="2" />
					</div>
					<div class="floatR">
						<a style="font-size:11px" href="javascript:openpopup()">M&aacute;s Emoticones</a>
						<script type="text/javascript">function openpopup(){ var winpops=window.open("/emoticones.php","","width=180px,height=500px,scrollbars,resizable");}</script>
					</div>
					<div id="emoticons" style="float:right">
								
					<?php
					$emoticonos = array(':)' => 'sonrisa', ';)' => 'guino', ':roll:' => 'duda', ':P' => 'lengua', ':D' => 'alegre', ':(' => 'triste', 'X(' => 'odio', ':cry:' => 'llorando', ':twisted:' => 'endiablado', ':|' => 'serio', ':?' => 'duda2', ':cool:' => 'picaro', '^^' => 'sonrizota', ':oops:' => 'timido', '8|' => 'increible', ':F' => 'babas');
					foreach($emoticonos as $code => $name) {
						echo '<a href="#" smile="'.$code.'"><img src="/images/space.gif" align="absmiddle" class="emoticono '.$name.'" alt="'.$name.'" title="'.$name.'" style="margin-right:10px;" /></a>';
					}
					?>
					</div>
 
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
    <? } elseif(!isLogged()) {
			echo '<div class="emptyData">Para poder comentar necesitas estar <a href="/registro/">registrado</a>. O... &iquest;ya tienes usuario? &iexcl;<a href="#" onclick="open_login_box();">Logueate</a>! </div>';
		} ?>
 
	</div><!-- post comentarios! -->
	<div class="clearfix"></div>
 
	<a name="comentarios-abajo"></a>
 
		<br />
	
	<center><a href="#cielo" class="irCielo"><strong>Ir al cielo</strong></a></center>
 
</div><!-- post wrapper! --><div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>