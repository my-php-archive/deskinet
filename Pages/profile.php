<?php
// Comprobar si accede directamente
if(!defined($config['define'])) { header('Location: /index.php'); }
define('ok', true);
$sl = (!isLogged() ? 3 : ($user['id'] == $currentuser['id'] ? 1 : 2));
if($currentuser['id'] == $user['id']) { $sl = 0; }
// faltaria para los amigos...

// BLOQUEADOS!
$currentuser['blocked_array'] = (empty($currentuser['blocked']) ? array() : explode(',', $currentuser['blocked']));

$tab = 'general';
$currenttab = '1';
switch($_GET['tab']) {
	case 'informacion': $tab = 'info'; $currenttab = '2'; break;
	case 'comunidades':
		$query = mysql_query("SELECT g.name, g.urlname, g.cat, g.avatar FROM groups AS g, group_members AS m WHERE m.user = '".$user['id']."' && g.id = m.group ORDER BY m.time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'groups';
			$currenttab = '3';
		}
	break;
	case 'fotos':
		$tab = 'photos';
		$query = mysql_query("SELECT url, `desc` FROM `photos` WHERE user = '".$user['id']."' ORDER BY time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'photos';
			$currenttab = '4';
		}
	break;
	case 'seguidores':
		$tab = 'followers';
		$query = mysql_query("SELECT u.nick, u.avatar, u.personal_text, u.country FROM follows AS f, users AS u WHERE f.what = '2' && f.who = '".$user['id']."' && u.id = f.user ORDER BY f.time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'followers';
			$currenttab = '5';
		}
	break;
	case 'siguiendo':
		$tab = 'following';
		$query = mysql_query("SELECT u.nick, u.avatar, u.personal_text, u.country FROM follows AS f, users AS u WHERE f.what = '2' && f.user = '".$user['id']."' && u.id = f.who ORDER BY f.time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'following';
			$currenttab = '6';
		}
	break;
	case 'medallas':
		$tab = 'medals';
		$query = mysql_query("SELECT d.*, m.link, m.link_title, m.time FROM medals AS m, medals_data AS d WHERE m.user = '".$user['id']."' && d.id = m.medal ORDER BY time DESC");
		if(mysql_num_rows($query)) {
			$tab = 'medals';
			$currenttab = '7';
		}
	break;
}
?>
<script type="text/javascript">var profile_current_tab = <?=$currenttab;?>;var profile_current_user = '<?=$user['id'];?>';</script>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
 
 
<style type="text/css"> 
#cuerpocontainer {
	padding: 0!important;
	width: 960px!important;
}
</style>
 
