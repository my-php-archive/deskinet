<?php
//if(!isLogged()) { die('No estas logeado'); }
if($_GET['_']) {
	include('../config.php');
	include('../functions.php');
	if(!$_GET['group'] || !mysql_num_rows($qgroup = mysql_query("SELECT * FROM `groups` WHERE id = '".mysql_clean($_GET['group'])."'"))) { die('Error de usuario'); }
	$group = mysql_fetch_array($qgroup);
	if(mysql_num_rows($q = mysql_query("SELECT * FROM `group_members` WHERE `group` = '".$group['id']."' AND user = '".$currentuser['id']."'"))) {
		$currentuser['group'] = mysql_fetch_array($q);
		$currentuser['isMember'] = true;
	}
	/*if(!mysql_num_rows($qpost = mysql_query("SELECT id FROM `group_posts` WHERE id = '".mysql_clean($_GET['post_id'])."' && `group` != '".$group['id']."'"))) {
		die('No existe el post o no pertenece a la comunidad');
	}*/
} else {
	if(!$group || !is_array($group) || !mysql_num_rows(mysql_query("SELECT * FROM `groups` WHERE id = '".mysql_clean($group['id'])."'"))) { die('¬¬'); }
}
if($group['private'] == '1' && !isLogged()) { die('El grupo es privado, unete para ver los comentarios'); }
//-------------------------------
if(!$post) { if(!$_GET['post_private'] || !$_GET['post_id'] || ($_GET['post_private'] != 1 && $_GET['post_private'] != 2)) { die('0'); } else { $post = array('id' => mysql_clean($_GET['post_id']), 'private' => ($_GET['post_private'] == 1 ? 1 : 0)); } }
if(!$author && !$_GET['author']) { die('01'); }
if(!$author) { $author = array('id' => mysql_clean($_GET['author'])); }
if(!ctype_digit($author['id'])) { die('02'); }
if($_GET['cpage']) { $cpage = (int) $_GET['cpage']; }
if(!mysql_num_rows(mysql_query("SELECT * FROM `group_posts` WHERE id = '".$post['id']."' && `group` = '".$group['id']."'"))) { die('03'); }
if(!ctype_digit((string) $cpage)) { $cpage = 1; }
$tp = ceil(mysql_num_rows(mysql_query("SELECT * FROM `group_comments` WHERE post = '".$post['id']."'")));
if(!$cpage) { $cpage = $tp; }
if($cpage > $tp) { $cpage = $tp; }
if($cpage < 1) { $cpage = 1; }
$cpage--;
$q = "SELECT * FROM `group_comments` WHERE post = '".$post['id']."' ORDER BY time ".($_GET['lc'] ? 'DESC' : 'ASC')." LIMIT ".($_GET['lc'] ? 1 : ($cpage*20).", ".(($cpage*20)+20));
$query = mysql_query($q);
if(!$i) { $i = $_GET['i']; }
if(!ctype_digit((string) $i)) { $i = 0; }
//-----------------------
$currentuser['blocked_array'] = (empty($currentuser['blocked']) ? array() : explode(',', $currentuser['blocked']));
// LOL ^
while($comment = mysql_fetch_array($query)) {
	$cauthor = mysql_fetch_array(mysql_query("SELECT id, nick, avatar FROM `users` WHERE id = '".$comment['author']."'"));
   ?>
   <div id="<?=($_GET['lc'] ? 'div_lastcomment' : 'div_cmnt_'.$comment['id']);?>" class="<?=($hC ? 'especial2 ' : ($bY ? 'especial3 ' : ($cauthor['id'] == $author['id'] ? 'especial1 ' : ''))).'cmnt'.$comment['id'];?>"<?=($_GET['lc'] ? ' style="display:none;"' : '');?>>
		<div class="respuesta-post clearbeta">
		<div class="avatar-box">
			<a href="/perfil/<?=$cauthor['nick'];?>/">
				<!--<img width="48" height="48" style="position:relative;z-index:1" class="avatar-48 lazy" src="/avatares/48/av.gif" title="Avatar de <?=$cauthor['nick'];?>" onerror="error_avatar(this);" />-->
				<img width="48" height="48" style="position:relative;z-index:1" class="avatar-48 lazy" src="/avatares/48/<?=$cauthor['avatar'];?>" title="Avatar de <?=$cauthor['nick'];?>" onerror="error_avatar(this);" />
			</a>
            <?php
			if(isLogged() && $currentuser['id'] != $cauthor['id']) {
				$imh = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE user = '".$currentuser['id']."' && what = '2' && who = '".$cauthor['id']."'"));
			?>
						<ul>

				<li class="enviar-mensaje"><a href="/mensajes/para/<?=$cauthor['nick'];?>/">Enviar Mensaje <span></span></a></li>
                <li class="bloquear" id="buser_1_<?=$cauthor['id'];?>" style="display:<?=(in_array($cauthor['id'], $currentuser['blocked_array']) ? 'none' : 'block');?>;"><a href="#" onclick="buser(<?=$cauthor['id'];?>, true);return false;">Bloquear <span></span></a></li>
				<li class="bloquear" id="buser_2_<?=$cauthor['id'];?>" style="display:<?=(in_array($cauthor['id'], $currentuser['blocked_array']) ? 'block' : 'none');?>;"><a href="#" onclick="buser(<?=$cauthor['id'];?>, false);return false;">Desbloquear <span></span></a></li>
                <li class="seguir follow_user_<?=$cauthor['id'];?>" style="display:<?=($imh ? 'none' : 'block');?>;"><a onclick="follow(2, <?=$cauthor['id'];?>, this, this.parentNode, false, false, false, true);">Seguir usuario <span></span></a></li>
                <li class="seguir unfollow_user_<?=$cauthor['id'];?>" style="display:<?=(!$imh ? 'none' : 'block');?>;"><a onclick="follow(2, <?=$cauthor['id'];?>, this, this.parentNode, true, false, false, true);">Dejar de seguir <span></span></a></li>
							</ul>
                            <? } ?>
					</div>
		<div class="comment-box">
			<div class="dialog-c">
			</div>
			<div class="comment-info clearbeta"><a name="c<?=$comment['id'];?>"></a>
				<div class="floatL">
				#<?=++$i;?> <a class="nick" href="/perfil/<?=$cauthor['nick'];?>"><?=$cauthor['nick'];?></a> dijo <span title="<?=udate('d.m.Y', $comment['time']);?> a las <?=udate('h:s', $comment['time']);?> hs."><?=strtolower(timefrom($comment['time']));?></span>:
				</div>
                <div class="floatR answerOptions">
				<ul>
                <?php
				if(isLogged() && ($currentuser['rank'] != '0' || ($currentuser['rank'] == '0' && $author['rank'] == '0'))) {
					list($votes) = mysql_fetch_row(mysql_query("SELECT SUM(amount) FROM `comment_votes` WHERE comment = '".$comment['id']."'"));
					if(!$votes) { $votes = 0; }
					echo '<li class="answerCitar"><a href="#" onclick="cite_comment('.$comment['id'].', \''.$cauthor['nick'].'\', true);return false;"><span class="citarAnswer"></span></a></li>';
                	if($post['author'] == $currentuser['id'] || isAllowedTo('groups_delete_comments') || $currentuser['group']['rank'] >= 3) {
								echo '<li><a href="#" onclick="delete_comment('.$comment['id'].', true);return false;"><img src="/images/borrar.png" alt="Borrar" title="Borrar comentario" align="absmiddle" /></a>';
					}
				}
				?>
				</ul>
				</div>
 			</div>
			<div class="comment-content"><?=($hC ? '<a href="#" onclick="$(this).fadeOut(\'normal\',function(){$(this).next().slideDown(\'normal\');});return false;">El comentario puede ser peligroso, haz click para verlo</a><div style="display:none;">'.bbcode($comment['message'], false).'</div>' : bbcode($comment['message'], false));?></div>
		</div>
	</div>
</div>
<? }
//} // MNR
?>