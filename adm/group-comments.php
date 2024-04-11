<?php
//if(!isLogged()) { die('No estas logeado'); }
if($_GET['if']) {
	include('../config.php');
	include('../functions.php');
	if(!$_GET['group'] || !mysql_num_rows($qgroup = mysql_query("SELECT * FROM `groups` WHERE id = '".mysql_clean($_GET['group'])."'"))) { die('Error de usuario'); }
	$group = mysql_fetch_array($qgroup);
	if(mysql_num_rows($q = mysql_query("SELECT * FROM `group_members` WHERE `group` = '".$group['id']."' AND user = '".$currentuser['id']."'"))) {
		$currentuser['group'] = mysql_fetch_array($q);
		$currentuser['isMember'] = true;
	}
	if(!mysql_num_rows($qpost = mysql_query("SELECT id FROM `group_posts` WHERE id = '".mysql_clean($_GET['post'])."' && `group` != '".$group['id']."'"))) {
		die('No existe el post o no pertenece a la comunidad');
	}
} else {
	if(!$group || !is_array($group) || !mysql_num_rows(mysql_query("SELECT * FROM `groups` WHERE id = '".mysql_clean($group['id'])."'"))) { die('¬¬'); }
}
if($group['private'] == '1' && !isLogged()) { die('El grupo es privado, unete para ver los comentarios'); }
//-------------------------------
if(!$post) { if(!$_GET['post_private'] || !$_GET['post_id'] || ($_GET['post_private'] != 1 && $_GET['post_private'] != 2)) { die('0'); } else { $post = array('id' => mysql_clean($_GET['post_id']), 'private' => ($_GET['post_private'] == 1 ? 1 : 0)); } }
if(!$author && !$_GET['author']) { die('01'); }
if(!$author) { $author = array('id' => mysql_clean($_GET['author'])); }
if(!eregi('^[0-9]{1,}$', $author['id'])) { die('02'); }
if($_GET['cpage']) { $cpage = (int) $_GET['cpage']; }
if(!mysql_num_rows(mysql_query("SELECT * FROM `posts` WHERE id = '".$post['id']."'"))) { die('03'); }
if(!eregi('^[0-9]{1,}$', $cpage)) { $cpage = 1; }
$tp = ceil(mysql_num_rows(mysql_query("SELECT * FROM `group_comments` WHERE post = '".$post['id']."'")));
if(!$cpage) { $cpage = $tp; }
if($cpage > $tp) { $cpage = $tp; }
if($cpage < 1) { $cpage = 1; }
$cpage--;
$q = "SELECT * FROM `group_comments` WHERE post = '".$post['id']."' ORDER BY time ".($_GET['lc'] ? 'DESC' : 'ASC')." LIMIT ".($_GET['lc'] ? 1 : ($cpage*20).", ".(($cpage*20)+20));
$query = mysql_query($q);
if(!$i) { $i = $_GET['i']; }
if(!ereg('^[0-9]{1,}$', $i)) { $i = 0; }
//-----------------------
while($comment = mysql_fetch_array($query)) {
	$cauthor = mysql_fetch_array(mysql_query("SELECT id, nick FROM `users` WHERE id = '".$comment['author']."'"));
	echo '<div class="respuesta clearfix" id="comment_'.$comment['id'].'">
<div class="answerInfo">
	<h3><a href="/perfil/'.$cauthor['nick'].'">'.$cauthor['nick'].'</a></h3>
</div>
<div class="answerTxt">
	<div class="answerContainer">
		<div class="Container"><img class="dialogBox" src="/images/dialog.gif" alt="" />
			<div class="answerOptions">
				<div class="floatL metaDataA">
					#'.$i++.' - <span title="'.udate('d.m.Y', $comment['time']).' a las '.udate('H:i', $comment['time']).' hs.">'.timeFrom($comment['time']).'</span>
				</div>
				<ul class="floatR">';
				if(isLogged()) {
					$first = ' class="answerCitar"';
					if($currentuser['isMember'] && $post['comments'] == '1') {
						echo '<li'.$first.'>
						<a href="#" onclick="cite_comment('.$comment['id'].', \''.$author['nick'].'\', true);return false;" title="Citar Comentario">
						<img src="/images/space.gif" class="citarAnswer" alt="Citar" title="Citar comentario" />
					</a>
					</li>';
						$first = '';
					}
					if($currentuser['id'] != $cauthor['id']) {
						echo '<li'.$first.' id="buser_1_'.$cauthor['id'].'" style="display:'.(in_array($cauthor['id'], $currentuser['blocked_array']) ? 'none' : 'block').';"><a href="#" onclick="buser('.$cauthor['id'].', true);return false;"><img src="/images/bloquear.png" alt="Bloquear" title="Bloquear usuario" /></a></li>
							<li'.$first.' id="buser_2_'.$cauthor['id'].'" style="display:'.(in_array($cauthor['id'], $currentuser['blocked_array']) ? 'block' : 'none').';"><a href="#" onclick="buser('.$cauthor['id'].', false);return false;"><img src="/images/desbloquear.png" alt="Desbloquear" title="Desbloquear usuario" /></a></li>
							<li><a href="/mensajes/para/'.$cauthor['nick'].'"><img src="/images/space.gif" class="systemicons messages" alt="Enviar mensaje" title="Enviar un mensaje a '.$cauthor['nick'].'" /></a></li>';
					}
				}
				echo '</ul>
				<div class="clearBoth"></div>
			</div>
			<div class="textA" id="text_'.$comment['id'].'">
			'.bbcode($comment['message']).'</div>
		</div>
	</div>
</div>
</div>';
}
} // MNR
?>