<div class="perfil-user clearfix <?=rankUrl(rankName($user['rank']));?>">
		<div class="perfil-box clearfix">
			<div class="perfil-avatar">
				<img src="/avatares/120/<?=$user['avatar'];?>" alt="" onerror="error_avatar(this);" />
			</div>
			<div class="perfil-info">
				<h1 class="nick"><?=htmlspecialchars($user['nick']).($user['name_show'] >= $sl && !empty($user['name']) ? ' <span class="name">('.htmlspecialchars($user['name']).')</span>' : '');?></h1>
				<? if($user['personal_text'] != '' && $user['name_show'] >= $sl) { echo '<span class="frase-personal">'.htmlspecialchars($user['personal_text']).'</span><br />'; }
				switch(date('n', $user['reg_time'])) {
					case '1': $month = 'Enero'; break;
					case '2': $month = 'Febrero'; break;
					case '3': $month = 'Marzo'; break;
					case '4': $month = 'Abril'; break;
					case '5': $month = 'Mayo'; break;
					case '6': $month = 'Junio'; break;
					case '7': $month = 'Julio'; break;
					case '8': $month = 'Agosto'; break;
					case '9': $month = 'Septiembre'; break;
					case '10': $month = 'Octubre'; break;
					case '11': $month = 'Noviembre'; break;
					case '12': $month = 'Diciembre'; break;
				}
				$age = date('Y')-$user['birth_year'];
				if($user['birth_day'] < date('j') && $user['birth_month'] < date('n')) {
					$age--;
				}
				echo '<span class="bio"> Es '.($user['gender'] == '1' ? 'un hombre' : 'una mujer');
				if($user['birth_show'] >= $sl) {
					echo ' de '.$age.' a&ntilde;os.';
				} else {
					echo '.';
				}
				echo ' Vive en '.numtocname($user['country']).' y se uni&oacute; a la familia de '<?$config=['script_name'];?>' el '.date('j', $user['reg_time']).' de '.$month.' de '.date('Y', $user['reg_time']).'.';
				if($user['company'] && $user['company_show'] >= $sl) { echo ' Trabaja en '.htmlspecialchars($user['company']).'.'; }
				?>
                </span>
								<br />
                                <?php
									if(isLogged() && $currentuser['id'] != $user['id']) {
										echo '<a id="buser_1_'.$user['id'].'" class="bloquearU" href="#" onclick="buser('.$user['id'].', true);return false;" style="color:#FFF;display:'.(in_array($user['id'], $currentuser['blocked_array']) ? 'none' : 'block').';">Bloquear</a><a id="buser_2_'.$user['id'].'" class="desbloquearU" href="#" onclick="buser('.$user['id'].', false);return false;" style="color:#FFF;display:'.(in_array($user['id'], $currentuser['blocked_array']) ? 'block' : 'none').';">Desbloquear</a>';
									}
									if(isAllowedTo('ban')) {
										$banned = (mysql_num_rows(mysql_query("SELECT * FROM `bans` WHERE user = '".$user['id']."' && active = '1'")) ? true : false);
										echo '<a style="color:#FFF;margin-left:10px;display:'.($banned ? 'none' : 'block').';" id="ban_user_1" href="#" onclick="ban_user('.$user['id'].', 1);return false;" class="bloquearU">Banear</a><a style="color:#FFF;margin-left:10px;display:'.($banned ? 'block' : 'none').';" id="ban_user_2" href="#" onclick="ban_user('.$user['id'].', 2);return false;" class="desbloquearU">Desbanear</a>';
									}
							if($user['id'] != $currentuser['id'] && isLogged()) {
								$rows = mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$user['id']."' && user = '".$currentuser['id']."'"));
                            	echo '<a id="unfollow_user" style="display:'.($rows ? 'block' : 'none').';" class="btn_g" href="#" onclick="follow(2, '.$user['id'].', $(this).children(\'span\'), this, true);return false;"><span class="icons unfollow">Dejar de seguir</span></a>
								<a id="follow_user" style="display:'.(!$rows ? 'block' : 'none').';" class="btn_g" href="#" onclick="follow(2, '.$user['id'].', $(this).children(\'span\'), this);return false;"><span class="icons follow">Seguir Usuario</span></a>';
							}
							?>
							</div>
		</div>
	<div class="menu-tabs-perfil clearfix">
		
			<ul>
				<li id="profile_tab_1"<?=($tab=='general' ? ' class="selected"' : '');?>><a href="<?=$url;?>" onclick="profile_tabs(1);return false;">General</a></li>
				<li id="profile_tab_2"<?=($tab=='info' ? ' class="selected"' : '');?>><a href="<?=$url;?>informacion/" onclick="profile_tabs(2);return false;">Informaci&oacute;n</a></li>
				<?php
                if(mysql_num_rows(mysql_query("SELECT id FROM `group_members` WHERE user = '".$currentuser['id']."'"))) {
					echo '<li id="profile_tab_3"'.($tab=='groups' ? ' class="selected"' : '').'><a href="'.$url.'comunidades/" onclick="profile_tabs(3);return false;">Comunidades</a></li>';
				}
				if(mysql_num_rows(mysql_query("SELECT id FROM `photos` WHERE user = '".$currentuser['id']."'"))) {
					echo '<li id="profile_tab_4"'.($tab=='photos' ? ' class="selected"' : '').'><a href="'.$url.'fotos/" onclick="profile_tabs(4);return false;">Fotos</a></li>';
				}
				if(mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && who = '".$user['id']."'"))) {
					echo '<li id="profile_tab_5"'.($tab=='followers' ? ' class="selected"' : '').'><a href="'.$url.'seguidores/" onclick="profile_tabs(5);return false;">Seguidores</a></li>';
				}
				if(mysql_num_rows(mysql_query("SELECT id FROM `follows` WHERE what = '2' && user = '".$user['id']."'"))) {
					echo '<li id="profile_tab_6"'.($tab=='following' ? ' class="selected"' : '').'><a href="'.$url.'siguiendo/" onclick="profile_tabs(6);return false;">Siguiendo</a></li>';
				}
				if(mysql_num_rows(mysql_query("SELECT id FROM `medals` WHERE user = '".$user['id']."'"))) {
					echo '<li id="profile_tab_7"'.($tab=='medals' ? ' class="selected"' : '').'><a href="'.$url.'medallas/" onclick="profile_tabs(7);return false;">Medallas</a></li>';
				}
				if($user['id'] != $currentuser['id'] && isLogged()) {
					echo '<li class="enviar-mensaje"><a href="/mensajes/para/'.$user['nick'].'/"><span class="systemicons messages floatL" style="margin-right:5px"></span>Enviar Mensaje</a></li>';
				}
				?>
                <li id="perfil_loading"><img src="/images/loading.gif" width="16" height="16" alt="Cargando" /></li>
			</ul>
		</div>
	</div>
	<div class="perfil-main clearfix <?=rankUrl(rankName($user['rank']));?>">
	<? include('./Pages/profile_'.$tab.'.php'); ?>
	</div>
<div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div>