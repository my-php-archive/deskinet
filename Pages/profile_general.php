<?php if(!defined('ok')) { die; } ?>
<div class="perfil-content general">
	<div class="widget w-stats clearfix">
	  <div class="title-w clearfix">
		  <h3>Estad&iacute;sticas del usuario</h3><span>
          <?php
		  $query = mysql_query("SELECT time FROM `connected` WHERE user = '".$user['id']."'");
				if(mysql_num_rows($query)) {
					list($oty) = mysql_fetch_row($query);
					$dif = time()-$oty;
					if($dif >= 600) {
						echo '<span style="width:16px;height:16px;" class="systemicons ocupado floatL" title="Ocupado" /></span>';
					} elseif($dif >= 300) {
						echo '<span style="width:16px;height:16px;" class="systemicons ausente floatL" title="Ausente" /></span>';
					} else {
						echo '<span style="width:16px;height:16px;" class="systemicons online floatL" title="Conectado" /></span>';
					}
				} else {
					echo '<span style="width:16px;height:16px;" class="systemicons offline floatL" title="Desconectado" /></span>';
				}
		  ?>
          </span>
		</div>
		<ul>
			<li style="width:150px;padding-left: 5px">
				<?=rankName($user['rank']);?>				<span>Rango</span>
			</li>
			<li>
				<?php
				$f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE user_to = '".$user['id']."'"));
				if(!empty($f['tp'])) {
					echo $f['tp'];
				} else {
					echo '0';
				}
				?>				<span>Puntos</span>
			</li>
			<li>
				<?=mysql_num_rows(mysql_query("SELECT id FROM `posts` WHERE author = '".$user['id']."'"));?>				<span>Posts</span>
			</li>
			<li>
				<?=mysql_num_rows(mysql_query("SELECT id FROM `comments` WHERE author = '".$user['id']."'"));?>				<span>Comentarios</span>
			</li>
			<li>
	 			<p style="display:inline;" id="numf_user"><?=mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$user['id']."'"));?></p>				<span>Seguidores</span>
			</li>
			
		</ul>
	</div>
		<div class="widget w-posts clearfix">
	  <div class="title-w clearfix">
	  	<h3>&Uacute;ltimos Posts creados</h3>
	  	<span><a class="systemicons sRss" href="/rss/posts/usuario/<?=$user['nick'];?>/" title="&Uacute;ltimos Posts de <?=$user['nick'];?>"></a></span>
	  </div>
      <?php
		if(mysql_num_rows($query = mysql_query("SELECT * FROM `posts` WHERE author = '".$user['id']."' ORDER BY time DESC LIMIT 10"))) {
			echo '<ul class="ultimos">';
		 	while($post = mysql_fetch_array($query)) {
				$f = mysql_fetch_array(mysql_query("SELECT SUM(pnum) AS tp FROM `points` WHERE post = '".$post['id']."'"));
				if(empty($f['tp'])) { $f['tp'] = '0'; }
				$cat = mysql_fetch_array(mysql_query("SELECT urlname FROM `categories` WHERE id = '".$post['cat']."'"));
				echo '<li class="clearfix categoriaPost '.$cat['urlname'].'"><a href="/posts/'.$cat['urlname'].'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a> <span>'.$f['tp'].' Puntos</span></li>';
		 	}
			echo '<li class="see-more"><a href="/posts/buscador/'.$config['script_name2'].'/autor/'.$user['nick'].'/">Ver m&aacute;s &raquo;</a></li>
			</ul>';
	  } else {
		  echo '<div class="emptyData">No hay posts</div>';
	  }
	  ?>
			</div>
	
	<div class="widget w-temas clearfix">
	  <div class="title-w clearfix">
		  <h3>&Uacute;ltimos Temas creados</h3>
		  <span><a class="systemicons sRss" href="/rss/temas/usuario/<?=$user['nick'];?>/" title="&Uacute;ltimos Temas de <?=$user['nick'];?>"></a></span>
		</div>
		<?php
			if(mysql_num_rows($query = mysql_query("SELECT id, `group`, title FROM `group_posts` WHERE author = '".$user['id']."' ORDER BY time DESC LIMIT 10"))) {
				echo '<ul class="ultimos">';
				while($post = mysql_fetch_array($query)) {
					list($gurl, $name, $gcat) = mysql_fetch_row(mysql_query("SELECT urlname, name, cat FROM `groups` WHERE id = '".$post['group']."'"));
					list($cat) = mysql_fetch_row(mysql_query("SELECT urlname FROM `group_categories` WHERE id = '".$gcat."'"));
					echo '<li class="clearfix categoriaCom '.$cat.'">
				<a title="'.$cat.' | '.htmlspecialchars($post['title']).'" class="titletema" href="/comunidades/'.$gurl.'/'.$post['id'].'/'.url($post['title']).'.html">'.htmlspecialchars($post['title']).'</a>
				En <a href="/comunidades/'.$gurl.'/">'.htmlspecialchars($name).'</a>
				<span>'.mysql_num_rows(mysql_query("SELECT id FROM `group_comments` WHERE post = '".$post['id']."'")).' respuestas</span>
			</li>';
				}
				echo '<li class="see-more"><a href="javascript:alert(\'El buscador de temas no esta listo :$\');">Ver m&aacute;s &raquo;</a></li>
				</ul>';
		   } else {
			   echo '<div class="emptyData">No hay temas</div>';
		   }
			?>
		</div>
	</div>
