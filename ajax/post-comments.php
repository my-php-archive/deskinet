<?php
if($_GET['_']) { include('../config.php'); include('../functions.php'); }
if($_GET['post_private']) { $_GET['post_private'] = (int) $_GET['post_private']; }
if(!$post) { if(!$_GET['post_private'] || !$_GET['post_id'] || ($_GET['post_private'] != 1 && $_GET['post_private'] != 2)) { die('0'); } else { $post = array('id' => mysql_clean($_GET['post_id']), 'private' => ($_GET['post_private'] == 1 ? 1 : 0)); } }
if(!$author && !$_GET['author']) { die('01'); }
if(!$author) { $author = array('id' => mysql_clean($_GET['author'])); }
if(!isset($author['rank'])) {
	$author = mysql_fetch_assoc(mysql_query("SELECT id, rank FROM `users` WHERE id = '".$author['id']."'"));
}
if(!ctype_digit($author['id'])) { die('02'); }
if($_GET['cpage']) { $cpage = (int) $_GET['cpage']; }
if(($post['private'] == 1 && !isLogged()) || !mysql_num_rows(mysql_query("SELECT * FROM `posts` WHERE id = '".$post['id']."'"))) { die('03'); }
if(!ctype_digit((string) $cpage)) { $cpage = 1; }
$tp = ceil(mysql_num_rows(mysql_query("SELECT * FROM `comments` WHERE post = '".$post['id']."'")));
if(!$cpage) { $cpage = $tp; }
if($cpage > $tp) { $cpage = $tp; }
if($cpage < 1) { $cpage = 1; }
$cpage--;
$q = "SELECT * FROM `comments` WHERE post = '".$post['id']."' ORDER BY time ".($_GET['lc'] ? 'DESC' : 'ASC')." LIMIT ".($_GET['lc'] ? 1 : ($cpage*100).", ".(($cpage*100)+100));
$query = mysql_query($q);                         
if(!$i) { $i = $_GET['i']; }
if(!ctype_digit((string) $i)) { $i = 0; }
while($comment = mysql_fetch_array($query)) {
$cauthor = mysql_fetch_array(mysql_query("SELECT nick, id, avatar FROM `users` WHERE id = '".$comment['author']."'"));

$complaints = mysql_num_rows(mysql_query("SELECT id FROM `comment_complaints` WHERE comment = '".$comment['id']."'"));
unset($hC, $bY);
if($complaints >= 5) {
	$hC = true;
} elseif($complaints > 0 && ($currentuser['id'] == $author['id'] || isAllowedto('comment_complaints'))) {
	$bY = true;
}

// BLOQUEADOS!
$currentuser['blocked_array'] = (empty($currentuser['blocked']) ? array() : explode(',', $currentuser['blocked']));
?>
<div id="<?=($_GET['lc'] ? 'div_lastcomment' : 'div_cmnt_'.$comment['id']);?>" class="<?=($hC ? 'especial2 ' : ($bY ? 'especial3 ' : ($cauthor['id'] == $author['id'] ? 'especial1 ' : ''))).'cmnt'.$comment['id'];?>"<?=($_GET['lc'] ? ' style="display:none;"' : '');?>>
		<div class="comentario-post clearbeta">
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
				<li class="denunciarc"><a href="#" onclick="comment_bury(<?=$comment['id'];?>);return false;">Denunciar comentario <span></span></a></li>
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
                <? if($bY || $hC){echo'<a href="#" onclick="comment_c('.$comment['id'].');return false;" class="floatL systemicons dcomentarios" title="El comentario tiene denuncias"></a>';}?>
				<div class="floatR answerOptions">
				<ul>
                <?php
				if(isLogged() && ($currentuser['rank'] != '0' || ($currentuser['rank'] == '0' && $author['rank'] == '0'))) {
					list($votes) = mysql_fetch_row(mysql_query("SELECT SUM(amount) FROM `comment_votes` WHERE comment = '".$comment['id']."'"));
					if(!$votes) { $votes = 0; }
					echo '<li class="answerCitar">
					<span class="votos_total" style="float:left;font-weight:bold;color:'.($votes >= 0 ? 'green' : 'red').';">'.($votes > 0 ? '+' : '').$votes.'</span>
					<span class="floatR">
      			<a href="#" class="thumbs thumbsUp" title="Votar positivo" onclick="comment_vote('.$comment['id'].', 1, this);return false;"></a>
        			<a href="#" class="thumbs thumbsDown" title="Votar negativo" onclick="comment_vote('.$comment['id'].', -1, this);return false;"></a>
					</span>
        		</li>
					<li><a href="#" onclick="cite_comment('.$comment['id'].', \''.$cauthor['nick'].'\');return false;"><span class="citarAnswer"></span></a></li>';
                	if($post['author'] == $currentuser['id'] || isAllowedTo('deletecomments')) {
								echo '<li><a href="#" onclick="delete_comment('.$comment['id'].');return false;"><img src="/images/borrar.png" alt="Borrar" title="Borrar comentario" align="absmiddle" /></a>';
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
<? } ?>