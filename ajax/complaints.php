<?php
if(!defined('admin')) { die; }
if(!isAllowedTo('complaints')) { die; }
$sort_by = (!$_GET['sort_by'] || ($_GET['sort_by'] != 'nick' && $_GET['sort_by'] != 'mod' && $_GET['sort_by'] != 'reason' && $_GET['sort_by'] != 'from' && $_GET['sort_by'] != 'end' && $_GET['sort_by'] != 'active') ? 'from' : mysql_clean($_GET['sort_by']));
  // Por si alguno se le ocurre leer esto... no me quise complicar la vida, asi que lo hice a las malas...
  $posts = array();
  $query = mysql_query("SELECT DISTINCT post FROM `complaints` GROUP BY post ORDER BY COUNT(*) DESC") or die(mysql_error());
  if(!mysql_num_rows($query)) { echo 'No hay posts en revisi&oacute;n en este momento'; } else {
  	while($f = mysql_fetch_array($query)) { if(!in_array($f['post'], $posts)) { $posts[] = $f['post']; } }
  	$c = count($posts);
	echo '<script type="text/javascript">var post_c_n = new Array();</script>';
  	for($i=0;$i<$c;$i++) {
		$qpost = mysql_fetch_array(mysql_query("SELECT id, cat, title, time, author FROM `posts` WHERE id = '".$posts[$i]."'"));
		$cat = mysql_fetch_array(mysql_query("SELECT name, urlname FROM `categories` WHERE id = '".$qpost['cat']."'"));
		$author = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$qpost['author']."'"));
		echo '<div id="post_d_'.$qpost['id'].'"><span onmouseover="this.style.backgroundColor = \'transparent\';" class="categoriaPost '.$cat['urlname'].'" alt="'.$cat['name'].'" title="'.$cat['name'].'"></span> ('.gmdate('d/m/Y H:i', $qpost['time']).') <strong><a href="/posts/'.$cat['urlname'].'/'.$qpost['id'].'/'.url($qpost['title']).'.html" target="_blank">'.htmlspecialchars($qpost['title']).'</a></strong> por <a href="/perfil/'.$author['nick'].'/" target="_blank">'.$author['nick'].'</a><br /><br /><a class="btnActions" style="border:1px solid #0C0;background-color:#6FD966;" href="#" onclick="admin_complaints_action(\'accept\', '.$qpost['id'].');return false;">Aceptar</a><a class="btnActions" href="#" onclick="admin_complaints_action(\'validate\', '.$qpost['id'].');return false;" title="hola">Validar</a><a class="btnActions" style="border:1px solid #C00;background-color:#DC535C;" href="#" onclick="admin_complaints_action(\'reject\', '.$qpost['id'].');return false;">Rechazar</a><br /><br /><div style="clear:both"></div>';
		$comp = mysql_query("SELECT * FROM `complaints` WHERE post = '".$qpost['id']."' ORDER BY time DESC") or die(mysql_error());
		$compr = mysql_num_rows($comp);
		$l = 0;
		$nl = 1;
		echo '<script type="text/javascript">post_c_n['.$qpost['id'].'] = '.$compr.';</script>';
		echo '<a href="#s" onclick="admin_complaints_show(this, '.$qpost['id'].', \'all\');return false;">Ver todos</a><br />';
		while($com = mysql_fetch_array($comp)) {
			$l++;
			$u = mysql_fetch_array(mysql_query("SELECT nick FROM `users` WHERE id = '".$com['user']."'"));
			if($l == 1) { echo '<a href="#s" onclick="admin_complaints_show(this, '.$qpost['id'].', '.$nl.');return false;" class="link'.$qpost['id'].'">Ver 5 m&aacute;s</a><br />'; }
			echo '<div class="perfil_comentario pc'.$qpost['id'].' nl'.$nl.' cid'.$com['id'].'" style="display:none;"><div class="floatR"><a class="btnActions" href="#" onclick="if(confirm(\'&iquest;Seguro que quieres borrar esta denuncia?\nBorrar&aacute;s la denuncia pero no el post.\n\nEsto debes usarlo solo si esta denuncia no es correcta, por no estar justificada (ser spam)\nComo por ejemplo, si la raz&oacute;n fuera algo como fefigFIgfI...\')){admin_delete_complaint('.$qpost['id'].', '.$com['id'].');}return false;" title="Borrar denuncia"><img src="/images/borrar.png" alt="Borrar denuncia" />Borrar denuncia</a></div><a href="/perfil/'.$u['nick'].'/">'.$u['nick'].'</a> ('.gmdate('d.m.Y H:i:s', $com['time']).'):<br />Raz&oacute;n: ';
			switch($com['reason']) {
				case 0: echo 'Re-post'; break;
				case 1: echo 'Se hace Spam'; break;
				case 2: echo 'Tiene links muertos'; break;
				case 3: echo 'Es Racista o irrespetuoso'; break;
				case 4: echo 'Contiene informaci&oacute;n personal'; break;
				case 5: echo 'El Titulo esta en may&uacute;scula'; break;
				case 6: echo 'Contiene Pedofilia'; break;
				case 7: echo 'Es Gore o asqueroso'; break;
				case 8: echo 'Est&aacute; mal la fuente'; break;
				case 9: echo 'Post demasiado pobre / Crap'; break;
				case 10: echo $config['script_name'].' no es un foro'; break;
				case 11: echo 'No cumple con el protocolo'; break;
				case 12: echo 'Otra raz&oacute;n (especificar)'; break;
			}
			echo '<br />Comentario:<br />'.$com['comment'].'</div>';
			if($l == 5) { $l = 0; $nl++; }
		}
		if(($i+1) != $c) { echo '<hr />'; }
		echo '</div>'; // div de todo el post
	}
  }
	?>