<div class="perfil-sidebar">
	<div style="margin-bottom: 10px"><?=advert('300x250');?></div>
		<div class="widget w-medallas clearfix">
		<div class="title-w clearfix">
			<h3>Medallas</h3>
			<span><?=$rows = mysql_num_rows($query = mysql_query("SELECT medal FROM `medals` WHERE user = '".$user['id']."'"));?></span>
		</div>
        <?php
		/*
		Bronce -> 0
		Plata -> 1
		Oro -> 2
		Platino -> 3
		Diamante -> 4
		Great -> 5
		Mod -> 6
		*/
		if($rows) {
			echo '<ul>';
			$medals = array(array(), array(), array(), array(), array(), array(), array());
			while(list($mid) = mysql_fetch_row($query)) {
				$medal = mysql_fetch_assoc(mysql_query("SELECT name, type FROM `medals_data` WHERE id = '".$mid."'"));
				switch(substr($medal['type'], 8)) {
					case 'bronce':
						$medals[0][] = $medal['name'];
					break;
					case 'plata':
						$medals[1][] = $medal['name'];
					break;
					case 'oro':
						$medals[2][] = $medal['name'];
					break;
					case 'platino':
						$medals[3][] = $medal['name'];
					break;
					case 'diamante':
						$medals[4][] = $medal['name'];
					break;
					case 'great-user':
						$medals[5][] = $medal['name'];
					break;
					case 'moderador':
						$medals[6][] = $medal['name'];
					break;
				}
			}
			krsort($medals);
			foreach($medals as $key => $mt) {
				switch($key) {
					case '0':
						$type = 'bronce';
					break;
					case '1':
						$type = 'plata';
					break;
					case '2':
						$type = 'oro';
					break;
					case '3':
						$type = 'platino';
					break;
					case '4':
						$type = 'diamante';
					break;
					case '5':
						$type = 'great-user';
					break;
					case '6':
						$type = 'moderador';
					break;
				}
				foreach($mt as $medal) {
					echo '<li>
					<span title="'.$medal.'" class="icon-medallas medalla-'.$type.'"></span>
					</li>';
				}
			}
			echo '</ul>
					<a class="see-more" href="'.$url.'medallas">Ver detalles &raquo;</a>';
		} else {
			echo '<div class="emptyData">No '.($user['id'] == $currentuser['id'] ? 'tienes' : 'tiene').' medallas</div>';
		}
		?>
				</div>
		<div class="widget w-seguidores clearfix">
		<div class="title-w clearfix">
			<h3>Seguidores</h3>
			<span><?=$rows = mysql_num_rows(mysql_query("SELECT user FROM `follows` WHERE what = '2' && who = '".$user['id']."'"));?></span>
		</div>
        <?php
		if($rows) {
				echo '<ul class="clearfix">';
				$query = mysql_query("SELECT user FROM `follows` WHERE what = '2' && who = '".$user['id']."' ORDER BY time DESC LIMIT 21");
				while(list($fid) = mysql_fetch_row($query)) {
					$fuser = mysql_fetch_assoc(mysql_query("SELECT nick, avatar FROM `users` WHERE id = '".$fid."'"));
					echo '<li><a href="/perfil/'.$fuser['nick'].'/"><img class="img_avatar_user_general" src="/avatares/32/'.$fuser['avatar'].'" alt="'.$fuser['nick'].'" title="'.$fuser['nick'].'" /></a></li>';
				}
				echo '</ul>
					<a class="see-more" href="'.$url.'seguidores">Ver m&aacute;s &raquo;</a>';
		} else {
			echo '<div class="emptyData">No '.($user['id'] == $currentuser['id'] ? 'tienes' : 'tiene').' seguidores</div>';
		}
		?>
			</div>
	
	<div class="widget w-siguiendo clearfix">
	  <div class="title-w clearfix">
		  <h3>Siguiendo</h3>
		  <span><?=$rows = mysql_num_rows(mysql_query("SELECT who FROM `follows` WHERE what = '2' && user = '".$user['id']."'"));?></span>
		</div>
				<?php
		if($rows) {
				echo '<ul class="clearfix">';
				$query = mysql_query("SELECT who FROM `follows` WHERE what = '2' && user = '".$user['id']."' ORDER BY time DESC LIMIT 21");
				while(list($fid) = mysql_fetch_row($query)) {
					$fuser = mysql_fetch_assoc(mysql_query("SELECT nick, avatar FROM `users` WHERE id = '".$fid."'"));
					echo '<li><a href="/perfil/'.$fuser['nick'].'/"><img class="img_avatar_user_general" src="/avatares/32/'.$fuser['avatar'].'" alt="'.$fuser['nick'].'" title="'.$fuser['nick'].'" /></a></li>';
				}
				echo '</ul>
					<a class="see-more" href="'.$url.'siguiendo">Ver m&aacute;s &raquo;</a>';
		} else {
			echo '<div class="emptyData">No '.($user['id'] == $currentuser['id'] ? 'sigues' : 'sigue').' usuarios</div>';
		}
		?>
			</div>
 
	<div class="widget w-comunidades clearfix">
	  <div class="title-w clearfix">
		  <h3><?=($user['id'] == $currentuser['id'] ? 'Mis' : 'Sus');?> comunidades</h3>
		  <span><?=$rows = mysql_num_rows($query = mysql_query("SELECT g.urlname AS url, g.name AS name FROM groups AS g, group_members AS m WHERE m.user = '".$user['id']."' && g.id = m.group ORDER BY m.time ASC"));?></span>
		</div>
				<?php
				if($rows) {
					while($fetch = mysql_fetch_array($query)) {
						$s .= ' - <a href="/comunidades/'.$fetch['url'].'/" title="'.htmlspecialchars($fetch['name']).'">'.htmlspecialchars($fetch['name']).'</a>';
					}
					echo substr($s, 3).'<a class="see-more" href="'.$url.'comunidades">Ver m&aacute;s &raquo;</a>';
				} else {
					echo '<div class="emptyData">No '.($user['id'] == $currentuser['id'] ? 'eres' : 'es').' miembro de ninguna comunidad</div>';
				}
				?>
			</div>
	<div class="widget w-fotos clearfix">
	  <div class="title-w clearfix">
		  <h3><?=($user['id'] == $currentuser['id'] ? 'Mis' : 'Sus');?> Fotos</h3>
		  <span><?=$rows = mysql_num_rows($query = mysql_query("SELECT url FROM `photos` WHERE user = '".$user['id']."' ORDER BY time DESC LIMIT 6"));?></span>
		</div>
        <?php
		if($rows) {
			while(list($url) = mysql_fetch_row($query)) {
				echo '<div id="user_photo_233218" class="photo_small" style="border:none;">
				<a title="Abrir en nueva ventana" target="_blank" href="'.htmlspecialchars($url).'"><img border="0" onerror="$(this).parent(\'div\').remove();" style="max-width: 77px; max-height: 77px;" src="'.htmlspecialchars($url).'"></a>
				</div>';
			}
				echo '<a class="see-more" href="'.$url.'fotos">Ver m&aacute;s &raquo;</a>';
		} else {
			echo '<div class="emptyData">No '.($user['id'] == $currentuser['id'] ? 'tienes' : 'tiene').' fotos</div>';
		}
		?>
			</div>
</div>
<script type="text/javascript">$(document).ready(function(){$('span.icon-medallas, img.img_avatar_user_general').tipsy({'gravity':'s'});});</script>