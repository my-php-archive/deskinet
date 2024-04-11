<?php
if(!$group && !$_GET['group']) { die; }
if(!$_GET['s']) { $_GET['s'] = '1'; }
if($_GET['i']) {
include('../config.php');
include('../functions.php');
}
if(!$group) {
	if(!mysql_num_rows(mysql_query("SELECT id FROM `groups` WHERE id = '".mysql_clean($_GET['group'])."'"))) {
		die(error('OOPS!', 'La comunidad no existe', 'Ir a la p&aacute;gina principal', '/'));
	}
	$group['id'] = mysql_clean($_GET['group']);
}
if(!isLogged() && mysql_num_rows(mysql_query("SELECT id FROM `groups` WHERE id = '".mysql_clean($_GET['group'])."' && private = '1'"))) { die('Debes logearte para ver esta comunidad'); }
$q = mysql_query("SELECT rank FROM `group_members` WHERE `group` = '".$group['id']."' && user = '".$currentuser['id']."'");
$myrank = mysql_fetch_array($q);
if($_GET['s'] != '1' && $currentuser['group']['rank'] < 3 && !isAllowedTo('groups_memberlist')) {
		$_GET['s'] = '1';
}
if($_GET['s'] == '1' || $_GET['s'] == '2') {
	$q = "SELECT u.id AS id, u.nick AS nick, u.avatar AS avatar, u.gender AS gen, g.rank AS rank FROM group_members AS g, users AS u WHERE g.group = '".$group['id']."' && u.id = g.user && g.ban = '".($_GET['s'] == '1' ? '0' : '1')."' ORDER BY u.nick ASC";
} elseif($_GET['s'] == '3') {
	$q = "SELECT * FROM `groups_history` WHERE `group` = '".$group['id']."' ORDER BY time DESC";
} else {
	$q = "SELECT u.id AS id, u.nick AS nick, u.avatar AS avatar, u.gender AS gen, g.rank AS rank FROM group_members AS g, users AS u WHERE g.group = '".$group['id']."' && u.id = g.user && u.nick = '".mysql_clean($_GET['s'])."' ORDER BY u.nick ASC";
}
$pp = ($_GET['s'] == '3' ? 50 : 10);
$totalPages = ceil(mysql_num_rows(mysql_query($q))/$pp);
$pag = (!$_GET['p'] || $_GET['p'] < 1 || $_GET['p'] > $totalPages || !preg_match('/^[0-9]+$/', $_GET['p']) ? 1 : mysql_clean($_GET['p']));
$qMin = (($pag-1)*$pp);
$qMax = $qMin+$pp;
$query = mysql_query($q." LIMIT ".$qMin.",".$pp) or die(mysql_error());
$i = 0;
if(!mysql_num_rows($query)) {
	echo '<br />';
	if($_GET['s'] == '2') {
		echo '<div class="emptyData">No hay usuarios suspendidos</div>';
	} elseif($_GET['s'] == '3') {
		echo '<div class="emptyData">No hay acciones</div>';
	} else {
		echo '<div class="emptyData">El usuario no pertenece a la comunidad</div>';
	}
} else {
	//if(mysql_num_rows($query)%2 != 0) { $c = true; }
	if($_GET['s'] != '3') {
		while($fetch = mysql_fetch_array($query)) {
			$i++;
			if($i == 3) { echo '<br />'; $i = 0; }
		//if($c) { $w = '<div style="width:100%;padding: 100px;">'; }
			echo '<ul id="userid_'.$fetch['id'].'">
			<li class="resultBox">
			<h4><a href="/perfil/'.$fetch['nick'].'/" title="Perfil de '.$fetch['nick'].'">'.$fetch['nick'].'</a></h4>
			<div class="floatL avatarBox">
				<a href="/perfil/'.$fetch['nick'].'/" title="Perfil de '.$fetch['nick'].'">
					<img width="75" height="75" src="/avatares/75/'.$fetch['avatar'].'" onerror="error_avatar(this)" />
				</a>
			</div>
			<div class="floatL infoBox">
				<ul>
					<li>Rango: <strong>'.groupRankName($fetch['rank']).'</strong></li>
					<li>Sexo: <strong>'.($fetch['gen'] == 1 ? 'Masculino' : 'Femenino').'</strong></li>
					<li><a href="/mensajes/para/'.$fetch['nick'].'" title="Enviar mensaje">Enviar mensaje</a></li>';
			if(($myrank['rank'] > 2 || isAllowedTo('edit_members')) && $fetch['id'] != $currentuser['id']) {
				echo '<li><a href="#" onclick="groups_admin_user('.$fetch['id'].', '.$group['id'].');return false;" title="Administrar al usuario">Administrar</a></li>';
			}
			echo '</ul>
			</div>
		</li>
		</ul>';
		//if($c) { echo '</div><br />'; unset($c); }
		}
	} else { // GET s
		$rows = mysql_num_rows($query);
		$i = 0;
		while($history = mysql_fetch_array($query)) {
			list($user) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$history['user']."'"));
			list($mod) = mysql_fetch_row(mysql_query("SELECT nick FROM `users` WHERE id = '".$history['mod']."'"));
			switch($history['type']) {
				case '1':
					echo 'Usuario: <a href="/perfil/'.$user.'/"><strong>'.$user.'</strong></a> suspendido por <a href="/perfil/'.$mod.'/"><strong>'.$mod.'</strong></a> el d&iacute;a <strong>'.date('j/n/Y H:i:s', $history['time']).'</strong><br />Raz&oacute;n: <strong style="color:red;">'.htmlspecialchars($history['reason']).'</strong><br />Duraci&oacute;n: <strong>'.($history['duration'] == '0' ? 'Permanente' : $history['duration'].' '.($history['duration'] == '1' ? 'd&iacute;a' : 'd&iacute;as').'</strong> hasta el <strong>'.date('j/n/Y', ($history['time']+($history['duration']*86400)))).'</strong>';
				break;
				case '3':
					echo 'Usuario: <a href="/perfil/'.$user.'/"><strong>'.$user.'</strong></a> rehabilitado por <a href="/perfil/'.$mod.'/"><strong>'.$mod.'</strong></a> el d&iacute;a <strong>'.date('j/n/Y H:i:s', $history['time']).'</strong><br />Raz&oacute;n: <strong style="color:green;">'.htmlspecialchars($history['reason']).'</strong>';
				break;
				case '2':
					echo 'Usuario: <a href="/perfil/'.$user.'/"><strong>'.$user.'</strong></a> cambiado de rango a <strong style="color:blue;">'.groupRankName($history['reason']).'</strong> por <a href="/perfil/'.$mod.'/"><strong>'.$mod.'</strong></a> el d&iacute;a <strong>'.date('j/n/Y H:i:s', $history['time']).'</strong>';
				break;
			}
			echo '<br />';
		}
	} // GET s
	echo '<div id="mgp" class="paginadorBuscador" style="float:left;width:525px;">';
	if($pag > 1) { echo '<div class="before floatL"><a href="#" onclick="groups_miembros_list(false, '.$group['id'].', '.($pag-1).');return false;"><b>&laquo; Anterior</b></a></div>'; }
	echo '<div class="pagesCant">
	<ul style="margin:0 auto;">';
	$endI = ($pag <= 5 ? $pag : 5);
	for($i=1;$i<$endI;$i++) {
		echo '<li class="numbers"><a href="#" onclick="groups_miembros_list(false, '.$group['id'].', '.$i.');return false;">'.$i.'</a></li>';
	}
	echo '<li class="numbers"><a class="here" href="#" onclick="return false;">'.$pag.'</a></li>';
	$endI = (($pag+5) <= $totalPages ? $pag+5 : $totalPages);
	for($i=($pag+1);$i<=$endI;$i++) {
		echo '<li class="numbers"><a href="#" onclick="groups_miembros_list(false, '.$group['id'].', '.$i.');return false;">'.$i.'</a></li>';
	}
	echo '<div class="clearBoth"></div></ul></div>';
	if($pag < $totalPages) { echo '<div class="next floatR"><a href="#" onclick="groups_miembros_list(false, '.$group['id'].', '.($pag+1).');return false;"><b>Siguiente &raquo;</b></a></div>'; }
	echo '</div><script type="text/javascript">var group_members_s = "'.$_GET['s'].'";</script>';
} // rows
?>